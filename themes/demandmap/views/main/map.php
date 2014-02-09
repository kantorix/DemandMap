<div class="collapsible-views">
  <!-- map -->
  <div class="collapsible-map">
    <div class="map map-fullwidth <?php if (Kohana::config('settings.enable_timeline')) { echo 'timeline-enabled'; } ?>" id="map"></div>
  </div>
  <!-- / map -->
  <?php
  $segments = Router::$segments;
  if (!($segments[0] === 'reports' && $segments[1] === 'view')) {
    ?>
    <div class="collapsible-list">
      <div class="wrapper-inner-list">
        <div class="list-view clearfix">
          <?php
          $reportController = new Reports_Controller();
          $reportController->fetch_reports();
          ?>
        </div>
      </div>
    </div>
  <?php } ?>
</div>
<div class="map-pager">
  <?php
  $segments = Router::$segments;
  if (!($segments[0] === 'reports' && $segments[1] === 'view')) {
  ?>
  <div class="wrapper-inner">
    <div class="trigger-maplist">
      <a href="#" id="trigger-map" class="active" title="Switch to Map view">Map view</a>
      | <a href="#" id="trigger-list" title="Switch to List view">List view</a>
    </div>
    <div class="trigger-collapse">
      <a href="#" id="trigger-shrink-map">minimize</a>
      <a href="#" id="trigger-expand-map">expand</a>
    </div>
    <?php } ?>
  </div>
</div>