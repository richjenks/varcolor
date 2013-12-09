# Color String

Converts a string…into a color!

By using HSL and allowing saturation and lightness to be consistent between uses, every color generated will be of the same tone. Saturation and Lightness can be customised to change the tone.

Also, because it uses MD5, a string will always generate the same color. Useful for allowing elements of an app to be styled without requiring users to select colors manually, e.g. give an object a color based on its title.

The code is heavily-documented so use the source, Luke!

## Usage

### Default Parameters

```php
<?php
require('colorstring.php');
$cs = new ColorString;
$cs->set_string('Awesome');
echo '<h1 style="background: hsl('.$cs->colorstring().');padding: 1em;">'.$cs->get_string().'</h1>';
?>
```

### Custom Parameters

```php
<?php
require('colorstring.php');
$cs = new ColorString;
$cs->set_string('Epic');
$cs->set_saturation(75);
$cs->set_lightness(60);
$cs->set_format('hex');
echo '<h1 style="background: #'.$cs->colorstring().';padding: 1em;">'.$cs->get_string().'</h1>';
?>
```