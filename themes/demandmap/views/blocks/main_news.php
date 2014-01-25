<?php blocks::open("news"); ?>
<?php blocks::title(Kohana::lang('ui_main.recent_news')); ?>
<ul class="block-news-list">
<?php
if ($feeds->count() != 0) {
  foreach ($feeds as $feed) {
    $feed_id = $feed->id;
    $feed_title = text::limit_chars($feed->item_title, 40, '...', TRUE);
    $feed_link = $feed->item_link;
    $feed_date = date('Y-m-d', strtotime($feed->item_date));
    $feed_source = text::limit_chars($feed->feed->feed_name, 15, "...");
    ?>
    <li>- <a href="<?php echo $feed_link; ?>" target="_blank"><?php echo $feed_title ?></a></li>
  <?php
  }
}
?>
<?php blocks::close(); ?>