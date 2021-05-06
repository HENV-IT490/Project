#!/bin/bash
echo $OPPIP
ping 25.2.97.87 -c5
if [ $? -eq 0 ]
then
    sed -i "s/STATUS=.*/STATUS='slave'/g" $HOME/.bashrc
    export STATUS="slave"
    echo "This is a slave now"
else
    sed -i "s/STATUS=.*/STATUS='master'/g" $HOME/.bashrc
    export STATUS="master"
    echo "This is a master now"
fi
exec bash
