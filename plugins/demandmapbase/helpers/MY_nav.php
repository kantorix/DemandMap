<?php defined('SYSPATH') OR die('No direct access allowed.');

class nav extends nav_Core {
  public static function main_tabs($this_page = FALSE, $dontshow = FALSE) {
    $menu_items = array();

    if (!is_array($dontshow)) {
      // Set $dontshow as an array to prevent errors
      $dontshow = array();
    }

    // Home
    if (!in_array('home', $dontshow)) {
      $menu_items[] = array(
        'page' => 'home',
        'url' => url::site('main'),
        'name' => Kohana::lang('ui_main.home')
      );
    }

    // Reports List
    if (!in_array('reports', $dontshow)) {
      $menu_items[] = array(
        'page' => 'reports',
        'url' => url::site('reports/submit'),
        'name' => Kohana::lang('ui_main.requests')
      );
    }

    // Custom Pages

    if (!in_array('pages', $dontshow)) {
      $pages = ORM::factory('page')->where('page_active', '1')->find_all();
      foreach ($pages as $page) {
        if (!in_array('page/' . $page->id, $dontshow)) {
          $menu_items[] = array(
            'page' => 'page_' . $page->id,
            'url' => url::site('page/index/' . $page->id),
            'name' => $page->page_tab
          );
        }
      }
    }

    Event::run('ushahidi_filter.nav_main_tabs', $menu_items);

    foreach ($menu_items as $item) {
      //$active = ($this_page == $item['page']) ? ' class="active"' : '';
      $active = (substr($this_page, 0, strlen($item['page'])) === $item['page']) ? ' class="active"' : '';
      echo '<li><a href="' . $item['url'] . '"' . $active . '>' . $item['name'] . '</a></li>';
    }

    // Action::nav_admin_reports - Add items to the admin reports navigation tabs
    Event::run('ushahidi_action.nav_main_top', $this_page);
  }
}