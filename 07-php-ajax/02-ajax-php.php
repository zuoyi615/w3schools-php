<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ajax php</title>
  </head>
  <body>
    <h3>Start typing a name in the input field below:</h3>
    <form action="">
      <label for="firstname">First Name:</label>
      <input type="text" id="firstname" name="firstname" onkeyup="showHint(this.value)">
    </form>
    <p>Suggestions: <span id="hint"></span></p>
    <script>
    async function showHint(q) {
      const hint = document.querySelector('#hint')
      if (q.length == 0) return hint.innerHTML = ''

      try {
        const url = `02-hint.php?q=${q}`
        const res = await fetch(url)
        const data = await res.text()
        hint.innerHTML = data
      } catch (e) {
        hint.innerHTML = e.message
      }
    }
    </script>
  </body>
</html>
