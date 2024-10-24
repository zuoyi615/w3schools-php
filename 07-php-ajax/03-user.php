<?php
  include './Rows.php';

  $host = '127.0.0.1';
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
    $stmt->setFetchMode(PDO::FETCH_OBJ);
    $results = $stmt->fetchAll();
    $len = count($results);
    if ($len === 0) {
      echo 'No Results';
      return;
    }

    echo '<table>';
    echo <<<HEADER
          <tr>
             <th>Id</th>
             <th>Firstname</th>
             <th>Lastname</th>
             <th>email</th>
             <th>createdAt</th>
          </tr>
        HEADER;
    foreach ($results as $field => $value) {
      echo <<<Row
          <tr>
            <td>$value->id</td>
            <td>$value->firstname</td>
            <td>$value->lastname</td>
            <td>$value->email</td>
            <td>$value->created_at</td>
          </tr>
          Row;
    }
    echo "</table>";
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  } finally {
    $con = null;
  }
