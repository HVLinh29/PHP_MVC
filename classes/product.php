<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/format.php');
?>
<?php
class product
{

    private $db;
    private $fm;
    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }
    public function search_product($tukhoa){
        $tukhoa = $this->fm->validation($tukhoa);
        $query = "SELECT * FROM tbl_sanpham WHERE productName LIKE '%$tukhoa%'";
        $result = $this->db->select($query);
        return $result;
    }
    public function get_star($id,$customer_id){
        $query = "SELECT * FROM tbl_rating WHERE product_id ='$id' AND customer_id='$customer_id'";
        $result = $this->db->select($query);
        return $result;
    }
    public function insert_product($data, $files)
    {

        $productName = mysqli_real_escape_string($this->db->link, $data['productName']);
        $soluong = mysqli_real_escape_string($this->db->link, $data['soluong']);
        $brand = mysqli_real_escape_string($this->db->link, $data['brand']);
        $category = mysqli_real_escape_string($this->db->link, $data['category']);
        $mota = mysqli_real_escape_string($this->db->link, $data['mota']);
        $price = mysqli_real_escape_string($this->db->link, $data['price']);
        $type = mysqli_real_escape_string($this->db->link, $data['type']);
        //Kiem tra hinh anh va lay hinh anh cho vao folder 
        $permited = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['hinhanh']['name'];
        $file_size = $_FILES['hinhanh']['size'];
        $file_temp = $_FILES['hinhanh']['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
        $uploaded_image = "uploads/" . $unique_image;



        if ($productName == "" || $soluong=="" || $brand == "" || $category == ""  || $mota == "" || $price == "" || $type == "" || $file_name == "") {
            $alert = " <span class='error'>Khong duoc de trong du lieu </span>";
            return $alert;
        } else {
            move_uploaded_file($file_temp, $uploaded_image);
            $query = "INSERT INTO tbl_sanpham(productName, product_quantity, catId,brandId, mota,type,price,hinhanh) VALUES('$productName','$soluong',
            '$category','$brand','$mota','$type','$price','$unique_image') ";
            $result = $this->db->insert($query);
            if ($result) {
                $alert = "<span class='success'>Them san pham thanh cong</span>";
                return $alert;
            } else {
                $alert = "<span class='error'>Them san pham khong thanh cong</span>";
                return $alert;
            }
        }
    }
    public function insert_slider($data,$files)
    {

        $name = mysqli_real_escape_string($this->db->link, $data['name']);
        $type = mysqli_real_escape_string($this->db->link, $data['type']);

        //Kiem tra hinh anh va lay hinh anh cho vao folder 
        $permited = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_temp = $_FILES['image']['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
        $uploaded_image = "uploads/" . $unique_image;


        if ($name == "" || $type == "") {
            $alert = " <span class='error'>Khong duoc de trong du lieu </span>";
            return $alert;
        } else {
            if (!empty($file_name)) {
                //Neu nguoi dung chon anh
                if ($file_size > 204800) {
                    $alert = "<span class='error'>Kich co hinh anh nen nho hon 2MB</span>";
                    return $alert;
                } elseif (in_array($file_ext, $permited) === false) {
                    $alert = "<span class='error'>Ban co the upload:-" . implode(', ', $permited) . "</span>";
                    return $alert;
                }
                move_uploaded_file($file_temp, $uploaded_image);
                $query = "INSERT INTO tbl_slider(sliderName, sliderimg ,type) VALUES('$name','$unique_image','$type') ";
                $result = $this->db->insert($query);
                if ($result) {
                    $alert = "<span class='success'>Them slider thanh cong</span>";
                    return $alert;
                } else {
                    $alert = "<span class='error'>Them slider khong thanh cong</span>";
                    return $alert;
                }
            }
        }
    }
    public function show_product()
    {

        $query = "SELECT tbl_sanpham.*,tbl_category.catName, tbl_brand.brandName FROM tbl_sanpham
            INNER JOIN tbl_category ON tbl_sanpham.catId = tbl_category.catId
            INNER JOIN tbl_brand ON tbl_sanpham.brandId = tbl_brand.brandId 
            ORDER BY tbl_sanpham.productId DESC";
        $result = $this->db->select($query);
        return $result;
    }
    public function show_slider(){
        $query = "SELECT * FROM tbl_slider WHERE type !=0 ORDER BY sliderId DESC ";
        $result = $this->db->select($query);
        return $result;
    }
    public function show_slider_list(){
        $query = "SELECT * FROM tbl_slider  ORDER BY sliderId DESC ";
        $result = $this->db->select($query);
        return $result;
    }
    public function getproductbyId($id)
    {
        $query = "SELECT * FROM tbl_sanpham WHERE productId='$id' ";
        $result = $this->db->select($query);
        return $result;
    }
    public function update_type_slider($id ,$type){
        
        $type = mysqli_real_escape_string($this->db->link, $type);
        $query = "UPDATE tbl_slider SET type = '$type' where sliderId = '$id' ";
        $result = $this->db->update($query);
        return $result;
    }
    public function del_slider($id){
        $query = "DELETE FROM tbl_slider WHERE sliderId='$id' ";
        $result = $this->db->delete($query);
        if ($result) {
            $alert = "<span class='success'>Xoa slider thanh cong</span>";
            return $alert;
        } else {
            $alert = "<span class='error'>Xoa slider khong thanh cong</span>";
            return $alert;
        }
    }
    public function update_product($data, $file, $id)
    {
        $productName = mysqli_real_escape_string($this->db->link, $data['productName']);
        $soluong = mysqli_real_escape_string($this->db->link, $data['soluong']);
        $brand = mysqli_real_escape_string($this->db->link, $data['brand']);
        $category = mysqli_real_escape_string($this->db->link, $data['category']);
        $mota = mysqli_real_escape_string($this->db->link, $data['mota']);
        $price = mysqli_real_escape_string($this->db->link, $data['price']);
        $type = mysqli_real_escape_string($this->db->link, $data['type']);
        //Kiem tra hinh anh va lay hinh anh cho vao folder 
        $permited = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['hinhanh']['name'];
        $file_size = $_FILES['hinhanh']['size'];
        $file_temp = $_FILES['hinhanh']['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
        $uploaded_image = "uploads/" . $unique_image;


        if ($productName == "" || $soluong=="" || $brand == "" || $category == ""  || $mota == "" || $price == "" || $type == "") {
            $alert = " <span class='error'>Khong duoc de trong du lieu </span>";
            return $alert;
        } else {
            if (!empty($file_name)) {
                //Neu nguoi dung chon anh
                if ($file_size > 204800) {
                    $alert = "<span class='error'>Kich co hinh anh nen nho hon 2MB</span>";
                    return $alert;
                } elseif (in_array($file_ext, $permited) === false) {
                    $alert = "<span class='error'>Ban co the upload:-" . implode(', ', $permited) . "</span>";
                    return $alert;
                }
                move_uploaded_file($file_temp, $uploaded_image);
                $query = "UPDATE tbl_sanpham SET 
                productName = '$productName',
                product_quantity = '$soluong',
                brandId = '$brand',
                catId = '$category',
                type = '$type',
                price = '$price', 
                hinhanh = '$unique_image',
                mota = '$mota' 
                WHERE productId = '$id' ";
            } else {
                // Neu nguoi dung khong chon anh
                $query = "UPDATE tbl_sanpham SET 
                productName = '$productName',
                product_quantity = '$soluong',
                brandId = '$brand',
                catId = '$category',
                type = '$type',
                price = '$price', 
                mota = '$mota' 
                WHERE productId = '$id' ";
            }
            $result = $this->db->update($query);
            if ($result) {
                $alert = "<span class='success'>Sua san pham thanh cong</span>";
                return $alert;
            } else {
                $alert = "<span class='error'>Sua san pham khong thanh cong</span>";
                return $alert;
            }
        }
    }
    public function del_product($id)
    {
        $query = "DELETE FROM tbl_sanpham WHERE productId='$id' ";
        $result = $this->db->delete($query);
        if ($result) {
            $alert = "<span class='success'>Xoa san pham thanh cong</span>";
            return $alert;
        } else {
            $alert = "<span class='error'>Xoa san pham khong thanh cong</span>";
            return $alert;
        }
    }
    public function del_wl($proid, $customers_id)
    {
        $query = "DELETE FROM tbl_spyeuthich WHERE productId='$proid' AND customer_id='$customers_id' ";
        $result = $this->db->delete($query);
        return $result;
    }
    //FONT END
    public function getproduct_feathered()
    {
        $query = "SELECT * FROM tbl_sanpham WHERE type=0 ";
        $result = $this->db->select($query);
        return $result;
    }

    public function getproduct_new()
    {
        $sp_tungtrang = 4;
        if(!isset($_GET['trang'])){
            $trang=1;
        }else{
            $trang = $_GET['trang'];
        }
        $tungtrang = ($trang-1)*$sp_tungtrang;
        $query = "SELECT * FROM tbl_sanpham ORDER BY productId DESC LIMIT $tungtrang,$sp_tungtrang  ";
        $result = $this->db->select($query);
        return $result;
    }
    public function get_all_product()
    {
        $query = "SELECT * FROM tbl_sanpham";
        $result = $this->db->select($query);
        return $result;
    }

    public function get_details($id)
    {
        $query = "SELECT tbl_sanpham.*,tbl_category.catName, tbl_brand.brandName FROM tbl_sanpham
            INNER JOIN tbl_category ON tbl_sanpham.catId = tbl_category.catId
            INNER JOIN tbl_brand ON tbl_sanpham.brandId = tbl_brand.brandId 
            WHERE tbl_sanpham.productId ='$id'";
        $result = $this->db->select($query);
        return $result;
    }
    public function getLastesDell()
    {
        $query = "SELECT * FROM tbl_sanpham WHERE brandId = '7' ORDER BY productId DESC LIMIT 1 ";
        $result = $this->db->select($query);
        return $result;
    }
    public function getLastesAcer()
    {
        $query = "SELECT * FROM tbl_sanpham WHERE brandId = '5' ORDER BY productId DESC LIMIT 1 ";
        $result = $this->db->select($query);
        return $result;
    }
    public function getLastesIphon()
    {
        $query = "SELECT * FROM tbl_sanpham WHERE brandId = '8' ORDER BY productId DESC LIMIT 1 ";
        $result = $this->db->select($query);
        return $result;
    }
    public function getLastesSS()
    {
        $query = "SELECT * FROM tbl_sanpham WHERE brandId = '9' ORDER BY productId DESC LIMIT 1 ";
        $result = $this->db->select($query);
        return $result;
    }
    public function insertCompare($productid, $customer_id)
    {
        $productid = mysqli_real_escape_string($this->db->link, $productid);
        $customer_id = mysqli_real_escape_string($this->db->link, $customer_id);

        $check_compare = "SELECT * FROM tbl_compare WHERE productId = '$productid' AND customer_id ='$customer_id'";
        $result_check_compare = $this->db->select($check_compare);
        if ($result_check_compare) {
            $msg = "<span class='error'>San pham da co trong Compare</span>";
            return $msg;
        } else {


            $query = "SELECT * FROM tbl_sanpham WHERE productId = '$productid'";
            $result = $this->db->select($query)->fetch_assoc();


            $query_insert = "INSERT INTO tbl_compare(productId, customer_id, productName, price, hinhanh)
         VALUES('$productid', '$customer_id', '{$result['productName']}', '{$result['price']}', '{$result['hinhanh']}')";

            $insert = $this->db->insert($query_insert);
            if ($insert) {
                $alert = "<span class='success'>Them Compare thanh cong</span>";
                return $alert;
            } else {
                $alert = "<span class='error'>Them Compare khong thanh cong</span>";
                return $alert;
            }
        }
    }
    public function get_compare($customers_id)
    {
        $query = "SELECT * FROM tbl_compare WHERE customer_id = '$customers_id' ORDER BY id DESC  ";
        $result = $this->db->select($query);
        return $result;
    }
    public function get_whistlist($customers_id)
    {
        $query = "SELECT * FROM tbl_spyeuthich WHERE customer_id = '$customers_id' ORDER BY id DESC  ";
        $result = $this->db->select($query);
        return $result;
    }
    public function insertWishlist($productid, $customer_id)
    {
        $productid = mysqli_real_escape_string($this->db->link, $productid);
        $customer_id = mysqli_real_escape_string($this->db->link, $customer_id);

        $check_wl = "SELECT * FROM tbl_spyeuthich WHERE productId = '$productid' AND customer_id ='$customer_id'";
        $result_check_wl = $this->db->select($check_wl);
        if ($result_check_wl) {
            $msg = "<span class='error'>San pham da co trong SP yeu thich</span>";
            return $msg;
        } else {


            $query = "SELECT * FROM tbl_sanpham WHERE productId = '$productid'";
            $result = $this->db->select($query)->fetch_assoc();


            $query_insert = "INSERT INTO tbl_spyeuthich(productId, customer_id, productName, price, hinhanh)
         VALUES('$productid', '$customer_id', '{$result['productName']}', '{$result['price']}', '{$result['hinhanh']}')";

            $insert = $this->db->insert($query_insert);
            if ($insert) {
                $alert = "<span class='success'>Them SP yeu thich thanh cong</span>";
                return $alert;
            } else {
                $alert = "<span class='error'>Them SP yeu thich khong thanh cong</span>";
                return $alert;
            }
        }
    }
}
?>