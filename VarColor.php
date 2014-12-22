<?php

/**
 * VarColor
 *
 * Turns any variable into a color - vars will yield the same color every time!
 *
 * @author Rich Jenks <rich@richjenks.com>
 * @license MIT
 */

class VarColor {

	/**
	 * go
	 *
	 * Starts the process...
	 *
	 * Options include:
	 * - saturation: int between 0-100 (default: 50)
	 * - lightness: int between 0-100 (default: 50)
	 * - format: 'hex', 'rgb' or 'hsl' (default: 'hex')
	 * - bare: true or false, array of vars or CSS value (default: true)
	 *
	 * @param mixed $string Variable to be used
	 * @param array $options Color options
	 *
	 * @return array|string Array of parts or string for color
	 */

	public static function go($string = '', $options = array()) {

		// Ensure input is string
		if (!is_string($string)) $string = serialize($string);

		// Ensure options are valid
		$options = self::sanitize_input($options);

		/**
		 * MD5 the string, take the first 3 chars (hex value between 0–4095)
		 * convert hexadecimal to decimal integer then divide by 11.4066852368
		 * to get a float between 0-359. Round it down to nearest int for hue
		 */
		if ($string != '') {
			$options['hue'] = md5($string);
			$options['hue'] = substr($options['hue'],0,3);
			$options['hue'] = hexdec($options['hue']);
			$options['hue'] = $options['hue'] / 11.4066852368;
			$options['hue'] = (int) round($options['hue']);
		}

		// Return required color
		return self::output($options);

	}

	private static function sanitize_input($options) {

		// Ensure all options are set
		$defaults = array(
			'saturation' => 50,
			'lightness'  => 50,
			'format'     => 'hex',
			'bare'       => true,
		);
		$options = array_merge($defaults, $options);

		// Saturation must be between 0-100
		if (isset($options['saturation'])) {
			if ($options['saturation'] > 100)
				$options['saturation'] = 100;
			if ($options['saturation'] < 0)
				$options['saturation'] = 0;
		}

		// Lightness must be between 0-100
		if (isset($options['lightness'])) {
			if ($options['lightness'] > 100)
				$options['lightness'] = 100;
			if ($options['lightness'] < 0)
				$options['lightness'] = 0;
		}

		// Format must be 'hex', 'rgb', or 'hsl'
		$formats = array('hex', 'rgb', 'hsl');
		if (!in_array($options['format'], $formats))
			$options['format'] = 'hex';

		// Bare must must be a bool
		if (!is_bool($options['bare'])) $options['bare'] = true;

		return $options;

	}

	/**
	 * hsl2rgb
	 *
	 * Converts an color's HSL value to RGB
	 * All parameters are expected to be in the range of 0–0.999
	 *
	 * @link http://stackoverflow.com/a/3642787/1562799
	 *
	 * @param $h Hue
	 * @param $s Saturation
	 * @param $l Lightness
	 *
	 * @return array Indexes 'r', 'g', and 'b' hold the color's RGB values
	 */

	private static function hsl2rgb($h, $s, $l){
		$r = $l;
		$g = $l;
		$b = $l;
		$v = ($l <= 0.5) ? ($l * (1.0 + $s)) : ($l + $s - $l * $s);
		if ($v > 0){
			$m;
			$sv;
			$sextant;
			$fract;
			$vsf;
			$mid1;
			$mid2;
			$m = $l + $l - $v;
			$sv = ($v - $m ) / $v;
			$h *= 6.0;
			$sextant = floor($h);
			$fract = $h - $sextant;
			$vsf = $v * $sv * $fract;
			$mid1 = $m + $vsf;
			$mid2 = $v - $vsf;
			switch ($sextant) {
				case 0:
					$r = $v;
					$g = $mid1;
					$b = $m;
					break;
				case 1:
					$r = $mid2;
					$g = $v;
					$b = $m;
					break;
				case 2:
					$r = $m;
					$g = $v;
					$b = $mid1;
					break;
				case 3:
					$r = $m;
					$g = $mid2;
					$b = $v;
					break;
				case 4:
					$r = $mid1;
					$g = $m;
					$b = $v;
					break;
				case 5:
					$r = $v;
					$g = $m;
					$b = $mid2;
					break;
			}
		}
		return array(
			'r' => (int) floor($r * 255),
			'g' => (int) floor($g * 255),
			'b' => (int) floor($b * 255),
		);
	}

	/**
	 * output
	 *
	 * Constructs the required return value
	 */

	private static function output($options) {

		// HSL
		if ($options['format'] === 'hsl') {
			if ($options['bare']) {
				return array(
					'hue' => $options['hue'],
					'saturation' => $options['saturation'],
					'lightness' => $options['lightness'],
				);
			} else {
				return 'hsl('.$options['hue'].','.$options['saturation'].'%,'.$options['lightness'].'%)';
			}
		}

		// RGB
		if ($options['format'] === 'rgb') {

			// Convert to RGB
			$rgb = self::hsl2rgb(
				$options['hue'] / 360,
				$options['saturation'] / 100,
				$options['lightness'] / 100
			);

			if ($options['bare']) {
				return array(
					'r' => $rgb['r'],
					'g' => $rgb['g'],
					'b' => $rgb['b'],
				);
			} else {
				return 'rgb('.$rgb['r'].','.$rgb['g'].','.$rgb['b'].')';
			}

		}

		// HEX
		if ($options['format'] === 'hex') {

			// Convert to RGB
			$rgb = self::hsl2rgb(
				$options['hue'] / 360,
				$options['saturation'] / 100,
				$options['lightness'] / 100
			);

			// Convert to hex and pad
			foreach ($rgb as $key => $val)
				$rgb[$key] = str_pad(dechex($val), 2, '0', STR_PAD_LEFT);

			if ($options['bare']) {
				return array(
					'r' => $rgb['r'],
					'g' => $rgb['g'],
					'b' => $rgb['b'],
				);
			} else {
				return '#'.$rgb['r'].$rgb['g'].$rgb['b'];
			}

		}

	}

}
