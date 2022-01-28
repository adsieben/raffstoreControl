#!/bin/sh
# echo $1;
trap 'gpio write $1 0' exit;
# echo $0 $1 $2 "from setPinTimed.sh"
gpio mode $1 out;
gpio write $1 1;
sleep $2;
# sleep 5;
gpio write $1 0;
