<?php
	require('VarColor.php');
	$strings = [
		'Hello, World!',
		'VarColor',
		'such color',
		'so hue',
		'very hsl',
		'wow',
	];
	function h1($string, $saturation, $lightness) {
		$vc = new VarColor;
		$vc->saturation = $saturation;
		$vc->lightness = $lightness;
		$background = $vc->color($string);
		$color = $vc->contrast($background);
		return sprintf(
			'<p class="vc" style="background: #%1$s; color: %2$s;">%3$s</p>',
			$background,
			$color,
			$string
		);
	}
?><!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>VarColor</title>
		<style>
			body {
				font-family: sans-serif;
			}
			.vc {
				color: white;
				font-weight: bold;
				padding: .5em;
			}
		</style>
	</head>
	<body>
		<h1>VarColor</h1>
		<p>With default Saturation and Lightness of 50</p>
		<?php foreach ($strings as $string) echo h1($string, 50, 50); ?>
		<p>With Saturation set to 80 and Lightness set to 25</p>
		<?php foreach ($strings as $string) echo h1($string, 80, 25); ?>
		<p>With Saturation set to 40 and Lightness set to 80</p>
		<?php foreach ($strings as $string) echo h1($string, 40, 80); ?>
	</body>
</html>