<?php

/*
 * Every upload is re-encoded to WebP. "height" set means the image is cropped to that
 * exact frame (so templates can reserve space without knowing the file); null keeps
 * the original aspect ratio and the real dimensions are stored on the model.
 * "variants" are extra, smaller widths used to build srcset.
 */
return [
    'disk' => 'public',

    'quality' => 82,

    'max_upload_kb' => 5120,

    'presets' => [
        'project_thumbnail' => [
            'directory' => 'projects',
            'width' => 1600,
            'height' => 1200,
            'variants' => [480, 960],
        ],
        'project_gallery' => [
            'directory' => 'projects/gallery',
            'width' => 2000,
            'height' => null,
            'variants' => [800, 1200],
        ],
        'profile_photo' => [
            'directory' => 'profile',
            'width' => 960,
            'height' => 1200,
            'variants' => [480],
        ],
        'certificate' => [
            'directory' => 'certificates',
            'width' => 1200,
            'height' => 900,
            'variants' => [600],
        ],
        'og_image' => [
            'directory' => 'seo',
            'width' => 1200,
            'height' => 630,
            'variants' => [],
        ],
    ],
];
