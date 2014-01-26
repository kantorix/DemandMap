<!-- category filters -->
<div id="region-category-filter" class="clearfix">
  <div id="region-category-filter-inner">
    <h3>Filter</h3>
    <h4>Categories</h4>
    <div id="category_switch" class="category-filters">
      <?php
      foreach ($categories as $type => $type_info) {
        if (isset($type_info['children'])) {
          ?>
          <div id="category_swich_cat_<?php print $type; ?>" class="category_swich_cat">
          <h5><?php print $type_info['category_title']; ?></h5>
          <ul>
            <?php foreach ($type_info['children'] as $category => $category_info) { ?>
              <li>
                <a id="cat_<?php print $category; ?>" href="#">
                  <span style="color:#<?php echo $category_info['category_color']; ?>;">■</span>
                  <span class="category-title"><?php print $category_info['category_title']; ?></span>
                </a>
              </li>
            <?php
            }
            ?>
          </ul>
        <?php
        }
        ?>
        </div>
      <?php } ?>
    </div>
  </div>
  <a href="#" id="region-category-filter-plus"><img src="/themes/demandmap/images/icon-map-plus.png" alt="" title="Show filters"></a>
  <a href="#" id="region-category-filter-minus"><img src="/themes/demandmap/images/icon-map-minus.png" alt="" title="Hide filters"></a>
</div>
<!-- / category filters -->