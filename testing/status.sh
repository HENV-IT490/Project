#!/bin/bash
echo $OPPIP
echo /usr/local/bin
ping $OPPIP -c20
if [ $? -eq 0 ]
then
    sed -i "s/STATUS=.*/STATUS='slave'/g" /usr/local/bin/myenv.conf
    export STATUS="slave"
    status="slave"
    echo "This is a slave now"
else
    sed -i "s/STATUS=.*/STATUS='master'/g" /usr/local/bin/myenv.conf
    export STATUS="master"
    status="master"
    echo "This is a master now"
fi

#Host starts out as slave or I can change this to env variable
user=dbroot
fail_count=0

echo $status

if [ "$status" == "slave" ]
then  
    echo "Using Slave commands"
    #do necessary slave commands for master slave
    mysql -u$user projectdb -Bse "stop slave;reset master;reset slave;start slave;"
fi 

#Host is slave, but can be promoted if master can't be pinged 5 times within 30 seconds
while [ "$status" != "master" ]
    do ping -c1 -w1 $OPPIP
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
sed -i "s/STATUS=.*/STATUS='master'/g" /usr/local/bin/myenv.conf
echo "Host is now Master, using commands."
#insert mysql commands to switch slave to master/master commands
mysql -u$user projectdb -Bse "stop slave; reset slave;"
exec bash



