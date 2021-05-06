#!/bin/bash
echo $OPPIP
ping 25.2.97.87 -c5 -w500
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
