install:
		sh bin/install.sh

ps:
		docker-compose ps

up:
		docker-compose up -d

fix:
		docker-compose exec apache sh -c 'vendor/bin/php-cs-fixer fix src/'

bash:
		docker-compose exec apache bash

stop:
		docker-compose stop

build-dev:
	    docker-compose exec apache chown -R www-data: var/
		docker-compose exec apache sh -c 'composer install'
		docker-compose exec apache sh -c 'bin/console assets:install public'
		docker-compose exec apache sh -c 'bin/console doctrine:schema:update --force'
		docker-compose exec apache sh -c 'bin/console cache:clear'
		cd app/front && yarn install && yarn run build
		cd ../../
