#!/bin/sh

sudo chown -R $USER:www-data site_files
sudo chmod -R 444 site_files
sudo chmod 755 $(sudo find site_files -type d)
sudo chmod -R 774 site_files/public/uploads
sudo chmod -R 774 site_files/storage
sudo chmod -R 774 site_files/app/Http/Controllers
sudo chmod -R 774 site_files/resources/views