<?php

namespace SEEDS;

class MetaBox  {

    private $id;
    private $title;
    private $content;
    private $screens = array();
    private $context = 'advanced';
    private $priority = 'default';


    public function __construct($id, $title, $content, $screens, $context, $priority) {

        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->context = $context;
        $this->priority = $priority;

        if(is_string($screens)) {

            if($screens === "all") {

                foreach(get_post_types('', 'objects') as $post_type) {

                    if($post_type->public == 1 || $post_type->public == "1") {

                        array_push($this->screens, $post_type->name);

                    }

                }

            }else{

                $this->screens = (array) $screens;

            }

        }else{

            $this->screens = $screens;

        }

        add_action("add_meta_boxes", array($this, 'register'));

    }

    public function register() {

        add_meta_box(
            $this->id,
            $this->title,
            array($this, 'render'),
            $this->screens,
            $this->context,
            $this->priority
        );

        add_action("save_post", array($this, 'save'));

    }

    public function render() {

        echo $this->content;

    }


    // TODO Save method is not working

    public function save($post_id) {

        echo print_r($_POST, true);

        if(isset($_POST["{$this->id}_nonce"])) {

            if(!wp_verify_nonce($_POST["{$this->id}_nonce"], basename(__FILE__))) {

                return $post_id;

            }

            if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE) {

                return $post_id;

            }

            if(!current_user_can("edit_page", $post_id)) {

                return $post_id;

            }

            $previous_meta = get_post_meta($post_id, $this->id, TRUE);
            $current_meta = $_POST[$this->id];

            if($current_meta && $current_meta !== $previous_meta) {

                update_post_meta($post_id, $this->id, $current_meta);

            }

            if("" === $current_meta && $previous_meta) {

                delete_post_meta($post_id, $this->id, $previous_meta);

            }

        }

    }

}