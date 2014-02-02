<div class="region-content">
  <div class="wrapper-inner">
    <div class="content-padding">
      <h1>Resource: <?php echo $material->title; ?> </h1>
      <br/>
      <h2>Categories</h2>
      <?php foreach ($material->topics as $reference) : ?>
        <?php echo $reference->title; ?></br>
      <?php endforeach; ?>
      <br/>

      <h2>Description</h2>
      <?php echo $material->content; ?>
      <br/>
      <br/>

      <h2>Files</h2>
      <?php foreach ($material->files as $file) : ?>
        </br>
        <?php
        $full_path = url::convert_uploaded_to_abs($file->filename);
        echo '<a href="' . $full_path . '" target="_blank" >' . $file->filetitle . '</a><br>';?>
        <br/>
      <?php endforeach; ?>
      <br/>
      <br/>

      <h3>Comment this:</h3>
      <?php echo Form::open('resources/view/' . $material->id); ?>
      <br/>
      <?php echo Form::label("nickname", "Nickname"); ?>
      <?php echo Form::input("nickname", ""); ?>
      <br/>
      <br/>
      <?php echo Form::label("email", "Email"); ?>
      <?php echo Form::input("email", ""); ?>
      <br/>
      <br/>
      <?php echo Form::label("comment", "Comment"); ?>
      <br/>
      <?php echo Form::textarea("comment", ""); ?>
      <br/>
      <?php echo Form::submit("submit", "Submit Comment"); ?>
      <?php echo Form::close(); ?>
      <br/>

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
    </div>
  </div>
</div>