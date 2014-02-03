<?php defined('SYSPATH') or die('No direct script access.'); ?>
 
<h1>Resource: <?php echo $material->title; ?> </h1>
<br />
<h2>Category</h2>
<?php echo $category->category_title; ?></br>
<?php /*foreach ($material->topics as $reference) : ?>
	<?php echo $reference->title; ?></br>
<?php endforeach; */?>
<br />
<h2>Description</h2>	
<?php echo $material->content; ?>
<br />
<br />
<h2>Link to Resource</h2>	
<a href='<?php echo $material->link; ?>'><?php echo $material->link; ?></a>
<br />
<br />
<!--<h2>Files</h2>-->
<?php /*foreach ($material->files as $file) : ?>
	</br>
	<?php 
	$full_path= url::convert_uploaded_to_abs($file->filename);
	echo '<a href="'.$full_path.'" target="_blank" >'.$file->filetitle.'</a><br>' ;?>	
	<br />
<?php endforeach; */?>
<br />
<br />
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
<h3>Comment this:</h3>
<?php echo Form::open('members/resources/view/'.$material->id); ?>
		<br />
		<?php echo Form::label("nickname", "Nickname"); ?>
		<?php echo Form::input("nickname", $form['nickname']); ?>
		<br />
		<br />
		<?php echo Form::label("email", "Email"); ?>
		<?php echo Form::input("email", $form['email']); ?>
		<br />
		<br />
		<?php echo Form::label("description", "Comment"); ?>
		<br />
		<?php echo Form::textarea("description", $form['description']); ?>
		<br />
		<?php echo Form::submit("submit", "Submit Comment"); ?>
<?php echo Form::close(); ?>
<br />
<h3>Comments</h3>
<?php foreach ($material->talks as $talk) : ?>
	</br>
	<h4>
		At <?php echo $talk->create_date; ?>
		<?php echo $talk->nickname; ?> wrote:
	</h4>	
	</br>
	<?php echo $talk->description; ?>
	</br>
<?php endforeach; ?>
