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

PHP_VERSION := "8.2"

##@ Docs

.PHONY: docs
docs: ##@ Generate projects documentation (from "Documentation" directory)
	mkdir -p Documentation-GENERATED-temp
	Build/Scripts/runTests.sh -s checkRstRenderingSingle

.PHONY: test-docs
test-docs: ##@ Test the documentation rendering
	mkdir -p Documentation-GENERATED-temp
	docker run --rm --pull always -v "$(shell pwd)":/project -t ghcr.io/typo3-documentation/render-guides:latest --config=Documentation --no-progress --minimal-test

##@ Tests

.PHONY: phpstan
phpstan: ##@ Static code analysis with php-cs-fixer
	echo "Checking with phpstan started"
	Build/Scripts/runTests.sh -p ${PHP_VERSION} -s phpstan
	echo "Checking with phpstan finished"

.PHONY: cgl
cgl: ##@ Coding guideline check with
	echo "Coding guideline check with phpstan started"
	Build/Scripts/runTests.sh -p ${PHP_VERSION} -s cgl -n
	echo "Coding guideline check with phpstan finished"

##@ Release

.PHONY: changelog
changelog: ##@ Update changelog
	ddev php bin/extension-helper changelog:create $(_ARGS)

.PHONY: version
version: ##@ Update version
	ddev php bin/extension-helper version:set $(_ARGS)

.PHONY: cleanup
cleanup: ##@ Cleanup project folder of all files that are not part of the sessionplaner package
	echo "Cleanup started"
	Build/Scripts/runTests.sh -s clean
	echo "Cleanup finished"

##@ Install/Update

.PHONY: switch-core
switch-core: ##@ Require core version. Needs version number given as argument. [^12.4|^13.4]
	@if [[ $(_ARGS) != \^12.* ]] && [[ $(_ARGS) != \^13.* ]];
	then \
    	echo "This version of sessionplaner only supports v12.4 and v13.4";
		exit;
	else
		echo "Composer require typo3/cms-core:$(_ARGS) started"
		Build/Scripts/runTests.sh -s clean
		Build/Scripts/runTests.sh -s composer require -W "typo3/cms-core:$(_ARGS)"
		echo "Composer require typo3/cms-core:$(_ARGS) finished"
	fi

.PHONY: composer-install
composer-install: ##@ Install composer packages
	echo "Composer install started"
	Build/Scripts/runTests.sh -p ${PHP_VERSION} -s composer install
	echo "Composer install finished"

.PHONY: composer-update
composer-update: ##@ Update composer packages
	echo "Composer update started"
	Build/Scripts/runTests.sh -p ${PHP_VERSION} -s composer update
	echo "Composer update finished"

.PHONY: npm-install
npm-install: ##@ Install npm packages
	echo "Npm install started"
	Build/Scripts/runTests.sh -s npm install
	echo "Npm install finished"

.PHONY: npm-update
npm-update: ##@ Update npm packages
	echo "Npm update started"
	Build/Scripts/runTests.sh -s npm update
	echo "Npm update finished"

##@ Compile frontend resources

.PHONY: npm-build
npm-build: ##@ Build CSS and JavaScript files, after development is finished, right before commiting
	echo "Npm build started"
	Build/Scripts/runTests.sh -s npm run build
	echo "Npm build finished"

.PHONY: npm-build-css
npm-build-css: ##@ Build CSS files, only while in development
	echo "Npm build started"
	Build/Scripts/runTests.sh -s npm run build:css
	echo "Npm build finished"

.PHONY: npm-build-js
npm-build-js: ##@ Build JavaScript files, only while in development
	echo "Npm build started"
	Build/Scripts/runTests.sh -s npm run compile:ts
	echo "Npm build finished"

.PHONY: npm-watch
npm-watch: ##@ Watch Scss and Typescript files and build CSS and JavaScript files immediately, only while in development
	echo "Npm watch started"
	Build/Scripts/runTests.sh -s npm run watch
	echo "Npm watch finished"

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
