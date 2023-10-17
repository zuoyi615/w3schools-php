<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>file uploads</title>
    <style>
    .image {
      display: inline-block;
      margin-bottom: 4px;
      width: 120px;
      height: 120px;
      border-radius: 8px;
      cursor: pointer;
      line-height: 120px;
      text-align: center;
      font-size: 12px;
      background: aliceblue;
    }
    .form {
      margin: 60px auto;
      width: 600px;
    }
    </style>
  </head>
  <body>
    <form action="upload.php" method="post" enctype="multipart/form-data" class="form">
      <label for="file" class="image">
        Upload
        <input type="file" name="file" id="file" hidden />
      </label>
      <div><input type="submit" /></div>
    </form>
  </body>
</html>
