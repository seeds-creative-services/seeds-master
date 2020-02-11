<?php

namespace SEEDS;

class Admin {

    public function __construct() {

        error_reporting(0);

        $this->UpdateJqueryVersion();
        $this->EnqueueAssets();
        $this->RemoveSidebarLinks();

    }

	public function UpdatejQueryVersion() {

		add_action('wp_enqueue_scripts', function() {

            wp_deregister_script('jquery');

		    if(file_exists(get_theme_root_uri() . "/" . wp_get_theme()->template . "/node_modules/jquery/dist/jquery.min.js")) {

                wp_register_script('jquery', get_theme_root_uri() . "/" . wp_get_theme()->template . "/node_modules/jquery/dist/jquery.min.js", [], '3.4.1');

            }else{

                wp_register_script('jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js', [], '3.4.1');

            }

			wp_enqueue_script('jquery');

		});

	}

  public function EnqueueAssets() {

    // Enqueue theme admin assets.
		add_action('admin_enqueue_scripts', function() {

			// Enqueue Font Awesome script.
            if(file_exists(get_theme_root_uri() . "/" . wp_get_theme()->template . "/node_modules/@fortawesome/fontawesome-pro/js/all.js")) {

                wp_register_script('font-awesome', get_theme_root_uri() . "/" . wp_get_theme()->template . "/node_modules/@fortawesome/fontawesome-pro/js/all.js", [], '5.9.0');

            }else{

                wp_register_script('font-awesome', 'https://kit.fontawesome.com/29f0ff1eb5.js', [], '5.9.0');

            }

			wp_enqueue_script('font-awesome');

			// Enqueue Google Font styles.
			wp_register_style('google-fonts', 'https://fonts.googleapis.com/css?family=Lato:400,700&display=swap', [], '1.0.0');
			wp_enqueue_style('google-fonts');

			// Enqueue parent theme admin stylesheet if it exists.
			if(file_exists(get_theme_root() . "/" . wp_get_theme()->template . "/assets/dist/css/admin.css")) {

				wp_register_style('seeds-admin-parent-css', get_theme_root_uri() . "/" . wp_get_theme()->template . "/assets/dist/css/admin.css", [], '1.0.0');
				wp_enqueue_style('seeds-admin-parent-css');

			}

			// Enqueue child theme admin stylesheet if it exists.
			if(file_exists(get_stylesheet_directory() . "/assets/dist/css/admin.css")) {

				wp_register_style('seeds-admin-child-css', get_stylesheet_directory_uri() . "/assets/dist/css/admin.css", ['seeds-admin-parent-css'], '1.0.0');
				wp_enqueue_style('seeds-admin-child-css');

			}

			// Enqueue parent theme admin script if it exists.
			if(file_exists(get_theme_root() . "/" . wp_get_theme()->template . "/assets/dist/js/admin.js")) {

				wp_register_script('seeds-admin-parent-js', get_theme_root_uri() . "/" . wp_get_theme()->template . "/assets/dist/js/admin.js", ['jquery'], '1.0.0');
				wp_enqueue_script('seeds-admin-parent-js');

			}

			// Enqueue child theme admin script if it exists.
			if(file_exists(get_stylesheet_directory() . "/assets/dist/js/admin.js")) {

				wp_register_script('seeds-admin-child-js', get_stylesheet_directory_uri() . "/assets/dist/js/admin.js", ['jquery', 'seeds-admin-parent-js'], '1.0.0');
				wp_enqueue_script('seeds-admin-child-js');

			}

		});

	}
	
	function RemoveSidebarLinks() {

		if(!is_admin() || !current_user_can('manage_options')) {

			// Remove Dashboard Menu Items.
			remove_submenu_page('index.php', 'index.php');
			remove_submenu_page('index.php', 'update-core.php');

			// Remove the Plugins Menu Item.
			remove_menu_page('plugins.php');

			// Remove the Tools Menu Item.
			remove_menu_page('tools.php');

			// Remove Appearance Menu Items.
			remove_submenu_page('themes.php', 'themes.php');
			remove_submenu_page('themes.php', 'theme-editor.php');
			remove_submenu_page('themes.php', 'customize.php');
			remove_submenu_page('themes.php', 'customize.php?return=%2Fwp-admin%2Fthemes.php');

			// Remove the Settings Menu Item.
			remove_menu_page('options-general.php');

		}

	}

}