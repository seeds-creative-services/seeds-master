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

  }

  public function RegisterMenuLocations($locations = array()) {

    if(isset($locations) && is_array($locations) && !empty($locations)) {

      register_nav_menus($locations);

    }

  }

}