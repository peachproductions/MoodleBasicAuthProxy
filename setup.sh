#!/usr/bin/env bash

CURDIR=`pwd`

composer install
cd ./src/basicauthproxy/
composer install
cd $CURDIR
docker-compose build
