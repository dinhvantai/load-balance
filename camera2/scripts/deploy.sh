#!/bin/bash

WORKSPACE=vue_admin_workspace

docker exec -it ${WORKSPACE} composer install
docker exec -it ${WORKSPACE} php artisan migrate --seed
# docker exec -it ${WORKSPACE} php artisan migrate --database=mysql_test
docker exec -it ${WORKSPACE} yarn install
docker exec -it ${WORKSPACE} yarn run production
