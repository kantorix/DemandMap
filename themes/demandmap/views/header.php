<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php echo $page_title . $site_name; ?></title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title></title>
  <meta name="description" content="">
  <meta name="MobileOptimized" content="width">
  <meta name="HandheldFriendly" content="true">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="cleartype" content="on">
  <?php echo $header_block; ?>
  <script src="http://maps.google.com/maps/api/js?v=3&sensor=false"></script>
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

<?php
$auth = Auth::instance();
if ($auth->logged_in()) {
  print $header_nav;
}
?>

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
      <a href="https://www.facebook.com/demandmap" target="_blank">Facebook</a> |
      <a href="https://twitter.com/DemandMap" target="_blank">Twitter</a> |
      <a href="mailto:&#100;&#101;&#109;&#97;&#110;&#100;&#109;&#97;&#112;&#64;&#119;&#101;&#98;&#46;&#100;&#101;" target="_blank">Mail</a>
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
    <div id="logo"><a href="<?php echo url::site(); ?>"><img src="/themes/demandmap/images/logo.png" alt="<?php echo $site_name; ?>"></a></div>
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
$div_map = new View('main/map');
print $div_map;
?>
<div class="region-content">
  <div class="wrapper-inner">
    <div class="content-padding clearfix">