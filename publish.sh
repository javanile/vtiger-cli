#!/bin/bash
set -e

echo '{"vtiger_dir":"/var/www/html/vtiger"}' > vtiger.json

git add . > /dev/null
git commit -am "$*"
git push
