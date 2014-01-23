<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Hooks for Density Map plugin
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author           John Etherton <john@ethertontech.com>
 * @package    Ushahidi - http://source.ushahididev.com
 * @module           Density Map Hooks
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */

class demandmapbase {

  /**
   * Registers the main event add method
   */
  public function __construct()
  {
    // Hook into routing
    Event::add('system.pre_controller', array($this, 'add'));
  }

  /**
   * Adds all the events to the main Ushahidi application
   */
  public function add()
  {
    Event::add('ushahidi_action.header_scripts', array($this, '_add_report_filter_js'));
  }

  /**
   * This will add in the UI needed for the Density map filter
   */
  public function _add_report_filter_js()
  {
    $view = new View('main/main_js');
    $view->render(true);
  }
}

new demandmapbase;