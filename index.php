<!DOCTYPE html>
<html>

	<head>
		<title>Online Shop</title>
		<meta charset="UTF-8">
		
		<?php
		session_start();
		include 'config.php';
		$pdo = pdo_connect_mysql();
		
		$page = isset($_GET['page']) && file_exists($_GET['page'] . '.php') ? $_GET['page'] : 'home';
		include $page . '.php';
		?>
		
	</head>
	
	<body>
	
		<div id="container">
		
			<div id="header">
				<h2>Online Shop - Everyday low prices!</h2>
			</div>
			
			<div id="article">
			</div>
			
			<div id="footer">
				<h2>Online Shop - 2019</h2>
			</div>
		
		</div>
	
	</body>

</html>