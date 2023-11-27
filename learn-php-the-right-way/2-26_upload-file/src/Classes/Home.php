<?php

  declare(strict_types=1);

  namespace UploadFile\Classes;

  class Home {
    public function index(): string {
      return (
      <<<Form
          <form method="post" action="/upload" enctype="multipart/form-data">
            <div>
              <div>
                <label>
                  <span>单文件</span>
                  <input id="receipt" type="file" name="receipt" />
                </label>
              </div>
              <br />
              <div>
                <labe>
                  <span>单图片</span>
                  <input id="avatar" type="file" name="avatar" accept="image/*" />
                </label>
              </div>
              <br />
              <div>
                <label>
                  <span>图片列表</span>
                  <input type="file" name="avatar1[]" accept="image/*" />
                  <input type="file" name="avatar1[]" accept="image/*" />
                </label>
              </div>
              <br />
              <input type="submit" />
            </div>
          </form>
        Form
      );
    }

    public function upload(): void {
      // var_dump($_FILES);
      $receipt = $_FILES['receipt'];
      if (!isset($receipt)) {
        echo 'No File: receipt';
        return;
      }

      $avatar = $_FILES['avatar'];
      if (!isset($avatar)) {
        echo 'No File: avatar';
        return;
      }

      // var_dump(pathinfo($tmp));
      // var_dump(pathinfo($target));
      move_uploaded_file($receipt['tmp_name'], UPLOAD_PATH.DIRECTORY_SEPARATOR.$receipt['name']);
      move_uploaded_file($avatar['tmp_name'], UPLOAD_PATH.DIRECTORY_SEPARATOR.$avatar['name']);
      echo 'Uploaded Successfully';
    }
  }
