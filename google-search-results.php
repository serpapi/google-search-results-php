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
  
  public function json($q) {
    return search('json', 'json', $q);
  }

  public function jsonWithImage($q) {
    return search('json', 'json_with_images', $q);
  }
  
  public function html($q) {
    return search('php', 'html', $q);
  }
    
  function search($decode_format, $format, $q) {
    if($this->serp_api_key == NULL)
      throw new GoogSearchResultsException("serp_api_key must be defined either in the constructor or by the method set_serp_api_key");
   
    $api = new RestClient([
        'base_url' => "https://serpapi.com", 
        'format' => $decode_format
    ]);
    $default_q = [
      'format' => $format,
      'source' => 'php',
      'serp_api_key' => $this->serp_api_key
    ];
    $q = array_merge($default_q, $q);
    $result = $api->get("search", $q);
    // GET https://serpapi.com/search?q=Coffee&location=Portland&format=json&source=php&serp_api_key=demo
    if($result->info->http_code == 200)
    {
      return $result->decode_response();
    }    
    elseif($result->info->http_code == 400 && $format == 'json')
    {
      $error = $result->decode_response();
      var_dump($error);
      
      foreach($result as $key => $value)
        var_dump($value);

      throw new GoogSearchResultsException($error['error']);
    }
    // 
    throw new GoogSearchResultsException("Unexpected query failure: ", $result);
  }
  
}

