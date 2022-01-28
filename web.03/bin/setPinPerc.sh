#!/bin/bash
#
#setPinPerc.sh rsID goalHeight goalAngle
# start=$(echo '('`date +"%s.%N"` ' * 1000000)/1' | bc)
start=$(echo "("$(date +"%s.%N")"* 1000)/1" | bc)

# SHMDIR="/dev/shm/raffStore.ad7"
SHMDIR="/dev/shm/raffStore"
CURRENTVALUEFILE=$SHMDIR"/currentvalues.dat"
LOCKDIR=$SHMDIR"/lock.setPinPerc.dir"
LOCKDIRID=$LOCKDIR"."$1
LOCKDIRRESET=$SHMDIR"/lock.dir"
PIDFILE=$LOCKDIR"/lock.setPinPerc.pid"

RaffStoreID=$1
GHEIGHT=$2
GANGLE=$3

OFS=$IFS;
# IFS='\n';

function onExit() {
  IFS=$OFS
  touch $PIDFILE;
#we delete the entry out of the current value file
  (
    unset lockUno
    exec {lockUno}< $CURRENTVALUEFILE
    flock -e -w 1 $lockUno || { echo "cannot lock current value file for setPinPerc.sh "$RaffStoreID >&2; exit 1;}
    cat $CURRENTVALUEFILE | grep -v ^$RaffStoreID >> $CURRENTVALUEFILE"."$RaffStoreID".tmp";
    cat $CURRENTVALUEFILE"."$RaffStoreID".tmp" | sort -n > $CURRENTVALUEFILE;
    rm -rf $CURRENTVALUEFILE"."$RaffStoreID".tmp"
  #   sleep 30
  )
#   remove own pid from pidfile
#we delete our pid from the pidfile
  (
    unset lockUno
    exec {lockUno}< $PIDFILE
    flock -e -w 1 $lockUno || { echo "cannot lock pidfile for setPinPerc.sh "$RaffStoreID >&2; exit 1;}
    cat $PIDFILE | grep -v ^$$" rsID" > $PIDFILE".tmp";
    cat $PIDFILE".tmp" > $PIDFILE;
    rm -rf $PIDFILE".tmp"
  )
  rm -rf $LOCKDIRID;
#   remove the locking directory when no longer needed
#   --has to be implemented--
#   rm -rf $LOCKDIR
}

# current values file has to be initiated from resetRS.sh
if [ ! -f $CURRENTVALUEFILE ];
then
  echo "current values file missing" >&2
  exit 1
fi

#should not happen because current value file is not available
#during executing of resetRS.sh
if [ -d $LOCKDIRRESET ];
then
  echo "resetRS.sh is running, exiting." >&2;
  exit 1;
fi

#we make a locking directory for all setPinPerc.sh for all raffstore ids
if [ ! -d $LOCKDIR ];
then
  mkdir $LOCKDIR;
fi

#We want to be the only instance of this bash-script for a specific ID
if mkdir $LOCKDIRID; then
  echo "Locking succeeded" >&2
else
  echo "Lock failed - exit" >&2
  exit 1
fi

trap onExit EXIT;

#we want to show our presence
touch $PIDFILE;
(
  unset lockUno
  exec {lockUno}< $PIDFILE
  flock -e -w 1 $lockUno || { echo "cannot lock pidfile for setPinPerc.sh "$RaffStoreID >&2; exit 1;}
  echo $$" rsID:"$RaffStoreID > $PIDFILE
#   sleep 30
)

#read the current value file
exec 200< $CURRENTVALUEFILE;
while read -u 200 eins zwei drei vier fuenf sechs sieben; do
       rsID+=($eins);
    PinUpId+=($zwei);
  PinDownId+=($drei);
  MaxHeight+=($vier);
   MaxAngle+=($fuenf);
    CHeight+=($sechs);
     CAngle+=($sieben);
#   echo $eins;
done;

for ((i=0; i<${#rsID[*]}; i++));
do
  echo "rsID "${rsID[i]}
  if [[ ${rsID[i]} =~ ^[-0-9]+$ ]]
  then
    if [[ ${rsID[i]} == $RaffStoreID ]]
    then
      echo "work on "${rsID[i]};

      dHeight=$( echo $GHEIGHT - ${CHeight[i]} | bc );
      echo "dheight" $dHeight "MaxHeight" ${MaxHeight[i]};

      PinId=-1;
      if [ $dHeight -lt 0 ]
      then
        PinId=${PinDownId[i]};
        dHeight=$( echo $dHeight | awk -F- '{print $NF}' )
      elif [ $dHeight -gt 0 ]
      then
        PinId=${PinUpId[i]}
      fi


      PinTime=$( echo "("$dHeight*${MaxHeight[i]}")"/100.0 | bc -l; )
      echo "PinId" $PinId "pintime "$PinTime;
      if [[ $PinId -ge 0 ]];
      then
        pinEnd=-1;
        pinStart=$(echo "("$(date +"%s.%N")"* 1000)/1" | bc)
        ./setPinTimed.sh $PinId $PinTime;
        pinEnd=$(echo "("$(date +"%s.%N")"* 1000)/1" | bc)
        echo "pinRun for id "$RaffStoreID" "$(echo $pinEnd-$pinStart | bc)" ms"
      else
        :
      fi
      echo ${rsID[i]}" "${PinUpId[i]}" "${PinDownId[i]}" "${MaxHeight[i]}" "${MaxAngle[i]}" "$GHEIGHT" "${CAngle[i]} >> $CURRENTVALUEFILE"."$RaffStoreID".tmp";
    fi
  fi
done







# # start=$(echo '('`date +"%s.%N"` ' * 1000000)/1' | bc)
# start=$(echo "("$(date +"%s.%N")"* 1000)/1" | bc)

# echo $SECONDS;
# sleep 1.1;
# echo $SECONDS;
end=$( echo "("$(date +"%s.%N")"* 1000)/1" | bc )

echo time" "$(echo $end-$start | bc)
