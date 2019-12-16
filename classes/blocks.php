<?php

namespace SEEDS;

class Blocks {

  public function Fetch($post) {

    $blocks = array();

    /** Check if the post has blocks. */
    if(has_blocks($post->post_content)) {

      /** Fetch the blocks from the post. */
      $blocks = parse_blocks($post->post_content);

    }

    return $blocks;

  }

  public static function RenderBlocks($post, $renders, $ignored = array()) {
    
    $output = "";
    $fetched_blocks = array();

    /** Fetch blocks from the specified post. */
    $blocks = self::Fetch($post);

    /** Check if the post has blocks. */
    if(is_array($blocks) && !empty($blocks)) {

      if(is_array($renders)) {

        if(!empty($renders)) {

          foreach($renders as $render) {

            $fetched_blocks[] = self::RenderBlock($blocks, $render, $ignored);

          }

        }else{

          $fetched_blocks[] = self::RenderBlock($blocks, 'all', $ignored);

        }

      } else if(is_string($renders)) {

        if($renders !== "") {

          $fetched_blocks[] = self::RenderBlock($blocks, $renders, $ignored);

        }else{

          $fetched_blocks[] = self::RenderBlock($blocks, 'all', $ignored);

        }

      }

      if(is_array($fetched_blocks) && !empty($fetched_blocks)) {

        foreach($fetched_blocks as $key => $fetched) {

          foreach($fetched as $block) {

            $output .= $block['content'];

          }

        }

      }

    }else{

      $output .= $post->post_content;

    }

    return $output;

  }

  public static function RenderBlock() {

    

  }

  public static function MatchBlock($match, $block) {

    return preg_match("/^{$match}\//", $block);

  }

}