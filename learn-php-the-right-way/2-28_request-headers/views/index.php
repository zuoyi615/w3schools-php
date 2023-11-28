<span>
  <?=
    /** @var string $foo */
    $foo
  ?>
</span>
<span>
  <?=
    /** @var string $name */
    $name
  ?>
</span>
<span>
  <?=
    /** @var int $age */
    $age
  ?>
</span>
<form method="post" action="/upload" enctype="multipart/form-data">
  <div>
    <div>
      <label>
        <span>上传头像</span>
        <input id="avatar" type="file" name="avatar" accept="image/*" />
      </label>
      <input type="submit" />
    </div>
  </div>
</form>
