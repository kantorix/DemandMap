<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php echo $page_title . $site_name; ?></title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title></title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php echo $header_block; ?>
  <?php
  // Action::header_scripts - Additional Inline Scripts from Plugins
  Event::run('ushahidi_action.header_scripts');
  ?>
</head>

<?php
// Add a class to the body tag according to the page URI

// we're on the home page
if (count($uri_segments) == 0) {
  $body_class = "page-main";
}
// 1st tier pages
elseif (count($uri_segments) == 1) {
  $body_class = "page-" . $uri_segments[0];
}
// 2nd tier pages... ie "/reports/submit"
elseif (count($uri_segments) >= 2) {
  $body_class = "page-" . $uri_segments[0] . "-" . $uri_segments[1];
}
?>
<body id="page" class="<?php echo $body_class; ?>">

<!-- top bar-->
<div id="region-top" class="clearfix">
  <div class="wrapper-inner">
    <!-- searchbox -->
    <div id="block-search">
      <!-- searchform -->
      <?php echo $search; ?>
      <!-- / searchform -->
    </div>
    <div id="block-sociallinks">
      <a href="http://www.facebook.com" target="_blank">Facebook</a> |
      <a href="http://www.twitter.com" target="_blank">Twitter</a> |
      <a href="mailto:test@test.com" target="_blank">Mail</a>
    </div>
  </div>
</div>
<!-- / searchbox -->

<!-- header -->
<div id="header" class="clearfix">
  <div class="wrapper-inner">
    <!-- logo -->
    <?php if ($banner == NULL): ?>
      <div id="logo">
        <h1><a href="<?php echo url::site(); ?>"><?php echo $site_name; ?></a>
        </h1>
        <span><?php echo $site_tagline; ?></span>
      </div>
    <?php else: ?>
      <a href="<?php echo url::site(); ?>"><img src="<?php echo $banner; ?>" alt="<?php echo $site_name; ?>" id="logo"></a>
    <?php endif; ?>
    <!-- / logo -->

    <ul id="menu-mainmenu">
      <?php nav::main_tabs($this_page); ?>
    </ul>
  </div>
</div>
<!-- / header -->
<!-- / header item for plugins -->
<?php
// Action::header_item - Additional items to be added by plugins
Event::run('ushahidi_action.header_item');
?>
<?php
// Map and Slider Blocks
// Map Settings
$marker_radius = Kohana::config('map.marker_radius');
$marker_opacity = Kohana::config('map.marker_opacity');
$marker_stroke_width = Kohana::config('map.marker_stroke_width');
$marker_stroke_opacity = Kohana::config('map.marker_stroke_opacity');

$map_js = new View('main/main_js');

$map_js->marker_radius = ($marker_radius >=1 AND $marker_radius <= 10 )
  ? $marker_radius
  : 5;

$map_js->marker_opacity = ($marker_opacity >=1 AND $marker_opacity <= 10 )
  ? $marker_opacity * 0.1
  : 0.9;

$map_js->marker_stroke_width = ($marker_stroke_width >=1 AND $marker_stroke_width <= 5)
  ? $marker_stroke_width
  : 2;

$map_js->marker_stroke_opacity = ($marker_stroke_opacity >=1 AND $marker_stroke_opacity <= 10)
  ? $marker_stroke_opacity * 0.1
  : 0.9;


$map_js->active_startDate = $display_startDate;
$map_js->active_endDate = $display_endDate;

$map_js->blocks_per_row = Kohana::config('settings.blocks_per_row');

$div_map = new View('main/map');
print $div_map;
?>