#!/bin/bash
if [ "$STATUS" == "PRIMARY" ]
then
	sudo sed -i "s/# ProxyPass/ProxyPass/g" /etc/apache2/sites-available/000-default.conf
	sudo  systemctl reload apache2
	sudo systemctl restart apache2
else if [ "$STATUS" == "HSB" ]
	        sudo sed -i "s/ProxyPass/# ProxyPass/g" /etc/apache2/sites-available/000-default.conf
        sudo  systemctl reload apache2
        sudo systemctl restart apache2
fi
	
