MAKEFLAGS += --warn-undefined-variables
SHELL := /bin/bash
.EXPORT_ALL_VARIABLES:
.ONESHELL:
.SHELLFLAGS := -eu -o pipefail -c
.SILENT:

# use the rest as arguments for "run"
_ARGS := $(wordlist 2, $(words $(MAKECMDGOALS)), $(MAKECMDGOALS))
# ...and turn them into do-nothing targets
$(eval $(_ARGS):;@:)

.PHONY: docs
docs: ##@ Generate projects documentation (from "Documentation" directory)
	mkdir -p Documentation-GENERATED-temp
	docker run --rm --pull always -v "$(shell pwd)":/project -t ghcr.io/typo3-documentation/render-guides:latest --config=Documentation

.PHONY: test-docs
test-docs: ##@ Test the documentation rendering
	mkdir -p Documentation-GENERATED-temp
	docker run --rm --pull always -v "$(shell pwd)":/project -t ghcr.io/typo3-documentation/render-guides:latest --config=Documentation --no-progress --minimal-test

.PHONY: install
install: ##@ Composer install
	ddev composer install

.PHONY: cleanup
cleanup: ##@ Cleanup project folder
	echo "Cleanup started"
	Build/Scripts/runTests.sh -s clean
	Build/Scripts/additionalTests.sh -s clean
	echo "Cleanup finished"

help:
	@printf "\nUsage: make \033[32m<command>\033[0m\n"
	grep -F -h "##@" $(MAKEFILE_LIST) | \
	grep -F -v grep -F | \
	grep -F -v awk -F | \
	awk 'BEGIN {FS = ":*[[:space:]]*##@[[:space:]]*"}; \
	{ \
		if ($$2 == "") \
			printf ""; \
		else if ($$0 ~ /^#/) \
			printf "\n%s\n\n", $$2; \
		else if ($$1 == "") \
			printf "     %-30s%s\n", "", $$2; \
		else \
			printf "    \033[32m%-30s\033[0m %s\n", $$1, $$2; \
	}'
.DEFAULT_GOAL := help
