<?php

namespace SEEDS;

class Login {

  public $theme_uri;

  public function __construct() {

    $this->$theme_uri = get_template_directory_uri();

    add_action('login_enqueue_scripts', function() {

      wp_enqueue_style('custom-login', "{$this->$theme_uri}/assets/dist/css/login.css");

    });

  }

}