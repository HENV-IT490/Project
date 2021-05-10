#!/bin/bash
echo $OPPIP
echo $HOME
ping $OPPIP -c20
if [ $? -eq 0 ]
then
    sed -i "s/STATUS=.*/STATUS='HSB'/g" $HOME/myenv.conf
    export STATUS="HSB"
    status="HSB"
    #execute command to change apache config to reverse to OPPIP
    $HOME/Project/testing/apacheStatus.sh
    echo "This is a HSB now"
else
    sed -i "s/STATUS=.*/STATUS='PRIMARY'/g" $HOME/myenv.conf
    export STATUS="PRIMARY"
    status="PRIMARY"
    #execute command to change apache config to remove reverse proxy
    $HOME/Project/testing/apacheStatus.sh
    echo "This is PRIMARY now"
fi

#Host starts out as slave or I can change this to env variable
fail_count=0

echo $status



#Host is slave, but can be promoted if master can't be pinged 5 times within 30 seconds
while [ "$status" != "PRIMARY" ]
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
            status=PRIMARY
            fail_count=0
        fi
        sleep 3
done
sed -i "s/STATUS=.*/STATUS='PRIMARY'/g" $HOME/myenv.conf
echo "Host is now PRIMARY, using commands."
export STATUS="PRIMARY"
#execute command to change apache config to remove reverse proxy
$HOME/Project/testing/apacheStatus.sh
exec bash
