<!-- category filters -->
<div id="region-filter" class="clearfix">
  <div class="wrapper-inner">
    <ul id="type_switch" class="type-filters">
      <li>
        <a class="active" id="cat_" href="#">
          <span <?php echo $color_css; ?>><?php echo $all_cat_image; ?></span>
          <span class="category-title"><?php echo Kohana::lang('ui_main.all_categories'); ?></span>
        </a>
      </li>
      <?php foreach ($categories as $category => $category_info) { ?>
          <li>
          <a id="cat_<?php print $category; ?>" href="#">
            <span <?php echo $color_css; ?>><?php echo $all_cat_image; ?></span>
            <span class="category-title"><?php print $category_info['category_title']; ?></span>
          </a>
        </li>
      <?php } ?>
    </ul>
  </div>
</div>
<!-- / category filters -->