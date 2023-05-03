<?php
// Start session
session_start();

// Check if user is authenticated
if (!isset($_SESSION['user_id'])) {
  // Redirect to login page
  header('Location: index.php');
  exit;
}

// Retrieve user information from database (assuming you have a 'users' table)
$dbname = 'sql_injection';
$dbuser = 'postgres';
$dbpass = 'root';
$dbhost = 'localhost';
$dbport = '5432';
$db = pg_connect("host=$dbhost port=$dbport dbname=$dbname user=$dbuser password=$dbpass");

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM client WHERE id = $user_id";
$result = pg_query($db, $query);
$user = pg_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Authorized Page</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
	<style>
		body {
			font-family: 'Roboto', sans-serif;
			margin: 0;
			padding: 0;
			background-color: #f8f8f8;
		}

		.container {
			max-width: 800px;
			margin: 0 auto;
			padding: 40px 20px;
			background-color: #fff;
			box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
			border-radius: 10px;
			text-align: center;
		}

		h1 {
			font-weight: 700;
			font-size: 36px;
			margin-bottom: 20px;
			color: #333;
		}

		p {
			font-weight: 400;
			font-size: 24px;
			margin-bottom: 40px;
			color: #666;
		}

		button {
			font-size: 18px;
			font-weight: 500;
			padding: 16px 32px;
			border: none;
			background-color: #007aff;
			color: #fff;
			border-radius: 5px;
			cursor: pointer;
			transition: background-color 0.3s;
		}

		button:hover {
			background-color: #0062cc;
		}

		@media only screen and (max-width: 600px) {
			h1 {
				font-size: 24px;
			}

			p {
				font-size: 18px;
			}

			button {
				font-size: 16px;
				padding: 12px 24px;
			}
		}
	</style>
</head>
<body>
	<div class="container">
		<h1>Welcome, <?php echo $user['name']; ?>!</h1>
		<p>You are now authorized to view this page.</p>
		<button onclick="window.location.href='index.php'"><i class="fas fa-arrow-left"></i> Go back to index</button>
	</div>
</body>
</html>
