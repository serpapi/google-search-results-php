API_KEY=

ifeq ($(API_KEY),)
stop:
	@echo "please set API_KEY by copy paste from https://serpapi.com/dashboard'";
	@echo " > make API_KEY=<yourSecretKey> all"
else
# Install google-search-results-php using composer.
# Composer documentation is available: https://getcomposer.org/doc/01-basic-usage.md
#
all:
	wget https://getcomposer.org/download/1.9.1/composer.phar
	php composer.phar update
	php demo.php
	@echo "done"
endif
