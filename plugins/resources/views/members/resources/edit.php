<?php defined('SYSPATH') or die('No direct script access.'); ?>
 
<h1>Upload new resource:</h1>
<?php if ($form_error): ?>
			<!-- red-box -->
			<div class="red-box">
				<h3>Error!</h3>
				<ul>
					<?php
						foreach ($errors as $error_item => $error_description)
						{
							print (!$error_description) ? '' : "<li>" . $error_description . "</li>";
						}
					?>
				</ul>
			</div>
<?php endif; ?> 
<?php echo Form::open('members/resources/post/'.$material->id); ?>
    <?php echo Form::label("title", "Title"); ?>
    <br />
    <?php echo Form::input("title", $form['title']); ?>
    <br />
    <br />
	<?php echo Form::label("category", "Category"); ?>
	<br />
	<?php echo Form::dropdown("category_id", $categories_list, $form['category_id']); ?>
	<!--<table>
		<?php /*foreach ($topics as $topic) : ?>
			<tr>
			<td>
				<?php echo Form::checkbox("topics[]", $topic->id, 
				(in_array($topic->id, $referencearray) ? TRUE : FALSE)//checks whether topicreferences to this material exist, so topics will then be checked
				); ?>
			</td>
			<td>
				<?php echo $topic->title; ?></td>
			</tr>
		<?php endforeach; */?>
	</table>-->
	<br />
    <br />
		<?php echo Form::label("content", "Description"); ?>
    <br />
		<?php echo Form::textarea("content", $form['content']); ?>
	<br />
    <br />
		<?php echo Form::label("link", "Link to Resource"); ?>
    <br />
		<?php echo Form::textarea("link", $form['link']); ?>
	<br />
		<?php echo Form::submit("submit", "Submit"); ?>
<?php echo Form::close(); ?>