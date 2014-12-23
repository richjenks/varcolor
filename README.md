# VarColor

Turns any variable into a color - vars will yield the same color every time!

Can be used for styling items based on their name, perhaps to avoid hardcoding colors or to give user interfaces some variety without having to develop color options for end users.

## Basic Usage

```php
require('VarColor.php');
$string = 'Awesome';

echo '<h1 style="background: '.$VarColor::go($string, ['bare'=>false]).';padding: 1em;">'.$string.'</h1>';
```

## Options

Pass options in an array as the second parameter to `go`. Example:

```php
$options = [
    'saturation' => 75,
    'lightness'  => 60,
    'format'     => 'hex',
    'bare'       => false,
];
echo VarColor::go('Sup', $options);

// Outputs: #4c6de5
```

- `saturation` / `lightness`

    The Saturation / Lightness of the generated color. Defaults to 50.

- `format`

    The format to return the color in, either `hsl`, `hex` or `rgb`. Defaults to 'hex'.

- `bare`

    When true, outputs bare variables in an array (one for each part, e.g. red, green and blue separately). When false, wraps the variables for use in CSS.
