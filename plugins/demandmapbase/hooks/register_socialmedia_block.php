<?php defined('SYSPATH') or die('No direct script access.');

class social_media_block {

  public function __construct() {
    // Array of block params
    $block = array(
      "classname" => "social_media_block", // Must match class name above
      "name" => "Social Media Box",
      "description" => "Displays a facebook box"
    );
    // register block with core, this makes it available to users
    blocks::register($block);
  }

  public function block() {
    // Load the reports block view
    $content = new View('blocks/social_media_block');
    echo $content;
  }
}

new social_media_block;