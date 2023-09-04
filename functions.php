<?php

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Morph component path override
 */
add_filter('morph/component/path', function ($path) {
    $path = get_template_directory() . '/resources/components/';
    
    return $path;
});

/**
 * Register ACF blocks
 */
add_action('acf/init', function () {
    acf_register_block([
        'name'            => 'message-board',
        'title'           => __('Message Board'),
        'description'     => __('A custom message board block.'),
        'render_callback' => function ($block) {
            morph_component('message-board.create', [], [
                'acf_block_id' => $block['id'],
            ]);

            morph_component(
                'message-board.index',
                [
                    'class'=> 'mt-4',
                ],
                [
                    'acf_block_id' => $block['id'],
                ]
            );
        }
    ]);
});

add_action('acf/init', function () {
    acf_register_block_type([
        'name'            => 'post-love',
        'title'           => __('Post Love'),
        'description'     => __('A custom Post Love element.'),
        'icon'            => 'heart',
        'render_callback' => function ($block) {
            morph_component('post-love.index', [
                'acf_block_id' => $block['id'],
            ]);
        },
    ]);
});

/**
 * Run Waffle queue worker in the background
 */
waffle_worker(['deploy_queue'])->work();

/**
 * Enqueue scripts and styles for the frontend
 */
add_action('wp_enqueue_scripts', function () {
    $version = filemtime(get_template_directory() . '/dist/app.css');
    
    wp_enqueue_script('extend-alpine', get_template_directory_uri() . '/resources/js/extend-alpine.js', [], $version, true);
    wp_enqueue_style('base', get_template_directory_uri() . '/dist/base.css', [], $version);
    wp_enqueue_style('app', get_template_directory_uri() . '/dist/app.css', [], $version);
}, 5);

/**
 * Enqueue scripts and styles for the admin
 */
add_action('wp_enqueue_editor', function () {
    $version = filemtime(get_template_directory() . '/dist/app.css');
    
    wp_enqueue_style('admin-app', get_template_directory_uri() . '/dist/app.css', [], $version);
});

/**
 * Theme support and menu registration
 */
add_filter('after_setup_theme', function () {
    add_theme_support('woocommerce');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    register_nav_menu('primary', 'Primary Menu');
    register_nav_menu('woocommerce', 'Woocommerce Menu');
    register_nav_menu('mobile', 'Mobile Menu');
});

/**
 * Register Custom Post Types
 */
add_action('init', function () {
    register_post_type('todo', [
        'labels'       => [
            'name'          => __('Todos'),
            'singular_name' => __('Todo'),
        ],
        'public'       => true,
        'has_archive'  => false,
        'rewrite'      => ['slug' => 'todos'],
        'show_in_rest' => true,
        'supports'     => ['title', 'editor'],
    ]);
});

/**
 * WooCommerce filters
 */
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
