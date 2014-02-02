<h1>Upload new resource</h1>
<?php echo Form::open('resources/post/' . $material->id); ?>
<?php echo Form::label("title", "Title"); ?>
<br>
<?php echo Form::input("title", $material->title); ?>
<br>
<br>
<?php echo Form::label("topic", "Categories"); ?>
<br>
<table>
  <?php foreach ($topics as $topic) : ?>
    <tr>
      <td>
        <?php echo Form::checkbox("topics[]", $topic->id,
          (in_array($topic->id, $referencearray) ? TRUE : FALSE)//checks whether topicreferences to this material exist, so topics will then be checked
        ); ?>
      </td>
      <td>
        <?php echo $topic->title; ?></td>
    </tr>
  <?php endforeach; ?>
</table>
<br>
<br>
<?php echo Form::label("content", "Description"); ?>
<br>
<?php echo Form::textarea("content", $material->content); ?>
<br>
<br>
<?php echo Form::submit("submit", "Submit"); ?>
<?php echo Form::close(); ?>