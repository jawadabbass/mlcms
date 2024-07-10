#!/bin/sh

sudo chown -R $USER:www-data site_files
sudo chmod -R 644 site_files
find site_files -type d -exec sudo chmod 0755 {} \;
sudo chmod -R 775 site_files/db
sudo chmod -R 775 site_files/public
sudo chmod -R 775 site_files/storage/app/public/uploads
sudo chmod -R 775 site_files/storage/logs
sudo chmod -R 775 site_files/storage/framework
