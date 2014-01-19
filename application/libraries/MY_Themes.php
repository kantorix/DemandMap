<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Custom extension for the Themes library
 * @TODO: Try to put it into a non-core folder
 */

class Themes extends Themes_Core {

  public function search() {
    $search = '';
    $search .= '<div class="search-form">';
    $search .= form::open('search', array('method' => 'get', 'id' => 'search'));
    $search .= '<input type="text" name="k" value="" class="text" placeholder="Search…">';
    $search .= '<input type="submit" name="b" class="searchbtn" value="' . Kohana::lang('ui_main.search') . '">';
    $search .= form::close();
    $search .= '</div>';

    return $search;
  }
}