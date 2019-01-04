
# Google Search Results in PHP

[![Build Status](https://travis-ci.org/serpapi/google-search-results-php.svg?branch=master)](https://travis-ci.org/serpapi/google-search-results-php)

This Php API is meant to scrape and parse Google results using [SerpApi](https://serpapi.com).

Feel free to fork this repository to add more backends.

[The full documentation is available here.](https://serpapi.com/search-api)

## Installation

 Php 7+ must be already installed and [composer](https://getcomposer.org/) dependency managemen tool.

## Simple Example

```php
require 'path/to/google_search_results'
$serp = new GoogleSearchResults("demo");
$result = $serp(["q" => "coffee","location"=>"Austin,Texas"]);
 ```

## Set SerpApi key

```php
$serp = GoogleSearchResults()
$serp->set_serp_api_key("Your Private Key")
```
Or

```php
$serp = new GoogleSearchResults("Your Private Key") 
```

## Example with all parameters and all outputs
```php
$query = [
  "q" =>  "query",
  "google_domain" =>  "Google Domain", 
  "location" =>  "Location Requested", 
  "device" =>  device,
  "hl" =>  "Google UI Language",
  "gl" =>  "Google Country",
  "safe" =>  "Safe Search Flag",
  "num" =>  "Number of Results",
  "start" =>  "Pagination Offset",
  "serp_api_key" =>  "Your SERP API Key"
];

$serp = new GoogleSearchResults("private key");

$html_results = $serp->html($query);
$json_results = $serp->json($query);
```

This service supports Google Images, News, Shopping.
To enable a type of search, the field tbm (to be matched) must be set to:

 * isch: Google Images API.
 * nws: Google News API.
 * shop: Google Shopping API.
 * any other Google service should work out of the box.
 * (no tbm parameter): regular Google Search.

[The full documentation is available here.](https://serpapi.com/search-api)

Author: Victor Benarbia victor@serpapi.com
For more information: https://serpapi.com

Thanks Rest API for Php
 - Travis Dent  - https://github.com/tcdent/php-restclient
 - Test framework - PhpUnit - https://phpunit.de/getting-started/phpunit-7.html
