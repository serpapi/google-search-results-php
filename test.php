<?php

use PHPUnit\Framework\TestCase;

class GoogleSearchResultsTest extends TestCase {

  public function setUp() {
     $this->QUERY = [
      'q' => "Coffee", 
      'location' => "Austin,Texas"
    ];
  }
  
  public function test_search_method() {
    $serp = new GoogleSearchResults("demo");
    $response = $serp->search("json", "json", $this->QUERY);
    $this->assertGreaterThan(5, strlen($response->local_results[0]->title));
  }

  public function test_json_method() {
    $serp = new GoogleSearchResults("demo");
    $response = $serp->json($this->QUERY);
    $this->assertGreaterThan(5, strlen($response->local_results[0]->title));
  }

  public function test_html_method() {
    $serp = new GoogleSearchResults("demo");
    $response = $serp->html($this->QUERY);
    $this->assertGreaterThan(10000, strlen($response));
  }
}

?>
