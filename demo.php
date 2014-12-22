<?php
	require('VarColor.php');
	$vc = new VarColor;
	$strings = [
		'Hello, World!',
		'VarColor',
		'such color',
		'so hue',
		'very hsl',
		'wow',
	];
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
			}
		</style>
	</head>
	<body>
		<h1>VarColor</h1>
		<p>With default Saturation and Lightness of 50</p>
		<?php
			$options = ['bare' => false];
			foreach ($strings as $string) {
				echo '<p class="vc" style="background: '.$vc->go($string, $options).';padding: 1em;">'.$string.': '.$vc->go($string, $options).'</p>';
			}
		?>
		<p>With Saturation set to 80 and Lightness set to 25</p>
		<?php
			$options = [
				'saturation' => 80,
				'lightness'  => 20,
				'bare'       => false,
			];
			foreach ($strings as $string) {
				echo '<p class="vc" style="background: '.$vc->go($string, $options).';padding: 1em;">'.$string.': '.$vc->go($string, $options).'</p>';
			}
		?>
		<p>With Saturation set to 40 and Lightness set to 80</p>
		<?php
			$options = [
				'saturation' => 40,
				'lightness'  => 70,
				'bare'       => false,
			];
			foreach ($strings as $string) {
				echo '<p class="vc" style="background: '.$vc->go($string, $options).';padding: 1em;">'.$string.': '.$vc->go($string, $options).'</p>';
			}
		?>
	</body>
</html>