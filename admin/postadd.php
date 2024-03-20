<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/post.php';?>
<?php
$post = new post();
if($_SERVER['REQUEST_METHOD']=== 'POST'){
	$catName = $_POST['catName'];
    $catDesc = $_POST['catDesc'];
    $catStatus = $_POST['catStatus'];
	$insertCat = $post->insert_post($catName,$catDesc,$catStatus);
}
?>

        <div class="grid_10">
            <div class="box round first grid">
                <h2>Them danh muc tin tuc</h2>
               
               <div class="block copyblock"> 
               <?php
                if(isset($insertCat)){
                    echo $insertCat;
                }
                ?>
                 <form autocomplete="off" action="postadd.php" method="POST">
                    <table class="form">					
                        <tr>
                            <td>
                                <input type="text" name="catName" placeholder="Them danh muc tin tuc" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="catDesc" placeholder="Them mo ta tin tin" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <select name="catStatus">
                                    <option value="0">Hien thi</option>
                                    <option value="1">An</option>
                                </select>
                            </td>
                        </tr>
						<tr> 
                            <td>
                                <input type="submit" name="submit" Value="Save" />
                            </td>
                        </tr>
                    </table>
                    </form>
                </div>
            </div>
        </div>
<?php include 'inc/footer.php';?>