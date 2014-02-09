<?php
$incident = ORM::factory('incident')
  ->where('id', $incident_id)
  ->where('incident_active',1)
  ->find();
switch ($incident->incident_mode) {
  case 2:
    $submissionTypeIcon = '<img src="/themes/demandmap/images/icon-mobile.png" alt="">';
    break;
  case 1:
  default:
    $submissionTypeIcon = '<img src="/themes/demandmap/images/icon-desktop.png" alt="">';
    break;
}
?>
<div class="report-detail">

  <div class="left-col">

    <div class="report-detail-mode"><?php print $submissionTypeIcon; ?></div>
    <h1 class="report-title"><?php
      echo html::escape($incident_title);

      // If Admin is Logged In - Allow For Edit Link
      if ($logged_in) {
        echo ' <span class="edit-link">[&nbsp;<a href="' . url::site() . 'admin/reports/edit/' . $incident_id . '">'
          . Kohana::lang('ui_main.edit') . '</a>&nbsp;]</span>';
      }
      ?></h1>

    <?php if (!empty($incident_date)) : ?>
      <div class="report-date">submitted on <?php print $incident_date; ?> </div>
    <?php endif; ?>
    <div class="report-metadata">
      <?php if (!empty($incident_location)) : ?>
      <div class="report-location"><strong>Location:</strong> <?php echo html::specialchars($incident_location); ?></div>
      <?php endif; ?>
    </div>

    <?php if (!empty($incident_category)) : ?>
    <div class="report-category-list"><strong>Category:</strong>
        <?php
        $categories = array();
        foreach ($incident_category as $category) {
          // don't show hidden categoies
          if ($category->category->category_visible == 0) {
            continue;
          }
          $categories[$category->category_id] = ' <a href="' . url::site() . 'reports/?c=' . $category->category->id . '" title="' . Category_Lang_Model::category_description($category->category_id) . '">' . Category_Lang_Model::category_title($category->category_id) . '</a>';
        }
        print implode(', ', $categories);
        ?>
      <?php
      // Action::report_meta - Add Items to the Report Meta (Location/Date/Time etc.)
      Event::run('ushahidi_action.report_meta', $incident_id);
      ?>
    </div>
    <?php endif; ?>

    <?php
    // Action::report_display_media - Add content just above media section
    Event::run('ushahidi_action.report_display_media', $incident_id);
    ?>

    <!-- start report description -->
    <div class="report-description-text">
      <?php echo html::clean(nl2br($incident_description)); ?>
      <!-- start additional fields -->
      <?php if (strlen($custom_forms) > 0) { ?>
        <div class="credibility">
          <h5><?php echo Kohana::lang('ui_main.additional_data'); ?></h5>
          <?php echo $custom_forms; ?>
          <br/>
        </div>
      <?php } ?>
      <!-- end additional fields -->

      <?php if ($features_count) {
        ?>
        <br/><br/>
        <h5><?php echo Kohana::lang('ui_main.reports_features'); ?></h5>
        <?php
        foreach ($features as $feature) {
          echo ($feature->geometry_label) ?
            "<div class=\"feature_label\"><a href=\"javascript:getFeature($feature->id)\">$feature->geometry_label</a></div>" : "";
          echo ($feature->geometry_comment) ?
            "<div class=\"feature_comment\">$feature->geometry_comment</div>" : "";
        }
      }?>
    </div>

    <?php
    // Action::report_extra - Allows you to target an individual report right after the description
    Event::run('ushahidi_action.report_extra', $incident_id);

    // Filter::comments_block - The block that contains posted comments
    Event::run('ushahidi_filter.comment_block', $comments);
    echo $comments;
    ?>

    <?php
    // Filter::comments_form_block - The block that contains the comments form
    Event::run('ushahidi_filter.comment_form_block', $comments_form);
    echo $comments_form;
    ?>

  </div>
</div>