<!DOCTYPE html>
<html>

<head>
    <title>Online Shop</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">

    <?php
    include_once 'config.php';
    $pdo = pdo_connect_mysql();
    ?>

</head>

<body>

<div id="container">

    <div id="header">
        <h2><a href="home.php">Online Shop</a> - Everyday low prices!</h2>

        <?php
        if (isset($_POST['product_id'], $_POST['quantity']) && is_numeric($_POST['product_id']) && is_numeric($_POST['quantity'])) {
            $product_id = (int)$_POST['product_id'];
            $quantity = (int)$_POST['quantity'];
            $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
            $stmt->execute([$_POST['product_id']]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($product && $quantity > 0) {
                if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                    if (array_key_exists($product_id, $_SESSION['cart'])) {
                        $_SESSION['cart'][$product_id] += $quantity;
                    } else {
                        $_SESSION['cart'][$product_id] = $quantity;
                    }
                } else {
                    $_SESSION['cart'] = array($product_id => $quantity);
                }
            }
        }

        if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) {
            unset($_SESSION['cart'][$_GET['remove']]);
        }

        if (isset($_POST['update']) && isset($_SESSION['cart'])) {
            foreach ($_POST as $k => $v) Ł{
                if (strpos($k, 'quantity') !== false && is_numeric($v)) {
                    $id = str_replace('quantity-', '', $k);
                    $quantity = (int)$v;
                    if (is_numeric($id) && isset($_SESSION['cart'][$id]) && $quantity > 0) {
                        $_SESSION['cart'][$id] = $quantity;
                    }
                }
            }
        }

        if (isset($_POST['placeorder']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            header('Location: index.php?page=placeorder');
            exit;
        }
        $products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
        $products = array();
        $subtotal = 0.00;

        if ($products_in_cart) {
            $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
            $stmt = $pdo->prepare('SELECT * FROM products WHERE id IN (' . $array_to_question_marks . ')');
            $stmt->execute(array_keys($products_in_cart));
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($products as $product) {
                $subtotal += $product['price'] * $products_in_cart[$product['id']];
            }
        }
        ?>

    </div>

    <div id="article">

        <form action="index.php?page=cart" method="post">
            <table>
                <thead>
                <tr>
                    <td colspan="2">Product</td>
                    <td>Price</td>
                    <td>Quantity</td>
                    <td>Total</td>
                </tr>
                </thead>
                <?php if (empty($products)): ?>
                    <tr>
                        <td colspan="5" style="text-align:center;">You have no products added in your Shopping Cart</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td class="img">
                                <a href="index.php?page=product&id=<?= $product['id'] ?>">
                                    <img src="img/<?= $product['img'] ?>" width="50" height="50"
                                         alt="<?= $product['name'] ?>">
                                </a>
                            </td>
                            <td>
                                <a href="index.php?page=product&id=<?= $product['id'] ?>"><?= $product['name'] ?></a>
                                <br>
                                <a href="index.php?page=cart&remove=<?= $product['id'] ?>" class="remove">Remove</a>
                            </td>
                            <td class="price">&dollar;<?= $product['price'] ?></td>
                            <td class="quantity">
                                <input type="number" name="quantity-<?= $product['id'] ?>"
                                       value="<?= $products_in_cart[$product['id']] ?>" min="1"
                                       max="<?= $product['quantity'] ?>" placeholder="Quantity" required>
                            </td>
                            <td class="price">&dollar;<?= $product['price'] * $products_in_cart[$product['id']] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </table>
            <div class="subtotal">
                <span class="text">Subtotal</span>
                <span class="price">&dollar;<?= $subtotal ?></span>
            </div>
            <div class="buttons">
                <input type="submit" value="Update" name="update">
                <input type="submit" value="Place Order" name="placeorder">
            </div>
        </form>

    </div>

    <div id="footer">
        <h2>Online Shop - 2019</h2>
    </div>

</div>

</body>

</html>
