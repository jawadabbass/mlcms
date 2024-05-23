#!/bin/sh

sudo chown -R $USER:www-data site_files
sudo chmod -R 644 site_files
sudo chmod -R 755 $(sudo find site_files -type d)
sudo chmod -R 775 site_files/public
sudo chmod -R 775 site_files/storage/app/public/uploads
sudo chmod -R 775 site_files/storage/logs
sudo chmod -R 775 site_files/storage/framework
