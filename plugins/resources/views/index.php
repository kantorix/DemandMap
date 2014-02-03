<h1>Resources</h1>
<?php echo HTML::anchor("resources/submit#resource-submit", "+ New Resource"); ?>
<div class="resources-list">
  <?php foreach ($resources as $material) : ?>
    <?php
    $commentCount = ORM::Factory('talk')->where('material_id', $material->id)->count_all();
    ?>
    <div class="resources-item">
      <h3><?php echo HTML::anchor("resources/view/" . $material->id, $material->title); ?></h3>
      <p><?php echo $material->category->category_title; ?></p>
      <div class="material-content"><?php echo $material->content; ?></div>
      <div class="action-line">
        <span class="commentcount"><?php echo HTML::anchor("resources/view/" . $material->id . "#resource-comments", $commentCount . ' comments'); ?></span>
        <span class="readmore"><?php echo HTML::anchor("resources/view/" . $material->id . "#resource-detail", 'Read more'); ?></span>
      </div>
    </div>
  <?php endforeach; ?>
</div>