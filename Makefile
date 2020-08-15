url=https://github.com/serpapi/google-search-results-php.git
# https://packagist.org/packages/serpapi/google-search-results-php

.PHONY: test

all: lint test example

test:
	php composer.phar run-script test

release: 
	@echo "automatic just check: https://packagist.org/packages/serpapi/google-search-results-php"
	curl -XPOST -H'content-type:application/json' 'https://packagist.org/api/update-package?username=serpapi&apiToken=WndLqYErok6VjThQ0XDt' \
	 -d'{"repository":{"url":"$(url)"}}'

example:
	php composer.phar run-script test_example

# Lint PHP files
lint:
	@find . -maxdepth 1 -type f -name '*.php' -exec php -l {} \; | (! grep -v "No syntax errors detected" )

# Install dependency
dep:
	git clone https://github.com/tcdent/php-restclient.git tmp
	mv tmp/restclient.php .
	rm -rf tmp

install: install_composer install_dep

install_composer:
	curl -sS https://getcomposer.org/installer | php

install_dep:
	php ./composer.phar install
