<?php
$categories = array();
foreach ($material->topics as $reference) {
  echo $categories[] = $reference->title;
}
?>
<div class="resource-detail" id="resource-detail">
  <h1>Resource: <?php echo $material->title; ?> </h1>
  <?php if (!empty($categories)) : ?>
    <h2>Categories: <?php print implode(', ', $categories); ?></h2>
  <?php endif; ?>
  <div class="resource-description"><?php echo nl2br($material->content); ?></div>

  <div class="comment-block report-comments" id="resource-comments">
    <h2>Comments</h2>
    <?php if ($material->talks->count() > 0) : ?>
      <?php foreach ($material->talks as $talk) : ?>
        <div class="report-comment-box">
          <div class="comment-metadata">
            <?php echo date('M j Y', strtotime($talk->create_date)); ?>
            <?php
            if (!empty($talk->nickname)) {
              print ' written by ' . $talk->nickname;
            }
            ?>
          </div>
          <div class="comment-description"><?php echo nl2br(html::escape($talk->description)); ?></div>
        </div>
      <?php endforeach; ?>
    <?php else : ?>
      <p><strong>No comments. Be the first to add a comment.</strong></p>
    <?php endif; ?>
  </div>

  <h2>Write a new comment:</h2>

  <div id="commentForm">
    <?php echo Form::open('resources/view/' . $material->id); ?>
    <?php echo Form::label("nickname", "Nickname"); ?>
    <?php echo Form::input("nickname", "", ' class="text"'); ?>
    <br/>
    <br/>
    <?php echo Form::label("email", "Email"); ?>
    <?php echo Form::input("email", "", ' class="text"'); ?>
    <br/>
    <br/>
    <?php echo Form::label("comment", "Comment *"); ?>
    <?php echo Form::textarea("comment", "", ' class="textarea"'); ?>
    <br/>
    <?php echo Form::submit("submit", "Submit Comment", ' class="btn_submit"'); ?>
    <?php echo Form::close(); ?>
    <br/>
  </div>
</div>