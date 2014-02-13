<div class="resource-submit" id="resource-submit">
  <h1>Upload new resource</h1>
  <?php if ($form_error): ?>
    <!-- red-box -->
    <div class="red-box">
      <h3>Error!</h3>
      <ul>
        <?php
        foreach ($errors as $error_item => $error_description) {
          switch ($error_description) {
            case 'resource.title.required':
              $error_description = 'The resource title is required.';
              break;
            case 'resource.content.required':
              $error_description = 'The content field is required.';
              break;
            case 'resource.nickname.required':
              $error_description = 'Your nickname is required.';
              break;
            case 'resource.email.required':
              $error_description = 'Please enter a valid email address.';
              break;
          }
          print (!$error_description) ? '' : "<li>" . $error_description . "</li>";
        }
        ?>
      </ul>
    </div>
  <?php endif; ?>
  <div id="commentForm">
    <?php echo Form::open('resources/post/' . $material->id); ?>
    <?php echo Form::label("nickname", 'Nickname <span class="required">*</span>'); ?>
    <?php echo Form::input("nickname", $form['nickname'], ' class="text"'); ?>
    <br>
    <br>
    <?php echo Form::label("email", 'Email <span class="required">*</span>'); ?>
    <?php echo Form::input("email", $form['email'], ' class="text"'); ?>
    <br>
    <br>
    <?php echo Form::label("title", 'Title <span class="required">*</span>'); ?>
    <?php echo Form::input("title", $form['title'], ' class="text"'); ?>
    <br>
    <br>
    <?php echo Form::label("link", 'Link to Resource <span class="required">*</span>'); ?>
    <?php echo Form::textarea("link", $form['link'], ' class="text"'); ?>
    <br>
    <br>
    <?php echo Form::label("content", "Description"); ?>
    <?php echo Form::textarea("content", $form['content'], ' class="textarea"'); ?>
    <br>
    <br>
    <?php echo Form::label("category", 'Category <span class="required">*</span>'); ?>
    <?php echo Form::dropdown("category_id", $categories_list, $form['category_id']); ?>
    <br>
    <br>
    <?php echo Form::submit("submit", "Submit", ' class="btn_submit"'); ?>
    <?php echo Form::close(); ?>
  </div>
</div>