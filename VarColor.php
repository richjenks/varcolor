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

	// Base color vars
	public $hue        = 180;
	public $saturation = 50;
	public $lightness  = 50;

	// Return formats
	const HEX = 0;
	const RGB = 1;
	const HSL = 2;

	// Current return format
	public $format = 0;

	/**
	 * When you don't care about "theming" and just want a quick colour
	 * Color will have no relation to that of `color()`
	 *
	 * @param  mixed  $string Input
	 * @return string Hex color
	 */
	public function hex($string) {
		if (!is_string($string)) $string = serialize($string);
		$string = md5($string);
		$string = substr($string, 0, 6);
		return strtoupper($string);
	}

	/**
	 * Generates a color from current options
	 *
	 * @param  mixed $string Variable to be used
	 * @return mixed Hex color string or array of parts
	 */
	public function color($string = '') {

		// Check variables are valid before continuing
		$this->check();

		// Ensure input is string
		if (!is_string($string)) $string = serialize($string);

		/**
		 * MD5 the string, take the first 3 chars (hex value between 0–4095)
		 * convert hexadecimal to decimal integer then divide by 11.4066852368
		 * to get a float between 0-359. Round it down to nearest int for hue
		 */
		if ($string != '') {
			$this->hue = md5($string);
			$this->hue = substr($this->hue, 0, 3);
			$this->hue = hexdec($this->hue);
			$this->hue = $this->hue / 11.4066852368;
			$this->hue = (int) round($this->hue);
		}

		// Return required color
		return self::output();

	}

	/**
	 * Determines whether black or white has the most contrast with the given hex
	 * text set over a color should be black or white
	 * The "centre point" seems the most logical cutt-off, but in practice, leaning more torwards white is more readable
	 *
	 * @see https://24ways.org/2010/calculating-color-contrast/
	 *
	 * @param  string $hex Color in hex format
	 * @return string 'black' or 'white'
	 */
	function contrast($hex){
		$r = hexdec(substr($hex,0,2));
		$g = hexdec(substr($hex,2,2));
		$b = hexdec(substr($hex,4,2));
		$c = (($r*299)+($g*587)+($b*114))/1000;
		// return ($c >= 128) ? 'black' : 'white';
		return ($c >= 160) ? 'black' : 'white';
	}

	/**
	 * Checks variables are valid and throws exception if not
	 */
	private function check() {
		if ($this->saturation < 0 || $this->saturation > 100)
			throw new Exception('Saturation must be between 0–100', 1);
		if ($this->lightness < 0 || $this->lightness > 100)
			throw new Exception('Lightness must be between 0–100', 1);
		if (!in_array($this->format, [self::HEX, self::RGB, self::HSL]))
			throw new Exception('Format must be HEX, RGB or HSL', 1);
	}

	/**
	 * output
	 *
	 * Constructs the required return value
	 */
	private function output() {

		// HSL
		if ($this->format === self::HSL) {
			return [
				'h' => $this->hue,
				's' => $this->saturation,
				'l' => $this->lightness,
			];
		}

		// RGB
		if ($this->format === self::RGB) {
			$rgb = self::hsl2rgb(
				$this->hue / 360,
				$this->saturation / 100,
				$this->lightness / 100
			);
			return [
				'r' => $rgb['r'],
				'g' => $rgb['g'],
				'b' => $rgb['b'],
			];
		}

		// HEX
		if ($this->format === self::HEX) {

			// Convert to RGB
			$rgb = self::hsl2rgb(
				$this->hue / 360,
				$this->saturation / 100,
				$this->lightness / 100
			);

			// Convert to hex and pad
			foreach ($rgb as $key => $val)
				$rgb[$key] = str_pad(dechex($val), 2, '0', STR_PAD_LEFT);

			return strtoupper($rgb['r'].$rgb['g'].$rgb['b']);

		}

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
	private function hsl2rgb($h, $s, $l){
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

}
