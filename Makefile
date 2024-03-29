install:
		sh bin/install.sh

ps:
		docker-compose ps

up:
		docker-compose up -d

bash:
	docker exec projet-fil-rouge-php-1 bash

stop:
		docker-compose stop

build-dev:
	    docker-compose exec php chown -R www-data: var/
		docker-compose exec php sh -c 'composer install'
		docker-compose exec php sh -c 'bin/console doctrine:schema:update --force'
		docker-compose exec php sh -c 'bin/console assets:install public'
		docker-compose exec php sh -c 'bin/console cache:clear'
		make ky
		cd app/front && npm install && npm run build

ky:
		docker-compose exec php sh -c 'set -e ;apt-get install -y openssl;'
		docker-compose exec php sh -c 'set -e ;apt-get install -y acl;'
		docker-compose exec php sh -c 'php bin/console lexik:jwt:generate-keypair'
		docker-compose exec php sh -c 'setfacl -R -m u:www-data:rX -m u:"$(whoami)":rwX config/jwt'
		docker-compose exec php sh -c' setfacl -dR -m u:www-data:rX -m u:"$(whoami)":rwX config/jwt'
