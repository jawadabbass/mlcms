#!/bin/sh

sudo chown -R $USER:www-data site_files
sudo chmod -R 644 site_files
sudo chmod -R 755 $(sudo find site_files -type d)
sudo chmod -R 755 $(sudo find site_files/storage/logs -type f)
sudo chmod -R 755 $(sudo find site_files/storage/framework -type f)