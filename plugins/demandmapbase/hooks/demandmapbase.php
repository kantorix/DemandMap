<?php defined('SYSPATH') or die('No direct script access.');

class demandmapbase {

  /**
   * Registers the main event add method
   */
  public function __construct() {
    // override items_per_page settings
    Kohana::config_set('settings.items_per_page', '6');
    // Hook into routing
    Event::add('system.pre_controller', array($this, 'add'));
  }

  /**
   * Adds all the events to the main Ushahidi application
   */
  public function add() {
    // modify category filter, to support sublevels and parents
    Event::add('ushahidi_filter.get_incidents_sql', array(
      $this,
      '_add_get_incidents_sql_filter'
    ));
    // change the page title
    Event::add('ushahidi_filter.page_title', array($this, '_modify_page_title'));
    $segments = Router::$segments;
    if ($segments[0] === 'reports' && $segments[1] === 'view') {
      return;
    }
    Event::add('ushahidi_action.page_extra', array($this, '_add_page_extra'));
    // add the filters to main template
    Event::add('ushahidi_action.header_item', array($this, '_add_type_filter'));
    if ($segments[0] === 'main' || empty($segments)) {
      return;
    }
    // add main_js to every page
    Event::add('ushahidi_filter.header_block', array($this, '_add_report_js'));
  }

  function _add_page_extra() {
    if (Event::$data == 1) {
      // add instructions video
      print '<div class="sidebar-right">
      <h2>Watch our instructions video!</h2>
      <iframe src="//player.vimeo.com/video/6284199?title=0&amp;byline=0&amp;portrait=0" width="268" height="162" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
      </div>';
    }
  }

  function _modify_page_title() {
    // Remove Frontpage Sidebar title
    Event::$data = str_replace('Frontpage Sidebar Text', '', Event::$data);
  }

  public function _add_report_js() {
    $view = new View('main/main_js');
    Event::$data .= '<script type="text/javascript">' . $view->render() . '</script>';
  }

  public function _add_get_incidents_sql_filter() {
    // Ushahidi does not support OR where params in array, so we have to make a quick and dirty replace
    Event::$data = preg_replace('/AND c.id = (.*) AND c.category_visible = 1/', 'AND (c.id = $1 OR c.parent_id = $1) AND c.category_visible = 1', Event::$data);
  }

  public function _add_type_filter() {
    // we need to load the category class, because it's not included in the main controller
    Kohana::auto_load('category');
    $categoryController = new category_Core();
    $view = new View('main/type_filters');
    $view->categories = $categoryController->get_category_tree_data();
    $view->render(TRUE);

    $view = new View('main/category_filters');
    $view->categories = $categoryController->get_category_tree_data();
    $view->render(TRUE);
  }

}

new demandmapbase;