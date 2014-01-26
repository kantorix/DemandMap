<?php blocks::open("reports");?>
<?php blocks::title(Kohana::lang('ui_main.recent_reports'));?>
<?php
$pageController = new Page_Controller();
print $pageController->index(1);
?>
<ul class="block-report-list">
		<?php
    $i = 0;
		foreach ($incidents as $incident)
		{
      $i++;
			$incident_id = $incident->id;
			$incident_title = text::limit_chars(html::strip_tags($incident->incident_title), 40, '...', True);
			$incident_date = $incident->incident_date;
			$incident_date = date('Y-m-d', strtotime($incident->incident_date));
			$incident_location = $incident->location->location_name;
		?>
    <li><span class="incident-identificator">#<?php print $incident_id; ?></span> <span class="incident-separator">–</span> <a href="<?php echo url::site() . 'reports/view/' . $incident_id; ?>"> <?php echo $incident_title ?></a></li>
		<?php
		}
		?>
</ul>

<?php blocks::close();?>