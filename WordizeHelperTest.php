<?php
App::uses('View', 'View');
App::uses('Helper', 'View');
App::uses('WordizeHelper', 'View/Helper');

/**
 * WordizeHelper Test Case
 *
 */
class WordizeHelperTest extends CakeTestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$View = new View();
		$this->Wordize = new WordizeHelper($View);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Wordize);

		parent::tearDown();
	}

/**
 * testExtensify method
 *
 * @return void
 */
    /**
     * @dataProvider additionProvider
     */
	 public function testExtensify( $b, $a ) {
		// $this->markTestSkipped();
        $this->assertEquals( $this->Wordize->extensify( $a ), $b );
    }

	public static function additionProvider() {
        return array(
          array( 'zero', 0 ),
          array( 'one', 1 ),
          array( 'ten', 10 ),
          array( 'fourty-six', 46 ),
          array( 'fourty-one', '  41  ' ),
          array( null, array() ),
          array( 'nineteen', 19 ),
          array( 'one hundred nineteen', 119 ),
          array( 'ninety-eight', 98 ),
          array( 'eight hundred ninety-nine', 899 ),
          array( 'four hundred fifty-three', 453 ),
          array( 'seven hundred six', 706 ),
          array( 'three thousand eight hundred sixty-five', 3865 ),
          array( 'seven thousand sixty-five', 7065 ),
          array( 'thirty-seven thousand six hundred five', 37605 ),
        );
    }

    /**
     * @dataProvider cacheProvider
     */
	 public function testCache( $b, $a ) {
		// $this->markTestSkipped();
		$this->assertEquals( $this->Wordize->extensify( $a ), $b );
    }

	public static function cacheProvider() {
        return array(
          array( 'one', 1 ),
          array( 'one hundred nineteen', 119 ),
          array( 'eight hundred ninety-nine', 899 ),
          array( 'four hundred fifty-three', 453 ),
          array( 'four hundred fifty-three', 453 ),
          array( 'four hundred fifty-three', 453 ),
          array( 'four hundred fifty-three', 453 ),
          array( 'four hundred fifty-three', 453 ),
          array( 'four hundred fifty-three', 453 ),
          array( 'fourty-one', '  41  ' ),
          array( 'nineteen', 19 ),
          array( 'four hundred fifty-three', 453 ),
          array( 'four hundred fifty-three', 453 ),
          array( 'three thousand eight hundred sixty-five', 3865 ),
          array( 'three thousand eight hundred sixty-five', 3865 ),
          array( 'three thousand eight hundred sixty-five', 3865 ),
          array( 'three thousand eight hundred sixty-five', 3865 ),
          array( 'ten', 10 ),
          array( 'fourty-six', 46 ),
          array( 'three thousand eight hundred sixty-five', 3865 ),
          array( 'three thousand eight hundred sixty-five', 3865 ),
          array( 'ninety-eight', 98 ),
          array( 'three thousand eight hundred sixty-five', 3865 ),
          array( 'three thousand eight hundred sixty-five', 3865 ),
          array( 'seven thousand sixty-five', 7065 ),
          array( 'seven thousand sixty-five', 7065 ),
          array( 'seven thousand sixty-five', 7065 ),
          array( 'seven thousand sixty-five', 7065 ),
          array( 'seven thousand sixty-five', 7065 ),
          array( 'seven thousand sixty-five', 7065 ),
        );
    }
}
