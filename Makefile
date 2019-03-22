all: lint test example

test:
	php composer.phar run-script test

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
