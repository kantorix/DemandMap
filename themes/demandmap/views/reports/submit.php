<div class="frontpage-content-columns clearfix">
  <div class="frontpage-content-left">
    <div class="report-submit">
      <?php if ($site_submit_report_message != ''): ?>
        <div class="green-box">
          <h3><?php echo $site_submit_report_message; ?></h3>
        </div>
      <?php endif; ?>

      <h1><?php echo Kohana::lang('ui_main.reports_submit_new'); ?></h1>

      <!-- start report form block -->
      <?php print form::open(NULL, array(
        'enctype' => 'multipart/form-data',
        'id' => 'reportForm',
        'name' => 'reportForm',
        'class' => 'gen_forms'
      )); ?>
      <input type="hidden" name="latitude" id="latitude" value="<?php echo $form['latitude']; ?>">
      <input type="hidden" name="longitude" id="longitude" value="<?php echo $form['longitude']; ?>">
      <input type="hidden" name="country_name" id="country_name" value="<?php echo $form['country_name']; ?>"/>
      <input type="hidden" name="incident_zoom" id="incident_zoom" value="<?php echo $form['incident_zoom']; ?>"/>

      <div class="big-block">
        <?php if ($form_error): ?>
          <!-- red-box -->
          <div class="red-box">
            <h3>Error!</h3>
            <ul>
              <?php
              foreach ($errors as $error_item => $error_description) {
                print (!$error_description) ? '' : "<li>" . $error_description . "</li>";
              }
              ?>
            </ul>
          </div>
        <?php endif; ?>
        <div class="row">
          <input type="hidden" name="form_id" id="form_id" value="<?php echo $id ?>">
        </div>
        <div class="report_left">
          <div class="report_row">
            <?php if (count($forms) > 1): ?>
              <div class="row">
                <h4>
                  <span><?php echo Kohana::lang('ui_main.select_form_type'); ?></span>
						<span class="sel-holder">
							<?php print form::dropdown('form_id', $forms, $form['form_id'],
                ' onchange="formSwitch(this.options[this.selectedIndex].value, \'' . $id . '\')"') ?>
						</span>

                  <div id="form_loader"></div>
                </h4>
              </div>
            <?php endif; ?>
            <label for="incident_title"><?php echo Kohana::lang('ui_main.reports_title'); ?>
              <span class="required">*</span></label>
            <?php print form::input('incident_title', $form['incident_title'], ' class="text long"'); ?>
          </div>
          <div class="report_row">
            <label for="incident_description"><?php echo Kohana::lang('ui_main.reports_description'); ?>
              <span class="required">*</span></label>
            <?php print form::textarea('incident_description', $form['incident_description'], ' rows="10" class="textarea long" ') ?>
          </div>
          <div class="report_row hide" id="datetime_edit">
            <div class="date-box">
              <label for="incident_date"><?php echo Kohana::lang('ui_main.reports_date'); ?></label>
              <?php print form::input('incident_date', $form['incident_date'], ' class="text short"'); ?>
              <script type="text/javascript">
                $().ready(function () {
                  $("#incident_date").datepicker({
                    showOn: "both",
                    buttonImage: "<?php echo url::file_loc('img'); ?>media/img/icon-calendar.gif",
                    buttonImageOnly: true
                  });
                });
              </script>
            </div>
            <div class="time">
              <label for="incident_hour"><?php echo Kohana::lang('ui_main.reports_time'); ?></label>
              <?php
              for ($i = 1; $i <= 12; $i++) {
                // Add Leading Zero
                $hour_array[sprintf("%02d", $i)] = sprintf("%02d", $i);
              }
              for ($j = 0; $j <= 59; $j++) {
                // Add Leading Zero
                $minute_array[sprintf("%02d", $j)] = sprintf("%02d", $j);
              }
              $ampm_array = array('pm' => 'pm', 'am' => 'am');
              print form::dropdown('incident_hour', $hour_array, $form['incident_hour']);
              print '<span class="dots">:</span>';
              print form::dropdown('incident_minute', $minute_array, $form['incident_minute']);
              print '<span class="dots">:</span>';
              print form::dropdown('incident_ampm', $ampm_array, $form['incident_ampm']);
              ?>
              <?php if ($site_timezone != NULL): ?>
                <small>(<?php echo $site_timezone; ?>)</small>
              <?php endif; ?>
            </div>
            <div style="clear:both; display:block;" id="incident_date_time"></div>
          </div>
          <div class="report_row">
            <!-- Adding event for endtime plugin to hook into -->
            <?php Event::run('ushahidi_action.report_form_frontend_after_time'); ?>
          </div>
          <div class="report_row">
            <label for="incident_category"><?php echo Kohana::lang('ui_main.reports_categories'); ?>
              <span class="required">*</span></label>

            <div class="report_category" id="categories">
              <?php
              $selected_categories = (!empty($form['incident_category']) AND is_array($form['incident_category']))
                ? $selected_categories = $form['incident_category']
                : array();


              echo category::form_tree('incident_category', $selected_categories, 2);
              ?>
            </div>
          </div>


          <?php
          // Action::report_form - Runs right after the report categories
          Event::run('ushahidi_action.report_form');
          ?>

          <?php echo $custom_forms ?>

          <?php
          // Action::report_form_optional - Runs in the optional information of the report form
          Event::run('ushahidi_action.report_form_optional');
          ?>
        </div>
      </div>
      <div class="report_right">
        <?php if (count($cities) > 1): ?>
          <div class="report_row">
            <h4><?php echo Kohana::lang('ui_main.reports_find_location'); ?></h4>
            <?php print form::dropdown('select_city', $cities, '', ' class="select" '); ?>
          </div>
        <?php endif; ?>
        <label for="submitMap">Location <span class="required">*</span></label>
        <span class="example">You can drag the marker to your desired position.</span>
        <div class="report_row">
          <div id="submitMap" class="report_map"></div>
        </div>
        <?php Event::run('ushahidi_action.report_form_location', $id); ?>
        <div class="report_row">
          <h4>
            <label for="location_name"><?php echo Kohana::lang('ui_main.reports_location_name'); ?>
              <span class="required">*</span></label>
            <span class="example">Example: Kololo Road, Juba</span>
          </h4>
          <?php print form::input('location_name', $form['location_name'], ' class="text long"'); ?>
        </div>

        <div class="report_row">
          <input name="submit" type="submit" value="<?php echo Kohana::lang('ui_main.reports_btn_submit'); ?>" class="btn_submit"/>
        </div>
      </div>
    </div>
    <?php print form::close(); ?>
    <!-- end report form block -->
  </div>
  <div class="frontpage-content-right">
    <?php
    $pageController = new Page_Controller();
    $pageController->index(7);
    print $pageController->template->content;
    ?>
  </div>
</div>