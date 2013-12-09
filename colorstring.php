<?php

/**
 * ColorString
 * 
 * Turns a string into a color
 * 
 * By using HSL and allowing saturation and lightness to be consistent between
 * uses, every color generated will be of the same tone. Saturation and
 * Lightness can be customised to change the tone.
 * 
 * Also, because it uses MD5, a string will always generate the same color.
 * Useful for allowing elements of an app to be styled without requiring users
 * to select colors manually, e.g. give an object a color based on its title.
 * 
 * @author Rich Jenks <rich@richjenks.com>
 * @copyright Copyright (c) 2013, Rich Jenks
 * @license http://opensource.org/licenses/gpl-3.0.html
 * @version 1.0
 */

class ColorString {

	/**
	 * Color variables
	 * 
	 * Hue, Saturation and Lightness of the input color.
	 * Input string defaults to an empty string — set with set_string()
	 * Format defines the output format ('hsl', 'rgb' or 'hex')
	 */

	private $hue		= 50;
	private $saturation	= 50;
	private $lightness	= 50;
	private $string		= '';
	private $format		= 'hsl';

	/**
	 * Obligatory Getter functions
	 * 
	 * Each color variable has a getter function. Example:
	 * 
	 * <code>
	 * <?php echo get_hue();?>
	 * </code>
	 * 
	 * @return int|string
	 */

	public function get_hue()			{return $this->hue;}
	public function get_saturation()	{return $this->saturation;}
	public function get_lightness()		{return $this->lightness;}
	public function get_string()		{return $this->string;}
	public function get_format()		{return $this->format;}

	/**
	 * Obligatory Setter functions
	 * 
	 * Each color variable has a setter function. Example:
	 * 
	 * <code>
	 * <?php set_hue();?>
	 * </code>
	 * 
	 * @param int|string hue|saturation|lightness|string|format The value to be set
	 * 
	 * Hue, Saturation and Lightness expect ints (between 0—100)
	 * String and Format expect strings
	 */

	public function set_hue($hue)					{$this->hue = $hue;}
	public function set_saturation($saturation)		{$this->saturation = $saturation;}
	public function set_lightness($lightness)		{$this->lightness = $lightness;}
	public function set_string($string)				{$this->string = $string;}
	public function set_format($format)				{$this->format = $format;}


	/**
	 * colorstring
	 * 
	 * Creates a color from a string using color variables defined above
	 * 
	 * @return string
	 */

	public function colorstring() {

		// Generate hue
		if($this->string != '') {
			$this->hue = md5($this->string);			// MD5 the string
			$this->hue = substr($this->hue,0,3);		// Take the first 3 chars (hex value between 0–4095)
			$this->hue = hexdec($this->hue);			// Convert hex to decimal int
			$this->hue = $this->hue / 11.4066852368;	// Divide to get float between 0–359
			$this->hue = round($this->hue);				// Round down to nearest int
		}

		// Format color — default to HSL
		switch($this->format) {
			case 'rgb':
				$rgb = $this->ColorHSLToRGB(
					$this->hue / 360,
					$this->saturation / 100,
					$this->lightness / 100
				);
				$color = $rgb['r'].','.$rgb['g'].','.$rgb['b'];
				break;
			case 'hex':
				$rgb = $this->ColorHSLToRGB(
					$this->hue / 360,
					$this->saturation / 100,
					$this->lightness / 100
				);
				$color = dechex($rgb['r']).dechex($rgb['g']).dechex($rgb['b']);
				break;
			default:
				$color = $this->hue.','.$this->saturation.'%,'.$this->lightness.'%';
		}

		return $color;

	}

	/**
	 * ColorHSLToRGB
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

	private function ColorHSLToRGB($h, $s, $l){

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

		return array('r' => floor($r * 255), 'g' => floor($g * 255), 'b' => floor($b * 255));

	}

}

?>