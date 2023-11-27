<!--<h1>--><?php
  //= $this->params['foo'] ?><!--</h1>-->
<h1><?= $this->foo ?></h1>
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
