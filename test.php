<?php

use PHPUnit\Framework\TestCase;

class GoogleSearchResultsTest extends TestCase {

  public function setUp() {
     $this->QUERY = [
      'q' => "Coffee", 
      'location' => "Austin,Texas"
    ];
  }
  
  public function test_simple_search() {
    $serp = new GoogleSearchResults("demo");
    $rsp = $serp->search("json", "json", $this->QUERY);
    $this->assertGreaterThan(5, strlen($rsp->local_results[0]->title));
  }

}
?>
