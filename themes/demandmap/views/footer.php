    </div>
  </div>
</div>
<!-- / wrapper -->

<!-- footer -->
<div id="region-footer">
  <div class="wrapper-inner">

    <!-- footer content -->
    <!-- footer menu -->
    <div id="footermenu">
      <ul>
        <li><a href="<?php echo url::site('page/index/2'); ?>"><?php echo Kohana::lang('ui_main.about'); ?></a></li>
        <li>•</li>
        <li><a href="<?php echo url::site() . "contact"; ?>"><?php echo Kohana::lang('ui_main.contact_item'); ?></a></li>
        <li>•</li>
        <li><a href="<?php echo url::site('page/index/8'); ?>"><?php echo Kohana::lang('ui_main.legal_notice'); ?></a></li>
        <?php
        $auth = Auth::instance();
        if (!$auth->logged_in()) {
        ?>
        <li>•</li>
        <li><a href="<?php echo url::site('login'); ?>">Login</a></li>
        <?php } ?>
        <?php
        // Action::nav_main_bottom - Add items to the bottom links
        Event::run('ushahidi_action.nav_main_bottom');
        ?>
      </ul>
    </div>
    <?php if ($site_copyright_statement != ''): ?>
      <p class="copyright"><?php echo $site_copyright_statement; ?></p>
    <?php endif; ?>
    <!-- / footer menu -->
    <div class="disclaimer">
      <p><strong>*Disclaimers:</strong>
        <br>South Sudan DemandMap claims no responsibility to the represented borders of the Google map data.
      </p>
      <p>The views and opinions expressed in the media, articles or comments on this community site are those of the speakers or authors and do not necessarily reflect or represent the views and opinions held by South Sudan DemandMap.</p>
    </div>
    <!-- / footer content -->
  </div>
</div>
<!-- / footer -->

<div id="footer-block">
  <?php
  echo $footer_block;
  // Action::main_footer - Add items before the </body> tag
  Event::run('ushahidi_action.main_footer');
  ?>
</div>
</body>
</html>
