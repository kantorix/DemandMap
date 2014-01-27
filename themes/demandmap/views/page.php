<div class="region-content">
  <div class="wrapper-inner">
    <div class="content-padding" id="page-id-<?php print $page_id; ?>">
      <?php if (!empty($page_title)) { ?>
        <h1><?php echo html::escape($page_title); ?></h1>
      <?php } ?>
      <div class="page_text"><?php
        echo $page_description;
        Event::run('ushahidi_action.page_extra', $page_id);
        ?></div>
    </div>
  </div>
</div>