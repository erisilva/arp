<?php

return [
    'disable' => env('CAPTCHA_DISABLE', false),
    'characters' => ['2', '3', '4', '6', '7', '8', '9', 'A', 'M', 'X', 'T', 'Z', 'B', 'H', 'E', 'F' ],
    'default' => [
        'length' => 5,
        'width' => 260,
        'height' => 80,
        'quality' => 90,
        'math' => false,
        'expire' => 60,
        'encrypt' => false,
        'fontColors' => ['#0A0E0F', '#762323', '#2A0E62', '#495159', '#185796', '#B81B22', '#BA9B03'],
    ],
    'math' => [
        'length' => 9,
        'width' => 120,
        'height' => 36,
        'quality' => 90,
        'math' => true,
    ],

    'flat' => [
        'length' => 6,
        'width' => 160,
        'height' => 46,
        'quality' => 90,
        'lines' => 6,
        'bgImage' => false,
        'bgColor' => '#ecf2f4',
        'fontColors' => ['#0A0E0F', '#762323', '#2A0E62'],
        'contrast' => -5,
    ],
    'mini' => [
        'length' => 3,
        'width' => 60,
        'height' => 32,
    ],
    'inverse' => [
        'length' => 5,
        'width' => 120,
        'height' => 36,
        'quality' => 90,
        'sensitive' => true,
        'angle' => 12,
        'sharpen' => 10,
        'blur' => 2,
        'invert' => true,
        'contrast' => -5,
    ]
];
