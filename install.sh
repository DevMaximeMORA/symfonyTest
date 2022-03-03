#!/bin/sh
cd infra
docker-compose up -d
docker-compose run php composer install
docker-compose run php php bin/console doctrine:database:create
docker-compose run php php bin/console doctrine:schema:update --force
docker-compose run php php bin/console doctrine:fixtures:load --no-interaction
docker-compose run php npm install
docker-compose run php npm run dev
open http://127.0.0.1
cd ..