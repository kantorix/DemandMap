<div class="resource-detail" id="resource-detail">
  <h1>Resource: <?php echo $material->title; ?> </h1>
  <?php if (!empty($category->category_title)) : ?>
    <h2 class="material-category">Category: <?php print $category->category_title; ?></h2>
  <?php endif; ?>
  <?php if (!empty($material->link)) : ?>
  <div class="resource-link">Link to resource: <a href="<?php echo $material->link; ?>" target="_blank"><?php echo $material->link; ?></a></div>
  <?php endif; ?>
  <div class="resource-description"><?php echo nl2br($material->content); ?></div>

  <div class="comment-block report-comments" id="resource-comments">
    <h2>Comments</h2>
    <?php if ($material->talks->count() > 0) : ?>
      <?php foreach ($material->talks as $talk) : ?>
        <div class="report-comment-box">
          <div class="comment-metadata">
            <?php echo date('M j Y', strtotime($talk->create_date)); ?>
            <?php
            if (!empty($talk->nickname)) {
              print ' written by ' . $talk->nickname;
            }
            ?>
          </div>
          <div class="comment-description"><?php echo nl2br(html::escape($talk->description)); ?></div>
        </div>
      <?php endforeach; ?>
    <?php else : ?>
      <p><strong>No comments. Be the first to add a comment.</strong></p>
    <?php endif; ?>
  </div>

  <h2>Write a new comment:</h2>
  <?php if ($form_error): ?>
    <!-- red-box -->
    <div class="red-box">
      <h3>Error!</h3>
      <ul>
        <?php
        foreach ($errors as $error_item => $error_description) {
          switch ($error_description) {
            case 'talk.nickname.required':
              $error_description = 'Your nickname is required.';
              break;
            case 'talk.email.required':
              $error_description = 'Your email is required.';
              break;
            case 'talk.description.required':
              $error_description = 'The description is required.';
              break;
          }
          print (!$error_description) ? '' : "<li>" . $error_description . "</li>";
        }
        ?>
      </ul>
    </div>
  <?php endif; ?>
  <div id="commentForm">
    <?php echo Form::open('resources/view/' . $material->id); ?>
    <?php echo Form::label("nickname", "Nickname"); ?>
    <?php echo Form::input("nickname", $form['nickname'], ' class="text"'); ?>
    <br/>
    <br/>
    <?php echo Form::label("email", "Email"); ?>
    <?php echo Form::input("email", $form['email'], ' class="text"'); ?>
    <br/>
    <br/>
    <?php echo Form::label("description", "Comment *"); ?>
    <?php echo Form::textarea("description", $form['description'], ' class="textarea"'); ?>
    <br/>
    <?php echo Form::submit("submit", "Submit Comment", ' class="btn_submit"'); ?>
    <?php echo Form::close(); ?>
    <br/>
  </div>
</div>