<?php 

// Exception
class SerpApiSearchException extends Exception {}

/***
 * Google search
 */
class GoogleSearch extends SerpApiSearch {
  public function __construct($api_key) {
    parent::__construct($api_key, 'google');
  }
}

/***
 * Bing search
 */
class BingSearch extends SerpApiSearch {
  public function __construct($api_key=NULL) {
    parent::__construct($api_key, 'bing');
  }
}

/***
 * Baidu search
 */
class BaiduSearch extends SerpApiSearch {
  public function __construct($api_key=NULL) {
    parent::__construct($api_key, 'baidu');
  }

  /***
   * Method is not supported.
   */
  public function get_location($q, $limit) {
    throw new SerpApiSearchException("location is not currently supported by Bing");
  }
}

/***
 * Yahoo search
 */
class YahooSearch extends SerpApiSearch {
  public function __construct($api_key=NULL) {
    parent::__construct($api_key, 'yahoo');
  }

  /***
   * Method is not supported.
   */
  public function get_location($q, $limit) {
    throw new SerpApiSearchException("location is not currently supported by Bing");
  }
}

/***
 * Yandex search
 */
class YandexSearch extends SerpApiSearch {
  public function __construct($api_key=NULL) {
    parent::__construct($api_key, 'yandex');
  }

  /***
   * Method is not supported.
   */
  public function get_location($q, $limit) {
    throw new SerpApiSearchException("location is not currently supported by Bing");
  }
}

/***
 * Ebay search
 */
class EbaySearch extends SerpApiSearch {
  public function __construct($api_key=NULL) {
    parent::__construct($api_key, 'ebay');
  }

  /***
   * Method is not supported.
   */
  public function get_location($q, $limit) {
    throw new SerpApiSearchException("location is not currently supported by Bing");
  }
}

/***
 * YouTube search
 */
class YouTubeSearch extends SerpApiSearch {
  public function __construct($api_key=NULL) {
    parent::__construct($api_key, 'youTube');
  }

  /***
   * Method is not supported.
   */
  public function get_location($q, $limit) {
    throw new SerpApiSearchException("location is not currently supported by Bing");
  }
}

/***
 * WalmartSearch search
 */
class WalmartSearch extends SerpApiSearch {
  public function __construct($api_key=NULL) {
    parent::__construct($api_key, 'walmart');
  }

  /***
   * Method is not supported.
   */
  public function get_location($q, $limit) {
    throw new SerpApiSearchException("location is not currently supported by Bing");
  }
}

/***
 * Wrapper around serpapi.com
 */
class SerpApiSearch {
  public $options;
  public $api;
  public $api_key;
  public $engine;

  public function __construct($api_key = NULL, $engine = 'google') {
    // register engine
    if($engine) {
      $this->engine = $engine;
    } else {
      throw new SerpApiSearchException("engine must be defined");
    }

    // register private api key
    if($api_key) {
      $this->api_key = $api_key;
    }
  }
  
  public function set_serp_api_key($api_key) {
    if($api_key == NULL)
      throw new SerpApiSearchException("serp_api_key must have a value");
    $this->api_key = $api_key;
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

  /**
   * Run a search
   */
  function search($output, $q) {
    return $this->query('/search', $output, $q);
  }

  function query($path, $output, $q) {
    $decode_format = $output == 'json' ? 'json' : 'php';

    if($this->api_key == NULL) {
      throw new SerpApiSearchException("serp_api_key must be defined either in the constructor or by the method set_serp_api_key");
    }
    
    $api = new RestClient([
        'base_url' => "https://serpapi.com",
        'user_agent' => 'google-search-results-php/1.3.0'
    ]);

    $default_q = [
      'output'  => $output,
      'source'  => 'php',
      'api_key' => $this->api_key,
      'engine'  => $this->engine
    ];
    $q = array_merge($default_q, $q);
    $result = $api->get($path, $q);

    // GET https://serpapi.com/search?q=Coffee&location=Portland&format=json&source=php&engine=google&serp_api_key=demo
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
      throw new SerpApiSearchException($msg);
    }
    
    throw new SerpApiSearchException("Unexpected exception: $result->response");
  }
  
}

