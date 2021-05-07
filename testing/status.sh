#!/bin/bash
echo $OPPIP
echo $HOME
ping 25.2.97.87 -c5
if [ $? -eq 0 ]
then
    sed -i "s/STATUS=.*/STATUS='slave'/g" $HOME/myconf.env
    export STATUS="slave"
    status="slave"
    echo "This is a slave now"
else
    sed -i "s/STATUS=.*/STATUS='master'/g" $HOME/myconf.env
    export STATUS="master"
    status="master"
    echo "This is a master now"
fi

#Host starts out as slave or I can change this to env variable
user=dbroot
fail_count=0
if [ "$status" == "slave" ]
then  
    echo "Using Slave commands"
    #do necessary slave commands for master slave
    mysql -u$user test -Bse "stop slave;reset master;reset slave;start slave;"
fi 

#Host is slave, but can be promoted if master can't be pinged 5 times within 30 seconds
while [ "$status" != "master" ]
    do ping -c1 -w1 25.2.97.87
        if [ $? -ne 0 ]
        then
            fail_count=$((fail_count + 1))
            echo "Host unavailable - `date`"
        else
            echo "Host up - `date`"
            fail_count=0
        fi 
        if [ $fail_count -eq 5 ]
        then   
            status=master
            fail_count=0
        fi
        sleep 3
done
sed -i "s/STATUS=.*/STATUS='master'/g" $HOME/myenv.conf
echo "Host is now Master, using commands."
#insert mysql commands to switch slave to master/master commands
mysql -u$user test -Bse "stop slave; reset slave;"
exec bash



