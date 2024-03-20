<?php
include 'lib/session.php';
Session::init();
?>
<?php
include_once 'lib/database.php';
include_once 'helpers/format.php';

spl_autoload_register(function ($className) {
	include_once "classes/" . $className . ".php";
});

$db = new Database();
$fm = new Format();
$ct = new cart();
$cat = new category();
$cs = new customer();
$product = new product();
$pt = new post();

?>
<?php
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: max-age=2592000");
?>
<!DOCTYPE HTML>

<head>
	<title>Web bán đồng hồ</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
	<link href="css/menu.css" rel="stylesheet" type="text/css" media="all" />
	<script src="js/jquerymain.js"></script>
	<script src="js/script.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="js/nav.js"></script>	
	<script type="text/javascript" src="js/move-top.js"></script>
	<script type="text/javascript" src="js/easing.js"></script>
	<script type="text/javascript" src="js/nav-hover.js"></script>
	<link href='http://fonts.googleapis.com/css?family=Monda' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Doppio+One' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script type="text/javascript">
		$(document).ready(function($) {
			$('#dc_mega-menu-orange').dcMegaMenu({
				rowItems: '4',
				speed: 'fast',
				effect: 'fade'
			});
		});
	</script>
</head>

<body>
	<div class="wrap">
		<div class="header_top">
			<div class="logo">
				<a href="index.php"><img src="images/logo.png" alt="" /></a>
			</div>
			<div class="header_top_right">
				<div class="search_box">
					<form action="search.php" method="POST">
						<input type="text" placeholder="Tìm kiếm sản phẩm" name="tukhoa">
						<input type="submit" value="SEARCH" name="search_product">
					</form>
				</div>
				<div class="shopping_cart">
					<div class="cart">
						<a href="#" title="View my shopping cart" rel="nofollow">
							<span class="cart_title">Cart</span>
							<span class="no_product">
								<?php
								$check_cart = $ct->check_cart();
								if ($check_cart) {
									$sum = Session::get("sum");
									$qty = Session::get("qty");
									echo $fm->format_currency($sum) . ' ' . 'd' . '-' . 'Qty:' . $qty;
								} else {
									echo 'Empty';
								}
								?>
							</span>
						</a>
					</div>
				</div>
				<?php
				if (isset($_GET['customer_id'])) {
					$customer_id = $_GET['customer_id'];
					$delCart = $ct->del_all_data_cart();
					$delCompare = $ct->del_compare($customer_id);
					Session::destroy();
				}
				?>
				<div class="login">
					<?php
					$login_check = Session::get('customer_login');
					if ($login_check == false) {
						echo '<a href="login.php">Login</a>';
					} else {
						echo '<a href="?customer_id=' . Session::get('customer_id') . '">Logout</a>';
					}
					?>

				</div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="menu">
			<ul id="dc_mega-menu-orange" class="dc_mm-orange">
				<li><a href="index.php">Trang chủ</a></li>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="">Danh muc san pham
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<?php
						$cate = $cat->show_category();
						if ($cate) {
							while ($result = $cate->fetch_assoc()) {
						?>
								<li><a href="productbycat.php?catid=<?php echo $result['catId'] ?>"><?php echo $result['catName'] ?></a></li>
						<?php
							}
						}
						?>
					</ul>
				</li>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="">Tin tuc
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<?php
						$cate = $pt->show_post();
						if ($cate) {
							while ($result = $cate->fetch_assoc()) {
						?>
								<li><a href="postbycat.php?idpost=<?php echo $result['id_cate_post'] ?>"><?php echo $result['title'] ?></a></li>
						<?php
							}
						}
						?>
					</ul>
				</li>
				<li><a href="topbrands.php">Thương hiệu</a></li>
				<?php
				$check_cart = $ct->check_cart();
				if ($check_cart == true) {
					echo '<li><a href="cart.php">Giỏ hàng</a></li>';
				} else {
					echo '';
				}
				?>
				<?php
				$customers_id = Session::get('customer_id');
				$check_order = $ct->check_order($customers_id);
				if ($check_order == true) {
					echo '<li><a href="orderdetails.php">Đơn hàng</a></li>';
				} else {
					echo '';
				}
				?>
				<?php
				$login_check = Session::get('customer_login');
				if ($login_check == false) {
					echo '';
				} else {
					echo '<li><a href="profile.php">Tài khoản</a> </li>';
					echo '<li><a href="lichsudonhang.php">Lich su don</a> </li>';
				}
				?>
				<?php
				$login_check = Session::get('customer_login');
				if ($login_check) {
					echo '<li><a href="compare.php">So sánh</a> </li>';
				}
				?>
				<?php
				$login_check = Session::get('customer_login');
				if ($login_check) {
					echo '<li><a href="wishlist.php">Yêu thích</a> </li>';
				}
				?>

				<li><a href="contact.php">Liên hệ</a> </li>
				<div class="clear"></div>
			</ul>
		</div>