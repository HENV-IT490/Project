#!/bin/bash
echo $OPPIP
ping $OPPIP -w1 -c2 &>/dev/null

if [ $? -eq 0 ]
then
    sed -i "s/status=.*/status='slave'/g" ~/.bashrc
    export STATUS="slave"
    echo "This is a slave now"
else
    sed -i "s/slavstatus=.*/status='master'/g" ~/.bashrc
    export STATUS="master"
    echo "This is a master now"
fi
