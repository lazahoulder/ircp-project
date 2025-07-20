#!/bin/bash

# This script installs the PHP DOM extension for both CLI and web server environments

# Install the PHP DOM extension
sudo apt-get update
sudo apt-get install -y php-xml

# Restart the web server (Apache or Nginx)
if [ -f /etc/init.d/apache2 ]; then
    sudo service apache2 restart
elif [ -f /etc/init.d/nginx ]; then
    sudo service nginx restart
fi

echo "PHP DOM extension has been installed and the web server has been restarted."
