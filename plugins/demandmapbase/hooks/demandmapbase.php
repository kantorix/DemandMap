<?php defined('SYSPATH') or die('No direct script access.');

class demandmapbase {

  /**
   * Registers the main event add method
   */
  public function __construct() {
    // Hook into routing
    Event::add('system.pre_controller', array($this, 'add'));
  }

  /**
   * Adds all the events to the main Ushahidi application
   */
  public function add() {
    $segments = Router::$segments;
    if ($segments[0] === 'reports' && $segments[1] === 'view') {
      return;
    }
    if ($segments[0] === 'main' || empty($segments)) {
      return;
    }
    Event::add('ushahidi_filter.header_block', array($this, '_add_report_filter_js'));
  }

  public function _add_report_filter_js() {
    $view = new View('main/main_js');
    Event::$data .= '<script type="text/javascript">'.$view->render().'</script>';
  }
}

new demandmapbase;