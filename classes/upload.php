<?php

/**
Plugin Name: SEEDS: Testimonials & Reviews
Description: Manage SEO meta content for pages.
Version: 1.0.0
Author: Seeds Creative Services, LLC.
Author URI: https://seedscreativeservices.com
Text Domain: seeds_reviews
 */

namespace SEEDS;

include_once(ABSPATH . 'wp-admin/includes/file.php');
include_once(ABSPATH . 'wp-admin/includes/media.php');
include_once(ABSPATH . 'wp-admin/includes/image.php');

class UploadURL {

    private $attachment_id;
    private $attachment_meta;
    private $image;

    private $image_url;
    private $upload_path;
    private $file;

    public function __construct($url, $filename = 'original') {

        $this->image_url = $url;
        $this->upload_path = wp_upload_dir();

        $pattern = '/(?<name>[^\/]*)(?<extension>.jpg|jpeg|.png|.gif)/';
        preg_match_all($pattern, $url, $image);

        $this->file = array(
            'name' => $image['name'][0],
            'extension' => $image['extension'][0]
        );

        if($filename !== 'original') {
            $this->file['name'] = $filename;
        }

        $this->file['full'] = $this->file['name'] . $this->file['extension'];
        $this->file['path'] = $this->upload_path['path'] . '/' . $this->file['full'];

        $this->Upload();

    }

    private function Upload() {

        if($contents = wp_remote_get($this->image_url)) {

            if(is_array($contents)) {

                if($save_file = fopen($this->file['path'], 'w')) {

                    if(fwrite($save_file, $contents['body'])) {

                        fclose($save_file);
                        $this->Register();

                    }

                }

            }

        }

    }

    private function ImageExists() {

        $image_url = $this->upload_path['url'].'/'.$this->file['full'];

        return attachment_url_to_postid($image_url);

    }

    private function Register() {

        // Build the assumed image URL.
        $image_url = $this->upload_path['url'].'/'.$this->file['full'];

        // Get the image ID from the assumed URL.
        $this->attachment_id = attachment_url_to_postid($image_url);

        // There's already an attachment.
        if($this->attachment_id) return;

        // Get the MIME type of the uploaded image.
        $file_type = \wp_check_filetype(basename($this->file['full']), null);

        $attachment = array(
            'post_mime_type' => $file_type['type'],
            'post_title' => $this->file['name'],
            'post_content' => '',
            'post_status' => 'inherit'
        );

        // Generate an attachment ID for the uploaded image.
        $this->attachment_id = wp_insert_attachment($attachment, $this->file['path']);
        $this->image = get_post($this->attachment_id);

        // Generate different sizes of the image.
        $this->attachment_meta = \wp_generate_attachment_metadata($this->attachment_id, $this->file['path']);

        // Register the uploaded image in the media library.
        wp_update_attachment_metadata($this->attachment_id, $this->attachment_meta);

    }

    public function GetImage() {

        return $this->image;

    }

    public function GetImageID() {

        return $this->attachment_id;

    }

    public function GetImageURL($size = 'full') {

        return wp_get_attachment_image_src($this->attachment_id, $size, false)[0];

    }

}