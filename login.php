
<?php
include 'inc/header.php';
?>
<?php
$login_check = Session::get('customer_login');
if ($login_check) {
	header(('Location:order.php'));
} 
?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

	$insertCustomer = $cs->insert_customer($_POST);
}
?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {

	$loginCustomer = $cs->login_customer($_POST);
}
?>

<div class="main">
	<div class="content">
		<div class="login_panel">
			<h3>Dang Nhap</h3>
			<?php
			if (isset($loginCustomer)) {
				echo $loginCustomer;
			}
			?>
			<!-- <p>Sign in with the form below.</p> -->
			<form action="" method="POST">
				<input type="text" name="email" class="field" placeholder="Nhap Email">
				<input type="password" name="password" class="field" placeholder="Nhap Pass">

				<!-- <p class="note">If you forgot your passoword just enter your email and click <a href="#">here</a></p> -->
				<div class="buttons">
					<div><input type="submit" name="login" class="grey" value="Sign In"></div>
				</div>
			</form>
		</div>
		<?php
		if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

			$insertProduct = $cs->insert_customer($_POST, $_FILES);
		}
		?>
		<div class="register_account">
			<h3>Dang ki Tai Khoan</h3>
			<?php
			if (isset($insertCustomer)) {
				echo $insertCustomer;
			}
			?>
			<form action="" method="POST">
				<table>
					<tbody>
						<tr>
							<td>
								<div>
									<input type="text" name="name" placeholder="Nhap ten">
								</div>

								<div>
									<input type="text" name="city" placeholder="Nhap thanh pho">
								</div>

								<div>
									<input type="text" name="zipcode" placeholder="Nhap code">
								</div>
								<div>
									<input type="text" name="email" placeholder="Nhap email">
								</div>
							</td>
							<td>
								<div>
									<input type="text" name="address" placeholder="Nhap dia chi">
								</div>
								<div>
									<select id="country" name="country" onchange="change_country(this.value)" class="frm-field required">
										<option value="null">Select a Country</option>
										<option value="HN">Ha Noi</option>
										<option value="YB">Yen Bai</option>



									</select>
								</div>

								<div>
									<input type="text" name="phone" placeholder="Nhap Phone">
								</div>

								<div>
									<input type="text" name="password" placeholder="Nhap mat khau">
								</div>
							</td>
						</tr>
					</tbody>
				</table>
				<div class="search">
					<div><input type="submit" name="submit" class="grey" value="Create Account"></button></div>
				</div>
				<p class="terms">By clicking 'Create Account' you agree to the <a href="#">Terms &amp; Conditions</a>.</p>
				<div class="clear"></div>
			</form>
		</div>
		<div class="clear"></div>
	</div>
</div>
<?php
include 'inc/footer.php';
?>