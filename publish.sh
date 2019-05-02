#!/bin/bash
set -e

[[ -f vtiger.lock ]] && rm vtiger.lock
echo '{"vtiger_dir":"/var/www/html/vtiger"}' > vtiger.json

git add . > /dev/null
git commit -am "$*"
git push
