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
$div_map = new View('main/map');
print $div_map;
?>