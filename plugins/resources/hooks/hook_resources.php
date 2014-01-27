<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Hello world.... how are you?
 */
class hook_resources {

  /**
   * Registers the main event add method
   *
   * Pretty much just adds the add() method below to the generic
   * system.pre_controller event, effectively an event to add the other events
   */
  public function __construct() {
    // Hook into routing
    Event::add('system.pre_controller', array($this, 'add'));
  }

  /**
   * Adds all the events to the main Ushahidi application
   */
  public function add() {
    Event::add('ushahidi_filter.nav_main_tabs', array($this, '_add_resources_menu_item'));
  }

  /**
   * Says hello to the world.
   */
  public function _add_resources_menu_item() {
    $menuItem = array();
    $menuItem[] = array(
      'page' => 'resources',
      'url' => url::site('resources'),
      'name' => Kohana::lang('ui_main.resources')
    );
    array_splice(Event::$data, 3, 0, $menuItem);
  }
}

new hook_resources();
