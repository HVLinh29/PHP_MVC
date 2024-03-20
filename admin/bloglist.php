<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/post.php'; ?>
<?php include '../classes/blog.php'; ?>
<?php
$blog = new blog();
if (isset($_GET['id']) ) {
	$id = $_GET['id'];
	$delTT = $blog->del_blog($id);
}
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Danh sach tin tuc</h2>
        <div class="block">  
		<?php
			if (isset($delTT)) {
				echo $delTT;
			}
			?>
            <table class="data display datatable" id="example">
			<thead>
				<tr>
					<th>Id</th>
					<th>Ten tin tuc</th>
                    <th>Mo ta</th>
					<th>Hinh anh</th>
					<th>Category</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				
				$bloglist = $blog->show_blog();
				if($bloglist){
					$i=0;
					while($result = $bloglist->fetch_assoc()){
					$i++;
				
				?>
				<tr class="odd gradeX">
					<td><?php echo $i?></td>
					<td><?php echo $result['title']?></td>
					<td><?php echo $result['mota']?></td>
                    <td><img src=uploads/<?php echo $result['hinhanh']?> width="100px"></td>
					<td><?php echo $result['title']?></td>
					<td>
						<?php if($result['status']==0){
							echo "Hien thi";
						}else{
							echo "An";
						}
							?>
					</td>
					<td><a href="blogedit.php?id=<?php echo $result['id']?>">Edit</a> || 
					<a href="?id=<?php echo $result['id']?>">Delete</a></td>
				</tr>
				<?php
					}
				}
				?>
			</tbody>
		</table>

       </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        setupLeftMenu();
        $('.datatable').dataTable();
		setSidebarHeight();
    });
</script>
<?php include 'inc/footer.php';?>
