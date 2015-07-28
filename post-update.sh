#!/usr/bin/env bash

rm -rf temp/cache
rm -rf temp/proxies
php www/index.php orm:schema-tool:update --force
chmod -R 777 temp
chmod -R 777 log