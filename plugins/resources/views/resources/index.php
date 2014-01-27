<?php defined('SYSPATH') or die('No direct script access.'); ?>
 
<h1>Resourceblog homepage</h1>
 
<?php echo HTML::anchor("resources/submit", "New Resource"); ?>
 
<?php foreach ($resources as $material) : ?>
<br />
<div style="background-color: #dddddd; margin: 0px 2px 0px 2px">
    <h2><?php echo HTML::anchor("resources/view/".$material->id, $material->title); ?></h2>
    <pre><?php echo $material->content; ?></pre>
    <?php echo HTML::anchor("resources/edit/".$material->id, "Edit"); ?>
    <?php echo HTML::anchor("resources/delete/".$material->id, "Delete"); ?>
	<?php echo HTML::anchor("resources/upload/".$material->id, "Upload"); ?>
</div>
<br />
<?php endforeach; ?>