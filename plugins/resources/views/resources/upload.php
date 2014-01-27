<html>
<head>
<title>File Upload Form</title>
</head>
<body>
This form allows you to upload a file to the server.<br>
<?php echo Form::open_multipart('resources/getfile/'.$material_id); ?>
Type (or select) Filename: <input type="file" name="uploadFile">
<input type="submit" value="Upload File">
<?php echo Form::close(); ?>
</body>
</html>