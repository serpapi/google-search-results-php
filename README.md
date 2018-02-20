# Google Search Results in Ruby


This Php API is meant to scrape and parse Google results using [SERP API](https://serpapi.com). Feel free to fork this repository to add more backends.

## Installation

Assuming Php 7+ is already installed:

## Simple Example

```php
require 'path/to/google_search_results'
query = new GoogleSearchResults("demo")
hash = query.json(["q" => "coffee"])
 ```

## Set SERP API key

```php
$serp = GoogleSearchResults()
$serp.set_serp_api_key("Your Private Key")
```
Or
```php
query = new GoogleSearch() q: "coffee", serp_api_key: "Your Private Key"
```
## Example with all params and all outputs
```ruby
query_params = [
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
]

$serp = new GoogleSearchResults("private key")

html_results = $serp.html
json_results = $serp.json
json_results_with_images = $serp.json_with_images
```

Author: Victor Benarbia
For more information: see https://serpapi.com

Thanks Rest API for Php
 - Travis Dent  - https://github.com/tcdent/php-restclient
