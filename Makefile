SHELL := /bin/bash

start:
	@echo "make [option]"
	@echo "OPTIONS:"
	@echo '	migration       - create doctrine migration'
	@echo '	migrate         - migrate database'
	@echo '	serverStart     - migrate database'
	@echo '	serverStop      - migrate database'
	@echo '	entity          - create entity'
migration:
	symfony console make:migration
migrate:
	symfony console doctrine:migrations:migrate
serverStart:
	symfony server:start -d
serverStop:
	symfony server:stop
entity:
	symfony console make:entity