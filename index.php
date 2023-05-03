<?php

session_start();

$dbname = 'sql_injection';
$dbuser = 'postgres';
$dbpass = 'root';
$dbhost = 'localhost';
$dbport = '5432';
$db = pg_connect("host=$dbhost port=$dbport dbname=$dbname user=$dbuser password=$dbpass");


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
  $username = $_POST['username'];
  $password = $_POST['password'];

  /* Retrieve user from database */
  $query = "SELECT * FROM client WHERE name = '$username' AND password = '$password'";
  $result = pg_query($db, $query);
  $row = pg_fetch_assoc($result);

  /* Check if user exists and password is correct */
  if (pg_num_rows($result) == 1) {

    $_SESSION['user_id'] = $row['id'];
    $_SESSION['username'] = $row['username'];
    header('Location: authorized.php');
    exit;
  } else {
  
    echo 'Invalid username or password.';
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Authorization Page</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <h1 class="text-center my-5">Authorization Page</h1>
    <div class="row justify-content-center">
      <div class="col-sm-6">
        <form method="post" class="p-4 border rounded">
          <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" name="username" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="password">Password:</label>
            <input type="text" name="password" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <?php
        if (isset($_SESSION['login_error'])) {
          echo '<div class="alert alert-danger mt-3" role="alert">';
          echo $_SESSION['login_error'];
          echo '</div>';
          unset($_SESSION['login_error']);
        }
        ?>
      </div>
    </div>
  </div>
</body>
</html>
