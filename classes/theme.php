<?php

namespace SEEDS;

class Theme {

    public function __construct() {

        Theme::Init();

    }

    public static function Init() {

        /**
        * Disabled the WordPress Emoji functionality.
        * It's not really useful and adds unnecessary overhead.
        */

        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('admin_print_styles', 'print_emoji_styles');

        /**
        * Remove some additional overhead from the WordPress core.
        * RSS feeds, canonical links and XML references.
        */

        remove_action('wp_head', 'feed_links_extra', 3);
        remove_action('wp_head', 'feed_links', 2);
        remove_action('wp_head', 'rsd_link');
        remove_action('wp_head', 'wlwmanifest_link');
        remove_action('wp_head', 'index_rel_link');
        remove_action('wp_head', 'wp_generator');
        remove_action('wp_head', 'rel_canonical');

        /**
         * Enable theme support for different features.
         */

        add_action('after_setup_theme', function() {

            /**
             * Allow custom logo and post thumbnails.
             */

            add_theme_support('post-thumbnails');
            add_theme_support('custom-logo');

            /**
             * Add Gutenberg theme support.
             */

            add_theme_support('wp-block-styles');
            add_theme_support('align-wide');

            /**
             * Enable localization support.
             */

            load_theme_textdomain('seeds-child');

            /**
             * Output valid HTML5 markup.
             */

            add_theme_support('html5', array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'script',
                'style'
            ));

        });

    }

    public function RegisterMenuLocations($locations = array()) {

        if(isset($locations) && is_array($locations) && !empty($locations)) {

            register_nav_menus($locations);

        }

    }

}