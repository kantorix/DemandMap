<?php defined('SYSPATH') or die('No direct script access.'); ?>
 
<h1>Resources</h1>
<?php echo HTML::anchor("resources", "View all Resources"); ?>
<br />
<?php echo HTML::anchor("members/resources/submit", "New Resource"); ?>
<br />
<?php foreach ($resources as $material) : ?>
<br />
<div style="background-color: #dddddd; margin: 0px 2px 0px 2px">
    <h2><?php echo HTML::anchor("members/resources/view/".$material->id, $material->title); ?></h2>
    <p><?php echo $material->category->category_title; ?></p>
    <?php echo HTML::anchor("members/resources/edit/".$material->id, "Edit"); ?>
    <?php echo HTML::anchor("members/resources/delete/".$material->id, "Delete"); ?>
</div>
<br />
<?php endforeach; ?>