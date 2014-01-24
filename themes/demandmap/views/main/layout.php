<!-- category filters -->
<div id="region-filter" class="clearfix">
  <div class="wrapper-inner">
    <ul id="category_switch" class="category-filters">
      <?php
      $color_css = 'class="category-icon swatch" style="background-color:#' . $default_map_all . '"';
      $all_cat_image = '';
      if ($default_map_all_icon != NULL) {
        $all_cat_image = html::image(array(
          'src' => $default_map_all_icon
        ));
        $color_css = 'class="category-icon"';
      }
      ?>
      <li>
        <a class="active" id="cat_0" href="#">
          <span <?php echo $color_css; ?>><?php echo $all_cat_image; ?></span>
          <span class="category-title"><?php echo Kohana::lang('ui_main.all_categories'); ?></span>
        </a>
      </li>
      <?php
      foreach ($categories as $category => $category_info) {
        $category_title = html::escape($category_info[0]);
        $category_color = $category_info[1];
        $category_image = ($category_info[2] != NULL)
          ? url::convert_uploaded_to_abs($category_info[2])
          : NULL;
        $category_description = html::escape(Category_Lang_Model::category_description($category));

        $color_css = 'class="category-icon swatch" style="background-color:#' . $category_color . '"';
        if ($category_info[2] != NULL) {
          $category_image = html::image(array(
            'src' => $category_image,
          ));
          $color_css = 'class="category-icon"';
        }

        echo '<li>'
          . '<a href="#" id="cat_' . $category . '" title="' . $category_description . '">'
          . '<span ' . $color_css . '>' . $category_image . '</span>'
          . '<span class="category-title">' . $category_title . '</span>'
          . '</a>';

        // Get Children
        echo '<div class="hide" id="child_' . $category . '">';
        if (sizeof($category_info[3]) != 0) {
          echo '<ul>';
          foreach ($category_info[3] as $child => $child_info) {
            $child_title = html::escape($child_info[0]);
            $child_color = $child_info[1];
            $child_image = ($child_info[2] != NULL)
              ? url::convert_uploaded_to_abs($child_info[2])
              : NULL;
            $child_description = html::escape(Category_Lang_Model::category_description($child));

            $color_css = 'class="category-icon swatch" style="background-color:#' . $child_color . '"';
            if ($child_info[2] != NULL) {
              $child_image = html::image(array(
                'src' => $child_image
              ));

              $color_css = 'class="category-icon"';
            }

            echo '<li>'
              . '<a href="#" id="cat_' . $child . '" title="' . $child_description . '">'
              . '<span ' . $color_css . '>' . $child_image . '</span>'
              . '<span class="category-title">' . $child_title . '</span>'
              . '</a>'
              . '</li>';
          }
          echo '</ul>';
        }
        echo '</div></li>';
      }
      ?>
    </ul>
  </div>
</div>
<!-- / category filters -->

<?php
$pageController = new Page_Controller();
$pageController->index(5);
print $pageController->template->content;
?>
<div class="region-content">
  <div class="wrapper-inner">
    <div class="content-padding">
      <div id="frontpage-buttons" class="clearfix">
        <div class="frontpage-button frontpage-button-about">
          <div class="frontpage-buttons-inner">
            <a href="<?php print url::site('page/index/2'); ?>"><img src="/themes/demandmap/images/button-about.png" alt=""></a>
            <h3><a href="<?php print url::site('page/index/2'); ?>">About</a></h3>
            <p>Donec dignissim nibh sed velit rhoncus, sit amet aliquet nisl
              tincidunt. Aliquam adipiscing urna vel dolor porttitor, quis
              vulputate risus sagittis.</p>
          </div>
        </div>
        <div class="frontpage-button frontpage-button-submit">
          <div class="frontpage-buttons-inner">
            <a href="<?php print url::site('reports/submit'); ?>"><img src="/themes/demandmap/images/button-submit.png" alt=""></a>
            <h3><a href="<?php print url::site('reports/submit'); ?>">Submit</a></h3>
            <p>Donec dignissim nibh sed velit rhoncus, sit amet aliquet nisl
              tincidunt. Aliquam adipiscing urna vel dolor porttitor, quis
              vulputate risus sagittis.</p>
          </div>
        </div>
        <div class="frontpage-button frontpage-button-resources">
          <div class="frontpage-buttons-inner">
            <a href="#"><img src="/themes/demandmap/images/button-resources.png" alt=""></a>
            <h3><a href="#">Resources</a></h3>
            <p>Donec dignissim nibh sed velit rhoncus, sit amet aliquet nisl
              tincidunt. Aliquam adipiscing urna vel dolor porttitor, quis
              vulputate risus sagittis.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- content -->
<div class="region-content">
  <div class="wrapper-inner">
    <div class="content-padding">
      <!-- content blocks -->
      <div class="content-blocks clearingfix">
        <ul class="content-column">
          <?php blocks::render(); ?>
        </ul>
      </div>
      <!-- /content blocks -->
    </div>
  </div>
</div>
<!-- content -->