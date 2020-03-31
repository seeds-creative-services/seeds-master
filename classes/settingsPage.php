<?php

namespace SEEDS;

class SettingsPage {

    private $page;
    private $options;

    public function __construct($page = array()) {

        $this->page = (object) $page;

        add_action('admin_menu', array($this, 'add_options_page'));
        add_action('admin_init', array($this, 'page_init'));

    }

    public function add_options_page() {

        add_options_page(
            $this->page->title,
            $this->page->menu->title,
            $this->page->capability,
            $this->page->menu->slug,
            array($this, 'render_admin_page')
        );

    }

    public function render_admin_page() {

        $this->options = get_option($this->page->options->name); ?>

        <div class="wrapper">
            <h1><?php echo $this->page->title; ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields($this->page->options->group);
                do_settings_sections($this->page->menu->slug);
                submit_button();
                ?>
            </form>
        </div>

    <?php }

    public function page_init() {

        register_setting(
            $this->page->options->group,
            $this->page->options->name,
            array($this, 'sanitize')
        );

    }

    public function sanitize() {

    }

}