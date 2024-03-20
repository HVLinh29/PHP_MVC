<?php
include 'inc/header.php';
// include 'inc/slider.php';
?>
<?php
if (!isset($_GET['proid']) || $_GET['proid'] == NULL) {
	echo "<script>window.location = '404.php'</script>";
} else {
	$id = $_GET['proid'];
}
$customer_id = Session::get('customer_id');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['compare'])) {
	$productid = $_POST['productid'];
	$insertCompare = $product->insertCompare($productid, $customer_id);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['wishlist'])) {
	$productid = $_POST['productid'];
	$insertWishlist = $product->insertWishlist($productid, $customer_id);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

	$soluong = $_POST['soluong'];
	$product_stock = $_POST['stock'];
	$insertCart = $ct->add_to_cart($soluong, $product_stock, $id);
}

if (isset($_POST['binhluan_submit'])) {
	$binhluan_insert = $cs->insert_binhluan();
}
?>


<div class="main">
	<div class="content">
		<div class="section group">
			<?php
			$get_product_details = $product->get_details($id);
			if ($get_product_details) {
				while ($result_details = $get_product_details->fetch_assoc()) {

			?>
					<div class="cont-desc span_1_of_2">
						<div class="grid images_3_of_2">
							<img src="admin/uploads/<?php echo $result_details['hinhanh'] ?>" alt="" />
						</div>
						<div class="desc span_3_of_2">
							<h2><?php echo $result_details['productName'] ?> </h2>
							<p><?php echo $fm->textShorten($result_details['mota'], 20) ?></p>
							<div class="price">
								<p>Price: <span><?php echo $fm->format_currency($result_details['price']) . " " . "VND" ?></span></p>
								<p>Category: <span><?php echo $result_details['catName'] ?></span></p>
								<p>Brand:<span><?php echo $result_details['brandName'] ?></span></p>
								<p>Stock:<span><?php echo $result_details['product_quantity'] ?></span></p>

							</div>
							<div class="add-cart">
								<form action="" method="post">
									<input type="hidden" class="buyfield" name="stock" value="<?php echo $result_details['product_quantity'] ?>" />
									<input type="number" class="buyfield" name="soluong" value="1" min="1" />
									<?php
									if ($result_details['product_quantity'] > 0) {
									?>
										<input type="submit" class="buysubmit" name="submit" value="Buy Now" />
									<?php
									}
									?>

								</form>
								<?php
								if (isset($insertCart)) {
									echo $insertCart;
								}
								?>
								<?php
								if (isset($Addtocart)) {
									echo '<span style="color:red; font-size:18px;"> San pham da co trong gio hang</span>';
								}
								?>
							</div>
							<div class="add-cart">
								<div class="butoon_details">
									<form action="" method="POST">
										<!-- <a href="?wlist=<?php echo $result_details['productId'] ?>" class="buysubmit">Luu vao danh sach yeu thich</a> -->
										<!-- <a href="?compare=<?php echo $result_details['productId'] ?>" class="buysubmit">So sanh san pham</a> -->
										<input type="hidden" name="productid" value="<?php echo $result_details['productId'] ?>" />

										<?php

										$login_check = Session::get('customer_login');
										if ($login_check) {
											echo '<input type="submit" class="buysubmit" name="compare" value="Compare Product" />' . ' ';;
										} else {
											echo '';
										}
										?>



										<!-- form san pham yeu thich -->
									</form>
									<form action="" method="POST">
										<!-- <a href="?wlist=<?php echo $result_details['productId'] ?>" class="buysubmit">Luu vao danh sach yeu thich</a> -->
										<!-- <a href="?compare=<?php echo $result_details['productId'] ?>" class="buysubmit">So sanh san pham</a> -->
										<input type="hidden" name="productid" value="<?php echo $result_details['productId'] ?>" />

										<?php

										$login_check = Session::get('customer_login');
										if ($login_check) {
											echo '<input type="submit" class="buysubmit" name="wishlist" value="Save to Wishlist"/>';
										} else {
											echo '';
										}
										?>

									</form>
									<div class="clear"></div>
									<p>
										<?php

										if (isset($insertCompare)) {
											echo $insertCompare;
										}
										?>
										<?php
										if (isset($insertWishlist)) {
											echo $insertWishlist;
										}
										?>
									</p>

								</div>
							</div>


						</div>
						<div class="product-desc">
							<h2>Product Details</h2>
							<p><?php echo $fm->textShorten($result_details['mota'], 20) ?></p>

						</div>

					</div>
			<?php
				}
			}
			?>
			<div class="rightsidebar span_3_of_1">
				<h2>CATEGORIES</h2>
				<ul>

					<?php
					$getall_category =  $cat->show_category_gd();
					if ($getall_category) {
						while ($result_allcat = $getall_category->fetch_assoc()) {
					?>
							<li><a href="productbycat.php?catid=<?php echo $result_allcat['catId'] ?>"><?php echo $result_allcat['catName'] ?></a></li>
					<?php
						}
					}
					?>

				</ul>


			</div>

		</div>
	</div>
	<div class="comment">
		<div class="row">
			<div class="col-md-8">
				<h5>Ys kiến sản phẩm</h5>
				<ul>
					<?php
					if (Session::get('customer_id')) {
						$customer_id = Session::get('customer_id');
						$get_star = $product->get_star($id,$customer_id);
						if ($get_star) {
							$tongsao = 0;
							$trungbinhsao=0;
							$solan = 0;
							while ($result_star = $get_star->fetch_assoc()) {
								$tongsao+=$result_star['rating'];
								$solan+=1;
								$trungbinhsao = $tongsao/$solan;
								
							}
							
						}
					}

					$get_product_details2 = $product->get_details($id);
					if ($get_product_details2) {
						while ($result_details2 = $get_product_details2->fetch_assoc()) {

					?>
							<?php
							for ($count = 1; $count <= 5; $count++) {
								if ($count <= round($trungbinhsao)) {
									$color = 'color:#ffcc00;'; // mau vang
								} else {
									$color = 'color:#ccc;'; // mau xanh
								}

							?>
								<?php
								if (Session::get('customer_id')) {
								?>
									<li class="rating" style="cursor: pointer;font-size:40px;<?php echo $color ?>" id="<?php echo $result_details2['productId'] ?>-<?php echo $count ?>" data-product_id="<?php echo $result_details2['productId'] ?>" data-rating="<?php echo $count ?>" data-index="<?php echo $count ?>" data-customer_id="<?php echo Session::get('customer_id') ?>">&#9733;</li>
								<?php
								} else {
								?>
									<li class="rating_login" style="cursor: pointer;font-size:40px;color:#ccc; display:inline-block;">&#9733;</li>
								<?php
								}
								?>
							<?php
							}
							?>
							<li>Da danh gia: <?php echo round($trungbinhsao)?>/5</li>
				</ul>

		<?php
						}
					}
		?>
		<?php
		if (isset($binhluan_insert)) {
			echo $binhluan_insert;
		}
		?>
		<form action="" method="POST">
			<p><input type="hidden" value="<?php echo $id ?>" name="product_id_binhluan"></p>
			<p><input type="text" class="form-control" name="tennguoibinhluan" placeholder="Tên..."></p>
			<p><textarea rows="5" style="resize: none;" placeholder="Bình luận...." class="form-control" name="binhluan"></textarea></p>
			<p><input type="submit" name="binhluan_submit" class="btn btn-success" value="Gửi binh luận"></p>
		</form>
			</div>
		</div>
	</div>
</div>
<?php
include 'inc/footer.php';
?>