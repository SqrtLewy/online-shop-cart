<!DOCTYPE html>
<html>

	<head>
		<title>Online Shop</title>
		<meta charset="UTF-8">
		
		<?php
		include 'config.php';
		$pdo = pdo_connect_mysql();
		?>
		
	</head>
	
	<body>
	
		<div id="container">
		
			<div id="header">
				<h2>Online Shop - Everyday low prices!</h2>
				
				<?php
					$num_products_on_each_page = 4;
					$current_page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;
					$stmt = $pdo->prepare('SELECT * FROM products ORDER BY id ASC LIMIT ?,?');
					$stmt->bindValue(1, ($current_page - 1) * $num_products_on_each_page, PDO::PARAM_INT);
					$stmt->bindValue(2, $num_products_on_each_page, PDO::PARAM_INT);
					$stmt->execute();
					$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
					
					$total_products = $pdo->query('SELECT * FROM products')->rowCount();
				?>
				
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
			        
			<?php if ($current_page > 1): ?>
			<a href="index.php?page=products&p=<?=$current_page-1?>">Prev</a>
			<?php endif; ?>
			<?php if ($total_products > ($current_page * $num_products_on_each_page) - $num_products_on_each_page + count($products)): ?>
			<a href="index.php?page=products&p=<?=$current_page+1?>">Next</a>
			<?php endif; ?>
			
			</div>
			
			<div id="footer">
				<h2>Online Shop - 2019</h2>
			</div>
		
		</div>
	
	</body>

</html>