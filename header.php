<!DOCTYPE html>
<html class="h-full" lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
    <style>
        [x-cloak] { 
            display: none !important; 
        }
    </style>
</head>
<body <?php body_class('bg-zinc-100 flex flex-col font-mono h-full overflow-x-hidden overflow-y-scroll text-zinc-900'); ?>>
    <header 
        class="border-b border-zinc-800 flex items-center justify-between px-4 py-2"
        x-data="{
            showMobileMenu: false,
        }">
        <h1 class="flex-1 font-bold">
            <a href="/"><?php bloginfo('name'); ?></a>
        </h1>

        <?php wp_nav_menu([
            'theme_location' => 'primary',
            'container'      => 'nav',
            'menu_class'     => 'divide-x divide-zinc-800 font-semibold hidden items-center lg:flex [&_>_li]:px-4',
        ]); ?>
        
        <nav class="hidden flex-1 items-center justify-end space-x-2 lg:flex">
            <?php wp_nav_menu([
                'theme_location' => 'woocommerce',
                'container'      => 'nav',
                'menu_class'     => 'flex font-semibold items-center pr-4 space-x-4',
            ]); ?>

            <?php morph_component('woocommerce.cart-icon'); ?>
        </nav>

        <nav class="lg:hidden">
            <button
                class="cursor-pointer duration-150 grid transform"
                x-bind:class="{ '-rotate-45': showMobileMenu }"
                x-on:click="showMobileMenu = !showMobileMenu">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5" />
                </svg>
            </button>
            <div
                class="bg-zinc-100 duration-300 h-[calc(100vh-41px)] fixed max-w-[250px] overflow-y-auto px-4 py-8 right-0 shadow-md top-[41px] transform w-full z-20"
                x-bind:class="{ 'translate-x-full': !showMobileMenu }"
                x-cloak>
                <?php wp_nav_menu([
                    'theme_location' => 'mobile',
                    'container'      => 'nav',
                    'menu_class'     => 'flex flex-col font-semibold items-center space-y-4',
                ]); ?>
                <div class="border-t border-zinc-800 mt-4 pt-4">
                    <?php //morph_component('woocommerce.cart-mini'); ?>
                </div>
            </div>
            <div
                class="bg-zinc-800 duration-300 fixed h-full left-0 top-[41px] w-full z-10"
                x-bind:class="[showMobileMenu ? 'bg-opacity-30 visible' : 'bg-opacity-0 invisible']"
                x-on:click="showMobileMenu = false"
                x-cloak>
            </div>
        </nav>
    </header>
    <main class="flex-1">
