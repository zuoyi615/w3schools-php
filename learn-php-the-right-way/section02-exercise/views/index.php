<!doctype html>
<html lang="en" class="dark">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Transactions</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
      darkMode: 'class',
    }
    </script>
  </head>
  <body class="dark:bg-gray-900 p-4">
    <div class="container mx-auto">
      <h1 class="text-white">Upload Transactions</h1>
      <form method="post" action="/upload" class="mt-10" enctype="multipart/form-data">
        <div class="text-white space-x-2 mb-2">
          <label class="cursor-pointer">
            <span>Click to choose a Transaction file (.csv)</span>
            <input type="file" name="file" hidden required />
          </label>
        </div>
        <input
          type="submit"
          class="rounded border py-2 px-3 border-blue-200 cursor-pointer text-xs bg-blue-300 hover:bg-blue-500 hover:border-blue-500 hover:text-slate-200"
          value="Upload"
        />
      </form>
    </div>
  </body>
</html>
