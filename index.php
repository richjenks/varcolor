<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>ColorString</title>
	</head>
	<body>
		<?php
			require('colorstring.php');
			$cs = new ColorString;
			$cs->set_string('Winning');
			// $cs->set_saturation(75);
			$cs->set_lightness(60);

			$cs->set_format('hsl');
			echo '<h1 style="background: hsl('.$cs->colorstring().');padding: 1em;">'.$cs->get_string().'</h1>';

			$cs->set_format('rgb');
			echo '<h1 style="background: rgb('.$cs->colorstring().');padding: 1em;">'.$cs->get_string().'</h1>';

			$cs->set_format('hex');
			echo '<h1 style="background: #'.$cs->colorstring().';padding: 1em;">'.$cs->get_string().'</h1>';
		?>
	</body>
</html>