<?php

return [
    'defaults' => [
        'viewMode' => 2,
        'dragMode' => 'move',
        'autoCropArea' => 1,
        'background' => true,
        'responsive' => true,
        'restore' => false,
        'checkCrossOrigin' => true,
        'checkOrientation' => true,
        'modal' => true,
        'guides' => true,
        'center' => true,
        'highlight' => true,
        'cropBoxMovable' => true,
        'cropBoxResizable' => true,
        'toggleDragModeOnDblclick' => true,
        'minCropBoxWidth' => 100,
        'minCropBoxHeight' => 100,
    ],

    'presets' => [
        // Squares commonly used for product and variant images
        'square' => [
            'aspectRatio' => 1,
            'outputWidth' => 800,
            'outputHeight' => 800,
        ],

        // Homepage randomized grid can be various; use square by default
        'homepage' => [
            'aspectRatio' => null,
            'outputWidth' => 1200,
            'outputHeight' => 1200,
        ],

        // Banner style promos
        'banner' => [
            'aspectRatio' => 16/9,
            'outputWidth' => 1920,
            'outputHeight' => 1080,
        ],
    ],
];


