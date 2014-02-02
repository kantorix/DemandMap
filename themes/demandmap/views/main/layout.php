<div class="region-content">
  <div class="wrapper-inner">
    <div class="frontpage-content-columns clearfix">
      <div class="frontpage-content-left">
        <?php
        $pageController = new Page_Controller();
        $pageController->index(5);
        print $pageController->template->content;
        ?>
      </div>
      <div class="frontpage-content-right">
        <?php
        $pageController = new Page_Controller();
        $pageController->index(9);
        print $pageController->template->content;
        ?>
      </div>
    </div>
  </div>
</div>
<div class="region-content">
  <div class="wrapper-inner">
    <div class="content-padding">
      <div id="frontpage-buttons" class="clearfix">
        <div class="frontpage-button frontpage-button-about">
          <div class="frontpage-buttons-inner">
            <a href="<?php print url::site('page/index/2'); ?>"><img src="/themes/demandmap/images/button-about.png" alt=""></a>
            <h3><a href="<?php print url::site('page/index/2'); ?>">About</a></h3>
            <p>Curious about who we are and what we do? Read all about us here!</p>
          </div>
        </div>
        <div class="frontpage-button frontpage-button-submit">
          <div class="frontpage-buttons-inner">
            <a href="<?php print url::site('reports/submit'); ?>"><img src="/themes/demandmap/images/button-submit.png" alt=""></a>
            <h3><a href="<?php print url::site('reports/submit'); ?>">Requests</a></h3>
            <p>Send us your own request by submitting here!</p>
          </div>
        </div>
        <div class="frontpage-button frontpage-button-resources">
          <div class="frontpage-buttons-inner">
            <a href="<?php print url::site('resources'); ?>"><img src="/themes/demandmap/images/button-resources.png" alt=""></a>
            <h3><a href="<?php print url::site('resources'); ?>">Resources</a></h3>
            <p>Want to find out more about current happenings in South Sudan?<br> Browse through our resources!</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- content -->
<div class="region-content">
  <div class="wrapper-inner">
    <div class="content-padding">
      <!-- content blocks -->
      <div class="content-blocks clearfix">
        <ul class="content-column">
          <?php blocks::render(); ?>
        </ul>
      </div>
      <!-- /content blocks -->
    </div>
  </div>
</div>
<!-- content -->