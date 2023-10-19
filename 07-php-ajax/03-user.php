<?php
  include './Rows.php';
  // $host = '192.168.1.18';
  $host = 'localhost';
  $user = 'root';
  $pass = '123456';
  $dbname = 'php_tutorial';

  if (!isset($_GET['id'])) {
    echo 'id is required.';
    return;
  }

  $id = $_GET['id'];
  $id = htmlspecialchars($id);
  if (filter_var($id, FILTER_VALIDATE_INT) === false) {
    echo "$id is not an integer.";
    return;
  }

  try {
    $con = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $con->prepare('SELECT * FROM guests WHERE id=:id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $results = $stmt->fetchAll();
    $len = count($results);
    if ($len === 0) {
      echo 'No Results';
      return;
    }

    $rows = new Rows(new RecursiveArrayIterator($results));
    echo '<table>';
    echo '<tr>
            <th>Id</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>email</th>
            <th>createdAt</th>
          </tr>';
    foreach ($rows as $field => $value) {
      echo $value;
    }
    echo "</table>";
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  } finally {
    $con = null;
  }
