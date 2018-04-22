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
    $this->assertEquals($rsp->local_results[0]->title, "Houndstooth Coffee");
  }
  
  /**
  * @expectedException              GoogSearchResultsException
  * @expectedExceptionMessageRegExp /We couldn't find your API key/
  */
  public function test_bad_key() {      
    $serp = new GoogleSearchResults('badkey');
    $q  = ['q' => "undefined", 'location' => "Austin,Texas"];
    $serp->search('json', 'json', $q);
  }
 
}
?>
