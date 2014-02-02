<div class="resource-submit" id="resource-submit">
  <h1>Upload new resource</h1>

  <div id="commentForm">
    <?php echo Form::open('resources/post/' . $material->id); ?>
    <?php echo Form::label("title", "Title"); ?>
    <?php echo Form::input("title", $material->title, ' class="text"'); ?>
    <br>
    <br>
    <?php echo Form::label("topic", "Categories"); ?>
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
    <?php echo Form::textarea("content", $material->content, ' class="textarea"'); ?>
    <br>
    <br>
    <?php echo Form::submit("submit", "Submit", ' class="btn_submit"'); ?>
    <?php echo Form::close(); ?>
  </div>
</div>