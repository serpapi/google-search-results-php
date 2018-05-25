# Google Search Results in PHP


This Php API is meant to scrape and parse Google results using [SerpApi](https://serpapi.com). Feel free to fork this repository to add more backends.

## Installation

Assuming Php 7+ is already installed and [composer](https://getcomposer.org/) dependency managemen tool.

## Simple Example

```php
require 'path/to/google_search_results'
$serp = new GoogleSearchResults("demo");
$result = $serp(["q" => "coffee","location"=>"Austin,Texas"]);
 ```

## Set SERP API key

```php
$serp = GoogleSearchResults()
$serp.set_serp_api_key("Your Private Key")
```
Or
```php
$serp = new GoogleSearchResults("Your Private Key") 
```
## Example with all params and all outputs
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

$html_results = $serp.html($query);
$json_results = $serp.json($query);
$json_results_with_images = $serp.json_with_images($query);
```

Author: Victor Benarbia
For more information: see https://serpapi.com

Thanks Rest API for Php
 - Travis Dent  - https://github.com/tcdent/php-restclient
 - Test framework - PhpUnit - https://phpunit.de/getting-started/phpunit-7.html
