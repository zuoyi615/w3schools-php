<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ajax database</title>
    <style>
    #hint {
      margin-top: 8px;
    }

    table {
      width: 100%;
      padding: 24px;
      border-collapse: collapse;
      border: solid 1px lightgray;
      text-align: left;
      border-radius: 4px;
    }

    td, th {
      padding: 4px 12px;
      text-align: left;
    }

    td {
      width: 150px;
    }
    </style>
  </head>
  <body>
    <form>
      <select name="users" onchange="showUser(this.value)">
        <option value="">Select a person:</option>
        <option value="1">Peter Griffin</option>
        <option value="2">Lois Griffin</option>
        <option value="3">Joseph Swanson</option>
        <option value="4">Glenn Quagmire</option>
      </select>
    </form>

    <div id="hint">Person info will be listed here...</div>
    <script>
    async function showUser(id) {
      const hint = document.querySelector('#hint')
      if (id === '') return hint.innerHTML = 'Person info will be listed here...'

      try {
        const url = `03-user.php?id=${id}`
        const res = await fetch(url)
        hint.innerHTML = await res.text()
      } catch (e) {
        hint.innerHTML = e.message
      }
    }
    </script>
  </body>
</html>
