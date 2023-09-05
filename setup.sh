#!/bin/sh

sudo chown -R $USER:www-data site_files
sudo chmod -R 755 site_files
sudo chmod -R 775 site_files/public/uploads
sudo chmod -R 775 site_files/storage