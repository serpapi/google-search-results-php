<?php

// Exception
class GoogSearchResultsException extends Exception {}

/***
 * Wrapper around SerpAPI.com
 */
class GoogleSearchResults {
  public $options;
  public $api;
  public $serp_api_key;
  
  public function __construct($serp_api_key=NULL) {
    if($serp_api_key)
      $this->serp_api_key = $serp_api_key;
  }
  
  public function set_serp_api_key($serp_api_key) {
    if($serp_api_key == NULL)
      throw new GoogSearchResultsException("serp_api_key must have a value");
    $this->serp_api_key = $serp_api_key;
  }
  
  /***
   * get_json 
   * @return [Hash] search result "json like"
   */
  public function get_json($q) {
    return $this->search( 'json', $q);
  }

  /***
   * get_html
   * @return [String] raw html search result
   */
  public function get_html($q) {
    return $this->search('html', $q);
  }

  /***
   * Get location using Location API 
   */
  function get_location($q, $limit) {
    $query = [
      'q' => $q, 
      'limit' => $limit
    ];
    return $this->query("/locations.json", 'json', $query);
  }

  /***
   * Retrieve search result from the Search Archive API
   */
  function get_search_archive($search_id) {
    return $this->query("/searches/$search_id.json", 'json', []);
  }

 /***
  * Get account information using Account API
  */
  function get_account() {
    return $this->query('/account', 'json', []);
  }

  function search($output, $q) {
    return $this->query('/search', $output, $q);
  }

  function query($path, $output, $q) {
    $decode_format = $output == 'json' ? 'json' : 'php';

    if($this->serp_api_key == NULL) {
      throw new GoogSearchResultsException("serp_api_key must be defined either in the constructor or by the method set_serp_api_key");
    }
    
    $api = new RestClient([
        'base_url' => "https://serpapi.com",
        'user_agent' => 'google-search-results-php/1.2.0'
    ]);

    $default_q = [
      'output' => $output,
      'source' => 'php',
      'serp_api_key' => $this->serp_api_key
    ];
    $q = array_merge($default_q, $q);
    $result = $api->get($path, $q);

    // GET https://serpapi.com/search?q=Coffee&location=Portland&format=json&source=php&serp_api_key=demo
    if($result->info->http_code == 200)
    {
      // html response
      if($decode_format == 'php') {
       return $result->response;
      }
      // json response
      return $result->decode_response();
    }
    
    if($result->info->http_code == 400 && $output == 'json')
    {
      $error = $result->decode_response();
      $msg = $error->error;
      throw new GoogSearchResultsException($msg);
    }
    
    throw new GoogSearchResultsException("Unexpected exception: $result->response");
  }
  
}

