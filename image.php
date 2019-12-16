<?php

/**
 * Disable image pages - instead redirect directly to the image file.
 * @since 1.0.0
 */

wp_redirect(get_permalink($post->post_parent));