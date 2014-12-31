<?php
/**
 * Helper class that translate numbers to plain text in runtime.
 *
 * @package       App.View.Helper
 * @version       2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('AppHelper', 'View/Helper');


class WordizeHelper extends AppHelper {
	//trying speed up
	static private $_cache = array();
	
	static $sep_ud = '-';
	static $sep_dh = ' ';
	static $separator = ' ';
	
	static $defaults = array(
		'unit' => array(
			1 => 'one',
			2 => 'two',
			3 => 'three',
			4 => 'four',
			5 => 'five',
			6 => 'six',
			7 => 'seven',
			8 => 'eight',
			9 => 'nine'
		),
		'dozen' => array(
			10 => 'ten',
			20 => 'twenty',
			30 => 'thirty',
			40 => 'fourty',
			50 => 'fifty',
			60 => 'sixty',
			70 => 'seventy',
			80 => 'eighty',
			90 => 'ninety'
		),
		'hundred' => array(
			100 => 'one hundred',
			200 => 'two hundred',
			300 => 'three hundred',
			400 => 'four hundred',
			500 => 'five hundred',
			600 => 'six hundred',
			700 => 'seven hundred',
			800 => 'eight hundred',
			900 => 'nine hundred',
		)
	);

	//breakpoints
	static $classes = array(
		1 => '',
		2 => 'thousand',
		3 => 'million',
		4 => 'billion',
		5 => 'trillion',
	);

	static $irregular = array(
		'unique' => array(
			0 => 'zero',
		),
		'recursive' => array(
			11 => 'eleven',
			12 => 'twelve',
			13 => 'thirteen',
			14 => 'fourteen',
			15 => 'fifteen',
			16 => 'sixteen',
			17 => 'seventeen',
			18 => 'eighteen',
			19 => 'nineteen'
		),
	);

	public function __construct(View $view, $settings = array()) {
        parent::__construct( $view, $settings );

		self::$defaults = isset( $settings[ 'defaults' ] ) ? $settings[ 'defaults' ] : self::$defaults;
		self::$irregular = isset( $settings[ 'irregular' ] ) ? $settings[ 'irregular' ] : self::$irregular;
		self::$sep_ud = isset( $settings[ 'sep_ud' ] ) ? $settings[ 'sep_ud' ] : self::$sep_ud;
		self::$sep_dh = isset( $settings[ 'sep_dh' ] ) ? $settings[ 'sep_dh' ] : self::$sep_dh;
		self::$separator = isset( $settings[ 'separator' ] ) ? $settings[ 'separator' ] : self::$separator;
	}
    /**
     *  @brief Translate numbers to plain text
     *  
     *  @param [int|float] $number Number that will be spelled out
     *  @return Number spelled out
     *  
     */
    static function extensify( $number = null ) {
		if ( is_null( $number ) ) {
			return;
		}
		if ( isset( self::$_cache[ (int) $number ] ) ) {
			return self::$_cache[ $number ];
		}
		if ( is_int( $number ) ) {
			foreach( self::$irregular['unique'] as $k => $specific ) {
				if ( $k == $number ) {
					return $specific;
				}
			}
		}

		$decomposed = self::_decompose( $number );
		if ( is_null( $decomposed ) ) {
			return null;
		}
		$classes = count( $decomposed['integer'] );
		$string = array();
		for( $cls = $classes - 1; $cls >= 0; $cls-- ) {
			$words = array();
			$digits = (int) $decomposed['integer'][ $cls ];
			$houses = str_split( $digits );
			$houses = array_reverse( $houses );
			for( $h = 0; $h <= count( $houses ) - 1; $h++ ) {
				#until 10^2 will work well
				$houses[ $h ] *= pow( 10, $h );
			}
			$found = false;
			$ns = array();
			foreach( self::$irregular['recursive'] as $k => $specific ) {
				if( preg_match( "/{$k}$/", $digits, $ns ) ) {
					$words[] = $specific;
					$found = true;
					break;
				}
			}
			for( $i = 0; $i < strlen( end( $ns ) ); $i++ ) {
				unset( $houses[ $i ] );
			}
			foreach( $houses as $h_value ) {
				foreach( self::$defaults as $default ) {
					if( in_array( $h_value, array_keys( $default ) ) ) {
						$words[] = $default[ $h_value ];
						break;
					}
				}
			}
			$_level = self::$classes[ $cls + 1 ];
			$base = gettype( $_level ) == 'array' ? self::_n( $_level[0], $_level[1], $digits ) : $_level;
			switch ( count( $words ) ) {
				case 3:
					$string[] = __( end( $words ) ) . self::$sep_dh . __( prev( $words ) ) . self::$sep_ud . __( prev( $words ) ) . ' ' . $base;
				break;
				case 2:
					if( $found || $digits > 99 ) {
						$string[] = __( end( $words ) ) . self::$sep_dh . __( prev( $words ) ) . ' ' . $base;
					} else {
						$string[] = __( end( $words ) ) . self::$sep_ud . __( prev( $words ) ) . ' ' . $base;
					}
				break;
				case 1:
					$string[] = __( end( $words ) ) . ' ' . $base;
				break;
			}
		}
		$wordized = trim( implode( self::$separator, $string ) );
		self::$_cache[ $number ] = $wordized;
		return $wordized;
    }
    /**
     *  @brief Break number in pieces of 3 digits
     *  
     *  @example Turn 12345678 to array 12, 345, 678
     *  @param [int|float| number as string] $number Number to be splitted
     *  @return array with numbers in pieces of 3 digits
     *  
     *  @details Details
     */
    static protected function _decompose( $number ) {
        switch ( gettype( $number ) ) {
			case 'float':
			case 'integer':
			case 'string':
				$number = (float) $number;
				if ( is_nan( $number ) ){
					return;
				}
			break;
			default:
				return;
			break;
		}
		
		$numbers = explode( '.', $number );
		$digits = str_split( strrev( array_shift( $numbers ) ), 3);
		$decimals = array_pop( $numbers );
		foreach( $digits as &$digit ) {
			$digit = strrev( $digit );
		}

		$decomposed = array(
			'integer' => $digits,
			'decimal' => $decimals,
		);
		return $decomposed;
    }
    /**
     *  @brief This function works like WP _n function, without $domain
     *  
     *  @see http://codex.wordpress.org/Function_Reference/_n
     *  @param [string] $singular the text that will be used if $number is 1
     *  @param [string] $plural   The text that will be used if $number is not 1
     *  @param [int] $number   The number to compare against to use either $single or $plural
     *  @return Either $single or $plural translated text.
     *  
     */
    static function _n( $singular, $plural, $number ) {
		return (int) $number === 1 ? __( $singular ) : __( $plural );
    }
}
