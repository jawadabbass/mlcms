#!/bin/sh

sudo chown -R $USER:www-data site_files
sudo chmod -R 0644 site_files
find site_files -type d -exec sudo chmod 0755 {} \;
sudo chmod -R 0775 site_files/db
sudo chmod -R 0775 site_files/public
sudo chmod -R 0775 site_files/storage/app/public/uploads
sudo chmod -R 0775 site_files/storage/logs
sudo chmod -R 0775 site_files/storage/framework


#sudo chown -R popc2022:popc2022 public_html
#sudo chown -R popc2022:popc2022 site_files
#find public_html -type f -exec sudo chmod 0644 {} \;
#find site_files -type f -exec sudo chmod 0644 {} \;