#!/bin/bash
# SHMDIR="/dev/shm/raffStore.ad7"
SHMDIR="/dev/shm/raffStore"
CURRENTVALUEFILE=$SHMDIR"/currentvalues.dat"
LOCKDIR=$SHMDIR"/lock.dir"
PIDFILE=$LOCKDIR"/lock.pid"
DATADIR="../data/"
SETTINGDIR=$DATADIR"settings/"
INITVALUESFILE=$SETTINGDIR"initValues.txt"

OFS=$IFS;
# IFS='\n';

function onExit() {
#   remove own pid from pidfile
  IFS=$OFS
  (
    unset lockUno
    exec {lockUno}< $PIDFILE
    flock -e -w 1 $lockUno || { echo "cannot lock pidfile"; exit 1;}
    cat $PIDFILE | grep -v $$ > $PIDFILE".tmp";
    cat $PIDFILE".tmp" > $PIDFILE;
    rm -rf $PIDFILE".tmp"
  )
#   remove the locking directory
  rm -rf $LOCKDIR
}

# function cleanPin {
#   echo "clean" $1;
#   gpio mode $1 out;
#   gpio write $1 0;
# }


if [ -f $CURRENTVALUEFILE ]; then rm -rf $CURRENTVALUEFILE; fi

#We want to be the only instance of this bash-script
if mkdir $LOCKDIR; then
  echo "Locking succeeded" >&2
else
  echo "Lock failed - exit" >&2
  exit 1
fi

if [ ! -d $SHMDIR ];then
  mkdir $SHMDIR;
  chmod a+w $SHMDIR;
fi

trap onExit EXIT;

touch $PIDFILE;
(
  unset lockUno
  exec {lockUno}< $PIDFILE
  flock -en $lockUno || { echo "cannot lock pidfile"; exit 1;}
  echo $$ > $PIDFILE
#   sleep 30
)


exec 200< $INITVALUESFILE;
# exec 201< $(cat ../data/settings/initValues.txt | grep -v ^#);
rsID=();
while read -u 200 eins zwei drei vier fuenf; do
       rsID+=($eins);
    PinUpId+=($zwei);
  PinDownId+=($drei);
  MaxHeight+=($vier);
   MaxAngle+=($fuenf);
#   echo $eins;
done;
# declare -p rsID
# declare -p PinUpId
# declare -p PinDownId
# declare -p MaxHeight
# declare -p MaxAngle

echo "#rsID PinUpId PinDownId MaxHeight MaxAngle CurrentHeight CurrentAngle" > $CURRENTVALUEFILE".tmp"

for ((i=0; i<${#rsID[*]}; i++));
do
  echo ${rsID[i]}
  if [[ ${rsID[i]} =~ ^[-0-9]+$ ]]
  then
    if [ ${rsID[i]} -ge 0 ]
    then
      echo "work on "${rsID[i]};
      val=${PinDownId[i]};
       ./setPinTimed.sh ${PinDownId[i]} ${MaxHeight[i]};
    fi
    echo ${rsID[i]}" "${PinUpId[i]}" "${PinDownId[i]}" "${MaxHeight[i]}" "${MaxAngle[i]}" 0 0" >> $CURRENTVALUEFILE".tmp";
  fi
done

mv $CURRENTVALUEFILE".tmp" $CURRENTVALUEFILE;
chmod a+w $CURRENTVALUEFILE;

# for val in ${rsID[@]} ; do
#   echo $val;
# done;
