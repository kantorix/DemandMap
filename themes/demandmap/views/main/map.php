
<div class="collapsible-views">
  <!-- map -->
  <div class="collapsible-map">
    <div class="map map-fullwidth <?php if (Kohana::config('settings.enable_timeline')) { echo 'timeline-enabled'; } ?>" id="map"></div>
   </div>
  <!-- / map -->
  <div class="collapsible-list">
    <div class="wrapper-inner-list">
      <div class="list-view">
      <?php
      $reportController = new Reports_Controller();
      $reportController->fetch_reports();
      ?>
      </div>
    </div>
  </div>
</div>
<div class="map-pager">
  <div class="wrapper-inner">
    <div class="trigger-maplist">
      <a href="#" id="trigger-map">Map view</a> | <a href="#" id="trigger-list">List view</a>
    </div>
    <div class="trigger-collapse">
      <a href="#" id="trigger-shrink-map">minimize</a>
      <a href="#" id="trigger-expand-map">expand</a>
    </div>
  </div>
</div>
<?php

?>