<?php

require_once __DIR__ . '/vendor/autoload.php';

add_filter('morph/component/path', function ($path) {
    $path = get_template_directory() . '/components/';
    
    return $path;
});
