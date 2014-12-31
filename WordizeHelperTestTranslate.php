<?php
App::uses('View', 'View');
App::uses('Helper', 'View');
App::uses('WordizeHelper', 'View/Helper');

/**
 * WordizeHelper Test Case
 *
 */
class WordizeHelperTestTranslate extends CakeTestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$View = new View();
		
		$settings = array(
			'defaults' => array(
				'unit' => array(
					1 => 'hum',
					2 => 'dois',
					3 => 'três',
					4 => 'quatro',
					5 => 'cinco',
					6 => 'seis',
					7 => 'sete',
					8 => 'oito',
					9 => 'nove'
				),
				'dozen' => array(
					10 => 'dez',
					20 => 'vinte',
					30 => 'trinta',
					40 => 'quarenta',
					50 => 'cinquenta',
					60 => 'sessenta',
					70 => 'setenta',
					80 => 'oitenta',
					90 => 'noventa'
				),
				'hundred' => array(
					100 => 'cento',
					200 => 'duzentos',
					300 => 'trezentos',
					400 => 'quatrocentos',
					500 => 'quinhentos',
					600 => 'seiscentos',
					700 => 'setecentos',
					800 => 'oitocentos',
					900 => 'novecentos'
				),
			),
			'classes' => array(
				1 => '',
				2 => 'mil',
				3 => array('milhão', 'milhões'),
				4 => array('bilhão', 'bilhões'),
				5 => array('trilhão', 'trilhões'),
			),
			'irregular' => array(
				'unique' => array(
					0 => 'zero',
				),
				'recursive' => array(
					11 => 'onze',
					12 => 'doze',
					13 => 'treze',
					14 => 'catorze',
					15 => 'quinze',
					16 => 'dezesseis',
					17 => 'dezessete',
					18 => 'dezoito',
					19 => 'dezenove',
					100 => 'cem'
				),
			),
			'sep_ud' => ' e ',
			'sep_dh' => ' e ',
			'separator' => ' e ',
		);

		$this->Wordize = new WordizeHelper($View, $settings);
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
     * @dataProvider brProvider
     */
	 public function testExtensifyTranslate( $b, $a ) {
		// $this->markTestSkipped();
        $this->assertEquals( $this->Wordize->extensify( $a ), $b );
		
    }

	public static function brProvider() {
        return array(
          array( 'hum', 1 ),
          array( 'dez', 10 ),
          array( 'quarenta e seis', 46 ),
          array( 'dezenove', 19 ),
          array( 'noventa e oito', 98 ),
          array( 'cem', 100 ),
          array( 'cento e hum', 101 ),
          array( 'oitocentos e noventa e nove', 899 ),
          array( 'quatrocentos e cinquenta e três', 453 ),
          array( 'três mil e oitocentos e sessenta e cinco', 3865 ),
          array( 'sete mil e sessenta e cinco', 7065 ),
        );
    }
}
