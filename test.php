<?php

use PHPUnit\Framework\TestCase;

class GoogleSearchResultsTest extends TestCase {

  public function setUp() {
     $this->QUERY = [
      'q' => "Coffee", 
      'location' => "Portland"
    ];
  }
  
  public function test_search() {
    $serp = new GoogleSearchResults('demo');
    $rsp = $serp->search('json', 'json', $this->QUERY);
    $this->assertEquals(get_class($rsp), "stdClass");
    $this->assertEquals($rsp, "");
  }
  
  /**
  * @expectedException              GoogSearchResultsException
  * @expectedExceptionMessageRegExp /We couldn't find your API key/
  */
  public function test_bad_key() {      
    $serp = new GoogleSearchResults('badkey');
    $serp->search('json', 'json', $this->QUERY);
  }
 
}
?>
