<?php

use PHPUnit\Framework\TestCase;

class GoogleSearchTest extends TestCase {

  protected function setUp(): void {
     $this->QUERY = [
      'q' => "Coffee", 
      'location' => "Austin,Texas"
    ];

    if(isset($_ENV["API_KEY"])) {
      $this->API_KEY = $_ENV["API_KEY"];
    } else {
      $this->API_KEY = "demo";
    }
  }
  
  public function testGoogleSearch() {
    if(!isset($_ENV["API_KEY"])){
      return;
    }
    $client = new GoogleSearch($this->API_KEY);
    $response = $client->get_json($this->QUERY);
    $this->assertEquals("Success", $response->search_metadata->status);
    $this->assertGreaterThan(5, count($response->organic_results));
    $this->assertGreaterThan(5, strlen($response->organic_results[0]->title));
  }

  public function test_google_get_html_method() {
    if(!isset($_ENV["API_KEY"])){
      return;
    }
    $client = new GoogleSearch($this->API_KEY);
    $response = $client->get_html($this->QUERY);
    $this->assertGreaterThan(10000, strlen($response));
  }

  public function test_google_get_account_method() {
    // skip if no account provided
    if($this->API_KEY == "demo") {
      return;
    }
    $client = new GoogleSearch($this->API_KEY);
    $info = $client->get_account();
    $this->assertEquals($this->API_KEY , $info->api_key);
  }

  public function test_google_get_location_method() {
    $client = new GoogleSearch($this->API_KEY);
    $location_list = $client->get_location('Austin', 3);
    $this->assertEquals(200635, $location_list[0]->google_id);
  }

  public function test_google_get_search_archive_method() {
    if(!isset($_ENV["API_KEY"])){
      return;
    }
    $client = new GoogleSearch($this->API_KEY);
    $result = $client->get_json($this->QUERY);
    $archived_result = $client->get_search_archive($result->search_metadata->id);
    $this->assertEquals($result->search_metadata->id, $archived_result->search_metadata->id);
  }

  public function test_bing_get_search_method() {
    if(!isset($_ENV["API_KEY"])) {
      return;
    }
    $client = new BingSearch($this->API_KEY);
    $response = $client->get_json($this->QUERY);
    $this->assertEquals("Success", $response->search_metadata->status);
    $this->assertGreaterThan(5, count($response->organic_results));
  }

  public function test_baidu_get_search_method() {
    if(!isset($_ENV["API_KEY"])) {
      return;
    }
    $client = new BaiduSearch($this->API_KEY);
    $response = $client->get_json($this->QUERY);
    $this->assertEquals("Success", $response->search_metadata->status);
    $this->assertGreaterThan(5, count($response->organic_results));
  }

  public function test_yahoo_get_search_method() {
    if(!isset($_ENV["API_KEY"])) {
      return;
    }
    $query = [
      'p' => "Coffee"
    ];
    $client = new YahooSearch($this->API_KEY);
    $response = $client->get_json($query);
    $this->assertEquals("Success", $response->search_metadata->status);
    $this->assertGreaterThan(5, count($response->organic_results));
  }

  public function test_yandex_get_search_method() {
    if(!isset($_ENV["API_KEY"])) {
      return;
    }
    $query = [
      'text' => "Coffee"
    ];
    $client = new YandexSearch($this->API_KEY);
    $response = $client->get_json($query);
    $this->assertEquals("Success", $response->search_metadata->status);
    $this->assertGreaterThan(5, count($response->organic_results));
  }

  public function test_ebay_get_search_method() {
    if(!isset($_ENV["API_KEY"])) {
      return;
    }
    $query = [
      '_nkw' => "Coffee"
    ];
    $client = new EbaySearch($this->API_KEY);
    $response = $client->get_json($query);
    $this->assertEquals("Success", $response->search_metadata->status);
    $this->assertGreaterThan(5, count($response->organic_results));
  }

  // public function test_walmart_get_search_method() {
  //   if(!isset($_ENV["API_KEY"])) {
  //     return;
  //   }
  //   $query = [
  //     'query' => "Coffee"
  //   ];
  //   $client = new WalmartSearch($this->API_KEY);
  //   $response = $client->get_json($query);
  //   $this->assertEquals("Success", $response->search_metadata->status);
  //   $this->assertGreaterThan(5, count($response->organic_results));
  // }

  public function test_youtube_get_search_method() {
    if(!isset($_ENV["API_KEY"])) {
      return;
    }
    $query = [
      'search_query' => "Coffee"
    ];
    $client = new YoutubeSearch($this->API_KEY);
    $response = $client->get_json($query);
    $this->assertEquals("Success", $response->search_metadata->status);
    $this->assertGreaterThan(5, count($response->video_results));
  }

  public function test_searpapiclient_get_search_method() {
    if(!isset($_ENV["API_KEY"])) {
      return;
    }
    $query = [
      'q' => "Coffee"
    ];
    $client = new SerpApiSearch($this->API_KEY, 'google');
    $response = $client->get_json($query);
    $this->assertEquals("Success", $response->search_metadata->status);
    $this->assertGreaterThan(5, count($response->organic_results));
  }

  // low level
  public function test_google_get_search_method() {
    if(!isset($_ENV["API_KEY"])) {
      return;
    }
    $client = new GoogleSearch($this->API_KEY);
    $response = $client->search("json", $this->QUERY);
    $this->assertGreaterThan(5, count($response->organic_results));
  }
}

?>
