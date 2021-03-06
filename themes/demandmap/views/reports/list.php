<?php
/**
 * View file for updating the reports display
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team - http://www.ushahidi.com
 * @package    Ushahidi - http://source.ushahididev.com
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */
?>
<!-- Report listing -->
<div class="r_cat_tooltip"><a href="#" class="r-3"></a></div>
<div class="rb_list-and-map-box">
  <div id="rb_list-view">
    <?php if ($incidents->count() == 0) { ?>
      <div class="no-matchings"><p>No matching results found</p></div>
    <?php } else { ?>
    <?php
    foreach ($incidents as $incident) {
      $incident_id = $incident->incident_id;
      $incident_title = $incident->incident_title;
      $incident_description = $incident->incident_description;
      $incident_url = Incident_Model::get_url($incident_id);
      //$incident_category = $incident->incident_category;
      // Trim to 150 characters without cutting words
      // XXX: Perhaps delcare 150 as constant

      $incident_description = text::limit_chars(html::strip_tags($incident_description), 110, "...", TRUE);
      $incident_date = date('H:i M d, Y', strtotime($incident->incident_date));
      //$incident_time = date('H:i', strtotime($incident->incident_date));
      $location_id = $incident->location_id;
      $location_name = $incident->location_name;
      $incident_verified = $incident->incident_verified;

      $comment_count = ORM::Factory('comment')
        ->where('incident_id', $incident_id)->count_all();

      $incident_thumb = url::file_loc('img') . "media/img/report-thumb-default.jpg";
      $media = ORM::Factory('media')->where('incident_id', $incident_id)
        ->find_all();
      if ($media->count()) {
        foreach ($media as $photo) {
          if ($photo->media_thumb) { // Get the first thumb
            $incident_thumb = url::convert_uploaded_to_abs($photo->media_thumb);
            break;
          }
        }
      }
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
      <div id="incident_<?php echo $incident_id ?>" class="rb_report <?php echo $incident_verified_class; ?>">
        <h3><a class="r_title" href="<?php echo $incident_url; ?>">
            <?php echo html::escape($incident_title); ?>
          </a>
        </h3>

        <p class="r_date r-3 bottom-cap"><?php echo $incident_date; ?></p>

        <div class="r_description"> <?php echo $incident_description; ?>
          <a class="btn-show btn-more" href="<?php echo url::site("reports/view/$incident_id"); ?>">&raquo;
            more</a>
        </div>
        <p class="r_location">
          <a href="<?php echo url::site("reports/?l=$location_id"); ?>"><?php echo html::specialchars($location_name); ?></a>
        </p>
        <?php
        // Action::report_extra_details - Add items to the report list details section
        Event::run('ushahidi_action.report_extra_details', $incident_id);
        ?>
        <span class="report-submissiontype"><?php print $submissionTypeIcon; ?></span>
      </div>
    <?php } ?>
    <?php } ?>
  </div>
</div>
<!-- /Report listing -->
<!-- Bottom paginator -->
<div class="rb_nav-controls">
  <?php echo $pagination; ?>
</div>
<!-- /Bottom paginator -->