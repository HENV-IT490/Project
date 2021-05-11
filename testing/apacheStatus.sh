#!/bin/bash
if [ "$STATUS" == "HSB" ]
then
	sudo sed -i 's/.#Redirect/Redirect/g' /etc/apache2/sites-available/gethatrecipe.com.conf
	sudo  systemctl reload apache2
	sudo systemctl restart apache2
elif [ "$STATUS" == "PRIMARY" ]
then
	   sudo sed -i 's/Redirect/#Redirect/g' /etc/apache2/sites-available/gethatrecipe.com.conf
        sudo  systemctl reload apache2
        sudo systemctl restart apache2
else
	echo"Neither HSB or Primary"
fi
	