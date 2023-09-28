#!/bin/sh

sudo chown -R $USER:www-data site_files
sudo chmod -R 774 $(sudo find site_files -type f)
sudo chmod -R 775 $(sudo find site_files -type d)
sudo chmod -R 644 $(sudo find site_files/storage/app/public -type f)