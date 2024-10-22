<?php declare(strict_types=1) ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Form Validation</title>
    <style>
    .form div {
      margin-bottom: 4px;
    }

    .error {
      color: red;
    }
    </style>
  </head>
  <body>
    <?php
      $nameErr = $emailErr = $commentErr = $websiteErr = $genderErr = '';
      $name = $email = $comment = $website = $gender = '';
      $method = $_SERVER['REQUEST_METHOD'];

      if ($method == 'POST') {
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $gender = htmlspecialchars($_POST['gender'] ?? 'other');
        $comment = htmlspecialchars($_POST['comment']);
        $website = htmlspecialchars($_POST['website']);
        if (empty($name)) $nameErr = 'Name is required.';
        else $name = refine_input($name);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) $nameErr = 'Only letters and space allowed.';

        if (empty($email)) $emailErr = 'Email is required.';
        else $email = refine_input($email);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $emailErr = 'Invalid email format.';

        if (empty($gender)) $genderErr = 'Gender is required.';
        else $gender = refine_input($gender);

        if (empty($comment)) $comment = '';
        else $comment = refine_input($comment);

        if (empty($website)) $website = '';
        else $website = refine_input($website);
        if (!filter_var($website, FILTER_VALIDATE_URL)) $websiteErr = 'Invalid URL';
      }

      function refine_input($data): string {
        $data = trim($data);
        $data = stripslashes($data);
        return htmlspecialchars($data);
      }
    ?>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" class="form">
      <div>
        <sup class="error">*</sup>Name:
        <input type="text" name="name" value="<?php echo $name ?>">
        <?php echo $nameErr ? "<span class='error'>$nameErr</span>" : '' ?>
      </div>
      <div>
        <sup class="error">*</sup>E-mail:
        <input type="text" name="email" value="<?php echo $email ?>">
        <?php echo $emailErr ? "<span class='error'>$emailErr</span>" : '' ?>
      </div>
      <div>
        Website: <input type="text" name="website" value="<?php echo $website ?>">
        <?php echo $websiteErr ? "<span class='error'>$websiteErr </span>" : '' ?>
      </div>
      <div>
        Comment:
        <textarea name="comment" rows="5" cols="40" style="resize: none;"><?php echo $comment ?></textarea>
      </div>
      <div>
        <sup class="error">*</sup>Gender:
        <input type="radio" name="gender" value="female" <?php echo $gender == 'female' ? 'checked' : '' ?>>Female
        <input type="radio" name="gender" value="male" <?php echo $gender == 'male' ? 'checked' : '' ?>>Male
        <input type="radio" name="gender" value="other" <?php echo $gender == 'other' ? 'checked' : '' ?>>Other
        <?php echo $genderErr ? "<span class='error'>$genderErr</span>" : '' ?>
      </div>
      <input type="submit">
    </form>
  </body>
</html>
