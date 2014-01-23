<div class="region-content">
  <div class="wrapper-inner">
    <div class="content-padding report-detail">
      <h1><?php echo html::escape($page_title) ?></h1>
      <div class="page_text"><?php
        echo $page_description;
        Event::run('ushahidi_action.page_extra', $page_id);
        ?></div>
    </div>
  </div>
</div>