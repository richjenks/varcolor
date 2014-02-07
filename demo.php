<?php
	require('colorstring.php');
	$cs = new ColorString;
	$strings = [
		'Hello, World!',
		'Color String',
		'such color',
		'so hue',
		'very hsl',
		'wow',
	];
?><!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>ColorString</title>
		<style>
			body {
				font-family: sans-serif;
			}
			.cs {
				color: white;
				font-weight: bold;
			}
		</style>
	</head>
	<body>
		<h1>ColorString</h1>
		<p>With default Saturation and Lightness of 50</p>
		<?php
			foreach ($strings as $string) {
				$cs->set_string($string);
				echo '<p class="cs" style="background: hsl('.$cs->colorstring().');padding: 1em;">'.$cs->get_string().' hsl('.$cs->colorstring().')</p>';
			}
		?>
		<p>With Saturation set to 80 and Lightness set to 25</p>
		<?php
			$cs->set_saturation(80);
			$cs->set_lightness(25);
			foreach ($strings as $string) {
				$cs->set_string($string);
				echo '<p class="cs" style="background: hsl('.$cs->colorstring().');padding: 1em;">'.$cs->get_string().' hsl('.$cs->colorstring().')</p>';
			}
		?>
		<p>With Saturation set to 40 and Lightness set to 80</p>
		<?php
			$cs->set_saturation(40);
			$cs->set_lightness(80);
			foreach ($strings as $string) {
				$cs->set_string($string);
				echo '<p class="cs" style="background: hsl('.$cs->colorstring().');padding: 1em;">'.$cs->get_string().' hsl('.$cs->colorstring().')</p>';
			}
		?>
	</body>
</html>