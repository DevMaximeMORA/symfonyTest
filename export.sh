#!/bin/sh
cd infra
docker-compose run php php bin/console app:export_products csv
cd ..