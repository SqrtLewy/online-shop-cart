<!DOCTYPE html>
<html>

	<head>
		<title>Online Shop</title>
		<meta charset="UTF-8">
		
		<?php
		include 'config.php';
		$pdo = pdo_connect_mysql();
		
		$stmt = $pdo->prepare('SELECT * FROM products ORDER BY id ASC');
		$stmt->execute();
		$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
		?>
		
	</head>
	
	<body>
	
		<div id="container">
		
			<div id="header">
				<h2>Online Shop - Everyday low prices!</h2>
			</div>
			
			<div id="article">
			  <?php foreach ($products as $product): ?>
			  <a href="index.php?page=product&id=<?=$product['id']?>" class="product">
              <img src="img/<?=$product['img']?>" width="250" height="250" alt="<?=$product['name']?>">
              <span class="name"><?=$product['name']?></span>
            <span class="price">
                &dollar;<?=$product['price']?>
            </span>
        </a>
        <?php endforeach; ?>
			
			</div>
			
			<div id="footer">
				<h2>Online Shop - 2019</h2>
			</div>
		
		</div>
	
	</body>

</html>