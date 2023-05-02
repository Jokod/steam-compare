# —— Inspired by ———————————————————————————————————————————————————————————————
# http://fabien.potencier.org/symfony4-best-practices.html
# https://speakerdeck.com/mykiwi/outils-pour-ameliorer-la-vie-des-developpeurs-symfony?slide=47
# https://blog.theodo.fr/2018/05/why-you-need-a-makefile-on-your-project/

# Setup ————————————————————————————————————————————————————————————————————————

# Executables
YARN          = yarn
SYMFONY       = symfony
PHP           = $(SYMFONY) php
COMPOSER      = $(SYMFONY) composer
CONSOLE       = $(SYMFONY) console
DOCKER		  = docker

# Executables: vendors
PHPSTAN       = $(PHP) ./vendor/bin/phpstan
PHP_CS_FIXER  = $(PHP) ./vendor/bin/php-cs-fixer

# Variables
APP_INSTANCE  = live
DOMAIN		  = web

# Misc
.DEFAULT_GOAL = help
.PHONY       =  # Not needed here, but you can put your all your targets to be sure
                # there is no name conflict between your files and your targets.

## —— 🐝 The Symfony Makefile 🐝 ———————————————————————————————————
help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

## —— Project 🚀  ————————————————————————————————————————————————————————
start: docker-up serve proxy composer-install js-install permissions js-dev security info ## Start Symfony binary server, install composer, fix permissions and build JS assets

stop: unserve docker-stop  ## Stop Symfony binary server

clean: stop ## Remove Docker container, Composer vendors, Yarn node_modules, Symfony var directory (cache, logs, uploaded files), Symfony public assets
	$(DOCKER) compose down --remove-orphans
	rm -rf vendor
	rm -rf node_modules
	rm -rf var
	rm -rf public/assets public/bundles public/media
	rm -rf yarn-error.log npm-debug.log .phpunit.result.cache .php_cs.cache

status:
	$(SYMFONY) server:status

info:
	@echo ============================================================================
	@echo PhpMyAdmin UI - Manage/View MySql datas     :     http://127.0.0.1:6244
	@echo ----------------------------------------------------------------------------
	@echo Mailhog UI    - Email smtp for tests        :     http://127.0.0.1:6246
	@echo ----------------------------------------------------------------------------
	@echo WEB UI        - Application local domain    :     https://$(DOMAIN).wip
	@echo ============================================================================

## —— Docker 🐳 ————————————————————————————————————————————————————————————————
docker-up: ## Start the docker hub (MySQL, Elasticsearch)
	$(DOCKER) compose up -d --build

docker-stop: ## Stop the docker hub
	$(DOCKER) compose stop

## —— Composer 🧙‍♂️ ————————————————————————————————————————————————————————————
composer-install: composer.lock ## Install vendors according to the current composer.lock file
	$(COMPOSER) install

composer-update: composer.lock ## Update vendors to last version
	$(COMPOSER) update

## —— Symfony 🎵 ———————————————————————————————————————————————————————————————
serve: ## Serve the application with HTTPS support
	$(SYMFONY) server:ca:install
	$(SYMFONY) server:start --daemon

unserve: ## Stop the webserver
	$(SYMFONY) server:stop

proxy: ## Start and attach local domain proxy on symfony server
	$(SYMFONY) proxy:start
	$(SYMFONY) proxy:domain:attach $(DOMAIN)

cc: ## Clear the cache. DID YOU CLEAR YOUR CACHE????
	$(CONSOLE) c:c

permissions: ## Fix permissions of all var files
	chmod -R 777 var/*

fixtures: ## Load fixtures in your BDD
	$(CONSOLE) doctrine:database:drop --force
	$(CONSOLE) doctrine:database:create
	$(CONSOLE) doctrine:schema:create -q
	$(CONSOLE) doctrine:fixtures:load -n

## —— Quality insurance ✨ ——————————————————————————————————————————————————————
check: requirements security cs phpstan ## Run all coding standards checks

requirements:
	$(SYMFONY) check:requirements

security:
	$(SYMFONY) security:check

lint: ## Lint files with php-cs-fixer
	$(PHP_CS_FIXER) fix --dry-run
	$(PHPSTAN) analyse src/ --level=1 --memory-limit 1G

fix: ## Fix files with php-cs-fixer
	$(PHP_CS_FIXER) fix

## —— Yarn 🐱 / JavaScript —————————————————————————————————————————————————————
js-install:
	$(YARN) install

js-dev: js-install ## Rebuild assets for the dev env
	$(CONSOLE) fos:js-routing:dump --target=assets/js/routes.json --format=json
	$(YARN) run encore dev

js-watch: ## Watch files and build assets when needed for the dev env
	$(YARN) run encore dev --watch

js-hot: ## Watch files and build assets with hot replacement module
	$(YARN) run encore dev-server --hot --https --pfx=$(HOME)/.symfony/certs/default.p12 --allowed-hosts=$(DOMAIN).wip

js-prod: ## Build assets for production
	$(YARN) run encore production --progress

## —— Cron ———————————————————————————————————————————————————————————————————

crontab-install:
	if [ -d "/etc/cron.d" ] && [ -s "$(shell pwd)/config/crontab/$(APP_INSTANCE)" ]; then sudo cp "$(shell pwd)/config/crontab/$(APP_INSTANCE)" "/etc/cron.d/$(DOMAIN)-$(APP_INSTANCE)" && sudo chmod 644 "/etc/cron.d/$(DOMAIN)-$(APP_INSTANCE)"; fi