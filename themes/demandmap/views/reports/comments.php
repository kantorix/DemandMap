<?php if (count($incident_comments) > 0): ?>
  <div class="report-comments">
    <h2><?php echo Kohana::lang('ui_main.comments'); ?></h2>
    <?php foreach ($incident_comments as $comment): ?>
      <div class="report-comment-box">
        <div class="comment-metadata">
         <?php echo date('M j Y', strtotime($comment->comment_date)); ?>
        </div>
        <div class="comment-description"><?php echo html::escape($comment->comment_description); ?></div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>