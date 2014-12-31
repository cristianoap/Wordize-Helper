Wordize Helper
==============

Translate numbers to plain text

This helper translate numbers to plain text searching each digit in a dictionary. You may change the language with startup settings or translating:

- numbers in range one until nine
- numbers in range ten until ninety
- numbers in range one hundred until nine hundred

Add this code to change rules and numbers:

```
$this->helpers => array(
	'Wordize' => array(
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
	)
);
```
Parameters
--------------------------------

You may change the following settings:

- *defaults*: Holds the name of digits by order (unit, dozen, hundred). 
- *irregular*: Set here the numbers that dont follow the name convention (like ten - this number dont follow rule *{$number}ty*). The irregular numbers may be unique or recursive. Recursive numbers may appear in any class (thousand, million, trillion, etc) and unique numbers exists by himself (like zero).
- *sep_ud*: Allow set the word that separate units and dozens.
- *sep_dh*: Allow set the word that separate dozens and hundreds.
- separator*: Separate classes.
- *classes*: The classes are separated by the multiplier 1000 (thousand, million, trillion, etc). If your language use two options to represent a class (like Portuguese - 1 milhão and  2, 3, 4.... milhões), you can set the values in a array.
