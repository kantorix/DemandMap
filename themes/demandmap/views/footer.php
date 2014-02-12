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
        // Action::nav_main_bottom - Add items to the bottom links
        Event::run('ushahidi_action.nav_main_bottom');
        ?>
      </ul>
      <?php if ($site_copyright_statement != ''): ?>
        <p><?php echo $site_copyright_statement; ?></p>
      <?php endif; ?>
    </div>
    <!-- / footer menu -->

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