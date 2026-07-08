.PHONY: all start down setup up htpasswd composer
all: start down setup up htpasswd
start:
	@docker desktop start || exit 0
down:
	@docker compose down
setup:
	@python3 setup.py
up:
	@docker compose up -d
htpasswd:
	@docker exec -it nginx "./htpasswd.sh"
composer:
	@docker compose run --rm composer composer $(filter-out $@,$(MAKECMDGOALS))
%:
	@: