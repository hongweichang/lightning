#!/bin/sh
php=$1;
yiic=$2;
workerNum=$3;
i=0;

while [ $i < $workerNum ];
do
    $php $yiic notifyWorder &
    echo $i;
    i=`expr $i+1`
done
$php $yiic notifyBroker &