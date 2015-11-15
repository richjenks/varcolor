# VarColor

Turns any variable into a color - vars will yield the same color every time!

Can be used for styling items based on their name, perhaps to avoid hardcoding colors or to give user interfaces some variety without having to develop color options for end users.

Supports "theming" — multiple colors can be generated with the same lightness and/or saturation so they don't look clash with your design. For example, perhaps you need pastels or dark, saturated colors.

See `demo.php` for usage examples.

## Basic Usage

VarColor has two main functions:

- `hex` generates a quick hex from a variable
- `color` generates a color with preset saturation and lightness

## Hex function

Simply pass a variable and a hex color is returned:

```php
require('VarColor.php');
$vc = new VarColor;
echo $vc->hex('Hello, World!');
// 65A8E2
```

## Color function

Change `$vc->saturation` and `$vc->lightness` to "theme" your colors. They default to `50` and must be 0–100. Example usage:

```php
require('VarColor.php');

$vc = new VarColor;
$vc->saturation = 75;
$vc->lightness = 25;
$hex = $vc->color('Simples');

echo '<h1 style="background: #'.$hex.';">'.$hex.'</h1>';
```

Change `$vc->format` to choose the return type:

- `$vc->format = $vc::HEX` (default) for hex string
- `$vc->format = $vc::RGB` for array of `r`, `g` & `b`
- `$vc->format = $vc::HSL` for aray of `h`, `s` & `l`

For example:

```php
$vc->format = $vc::HSL;
$vc->color('Hello, World!');
// Returns: ['h' => 143, 's' => 50, 'l' => 50]
```

## Contrast function

The `contrast()` function determines whether black or white has the most contrast with a given hex color and is useful for determining the color for overlayed text. For example:

```php
$color = $vc->color('Hello, World');
echo $text = $vc->contrast($color);
// white
```