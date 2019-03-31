
# Google Search Results in PHP

[![Build Status](https://travis-ci.org/serpapi/google-search-results-php.svg?branch=master)](https://travis-ci.org/serpapi/google-search-results-php)

This Php API is meant to scrape and parse Google results using [SerpApi](https://serpapi.com).

Feel free to fork this repository to add more backends.

[The full documentation is available here.](https://serpapi.com/search-api)

The following services are provided:
 * [Search API](https://serpapi.com/search-api)
 * [Location API](https://serpapi.com/locations-api)
 * [Search Archive API](https://serpapi.com/search-archive-api)
 * [Account API](https://serpapi.com/account-api)

Serp API provides a [script builder](https://serpapi.com/demo) to get you started quickly.

## Installation

 Php 7+ must be already installed and [composer](https://getcomposer.org/) dependency management tool.

 Package available from packagist.

## Quick start

if you're using composer, you can add this package ([link to packagist](https://packagist.org/packages/serpapi/google-search-results-php)).
```bash
$ composer require serpapi/google-search-results-php
```

if not, you must clone this repository and link the class.
```php
require 'path/to/google_search_results';
```

Then you can start coding something like:
```php
$serp = new GoogleSearchResults("demo");
$result = $serp(["q" => "coffee","location"=>"Austin,Texas"]);
 ```

This example runs a search about "coffee" using your secret api key.

The Serp API service (backend)
 - searches on Google using the query: q = "coffee"
 - parses the messy HTML responses
 - return a standardizes JSON response
The Ruby class GoogleSearchResults
 - Format the request to Serp API server
 - Execute GET http request
 - Parse JSON into Ruby Hash using JSON standard library provided by Ruby
Et voila..

## Example
 * [How to set SERP API key](#how-to-set-serp-api-key)
 * [Search API capability](#search-api-capability)
 * [Example by specification](#example-by-specification)
 * [Location API](#location-api)
 * [Search Archive API](#search-archive-api)
 * [Account API](#account-api)
 * [Search Google Images](#search-google-images)

### How to set SERP API key
The Serp API key can be set globally using a singleton pattern.

```php
$serp = new GoogleSearchResults();
$serp->set_serp_api_key("Your Private Key");
```
Or

```php
$serp = new GoogleSearchResults("Your Private Key");
```

### Search API capability
```php
$query = [
  "q" =>  "query",
  "google_domain" =>  "Google Domain", 
  "location" =>  "Location Requested", 
  "device" =>  "device",
  "hl" =>  "Google UI Language",
  "gl" =>  "Google Country",
  "safe" =>  "Safe Search Flag",
  "num" =>  "Number of Results",
  "start" =>  "Pagination Offset",
  "serp_api_key" =>  "Your SERP API Key",
  "tbm" => "nws|isch|shop"
  "tbs" => "custom to be search criteria"
  "async" => true|false # allow async 
];

$serp = new GoogleSearchResults("private key");

$html_results = $serp->get_html($query);
$json_results = $serp->get_json($query);
```

### Location API

```php
$client = new GoogleSearchResults($this->API_KEY);
$location_list = $client->get_location('Austin', 3);
print_r($location_list);
```
it prints the first 3 location matching Austin (Texas, Texas, Rochester)
```php
[{:id=>"585069bdee19ad271e9bc072",
  :google_id=>200635,
  :google_parent_id=>21176,
  :name=>"Austin, TX",
  :canonical_name=>"Austin,TX,Texas,United States",
  :country_code=>"US",
  :target_type=>"DMA Region",
  :reach=>5560000,
  :gps=>[-97.7430608, 30.267153],
  :keys=>["austin", "tx", "texas", "united", "states"]},
  ...]
```

### Search Archive API

Let's run a search to get a search_id.
```php
$client = new GoogleSearchResults($this->API_KEY);
$result = $client->get_json($this->QUERY);
$search_id = $result->search_metadata->id
```

Now let's retrieve the previous search from the archive.

```php
$archived_result = $client->get_search_archive($search_id);
print_r($archived_result);
```

it prints the search from the archive.

### Account API
```ruby
$client = new GoogleSearchResults($this->API_KEY);
$info = $client->get_account();
print_r($info);
```
it prints your account information.

### Search Google Images

```php
$client = new GoogleSearchResults($this->API_KEY);
$data = $client->get_json([
  'q' => "Coffee", 
  'tbm' => 'isch'
]);

foreach($data->images_results as $image_result) {
  print_r($image_result->original);
  //to download the image:
  // `wget #{image_result[:original]}`
}
```

this code prints all the images links, 
 and download image if you un-comment the line with wget (linux/osx tool to download image).

## Run test

The code described above is tested in the file test.php and example.php.
To run the test locally. 

```php
export API_KEY='your secret key'
make test example
```

## Conclusion

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
