.PHONY: all start down setup up htpasswd composer
RUNTIMES := docker podman
CMD := $(firstword $(foreach r,$(RUNTIMES),$(if $(shell $(r) --version),$(r))))
all: start down setup up htpasswd
start:
	@$(CMD) desktop start || exit 0
down:
	@$(CMD) compose down
setup:
	@python3 setup.py
up:
	@$(CMD) compose up -d
htpasswd:
	@$(CMD) compose run --rm nginx ./htpasswd.sh
composer:
	@$(CMD) compose run --rm composer composer $(filter-out $@,$(MAKECMDGOALS))
%:
	@: