<!DOCTYPE html>
<html>

	<head>
		<title>Online Shop</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="style.css">
		
		<?php
		include 'config.php';
		$pdo = pdo_connect_mysql();
		?>
		
	</head>
	
	<body>
	
		<div id="container">
		
			<div id="header">
				<h2><a href="home.php">Online Shop</a> - Everyday low prices!</h2>
					<?php
						if (isset($_GET['id'])) {
						$stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
						$stmt->execute([$_GET['id']]);
						$product = $stmt->fetch(PDO::FETCH_ASSOC);
						if (!$product) {
							die ('Product does not exist!');
						}
						} else {
							die ('Product does not exist!');
						}
					?>
			</div>
			
			<div id="article">
				
			<img src="img/<?=$product['img']?>" width="500" height="500" alt="<?=$product['name']?>">
			<div>
        		<h1 class="name"><?=$product['name']?></h1>
				<span class="price">
					&dollar;<?=$product['price']?>
				</span>
				
        <form action="index.php?page=cart" method="post">
            <input type="number" name="quantity" value="1" min="1" max="<?=$product['quantity']?>" placeholder="Quantity" required>
            <input type="hidden" name="product_id" value="<?=$product['id']?>">
            <input type="submit" value="Add To Cart">
        </form>
				
				
			</div>
			
			<div id="footer">
				<h2>Online Shop - 2019</h2>
			</div>
		
		</div>
	
	</body>

</html>
