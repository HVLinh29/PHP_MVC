<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/format.php');
?>
<?php
class cart
{

    private $db;
    private $fm;
    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }
    public function add_to_cart($soluong, $product_stock, $id)
    {
        $soluong = $this->fm->validation($soluong);
        $soluong = mysqli_real_escape_string($this->db->link, $soluong);

        $product_stock = $this->fm->validation($product_stock);
        $product_stock = mysqli_real_escape_string($this->db->link, $product_stock);

        $sId = mysqli_real_escape_string($this->db->link, $id);
        $sId = session_id();

        $check_cart = "SELECT * FROM tbl_cart WHERE productId = '$id' AND sid ='$sId' ";
        $result_check_cart = $this->db->select($check_cart);
        if ($soluong <= $product_stock) { // neu so luong dat nho hon so luong co trong kho
            if ($result_check_cart) {
                $msg = "<span class='error'>San pham da duoc them vao </span>";
                return $msg;
            } else {
                $query = "SELECT * FROM tbl_sanpham WHERE productId = '$id'";
                $result = $this->db->select($query)->fetch_assoc();


                $query_insert = "INSERT INTO tbl_cart(stock, productId, soluong, sId, hinhanh, price, productName)
                VALUES('$product_stock','$id', '$soluong', '$sId', '{$result['hinhanh']}', '{$result['price']}', '{$result['productName']}')";

                $insert = $this->db->insert($query_insert);
                if ($insert) {
                    $msg = "<span class='success'>Them san pham thanh cong</span>";
                    return $msg;
                }
            }
        } else {
            $msg = "<span class='error'>So luong dat khong du</span>";
            return $msg;
        }
    }

    public function get_product_cart()
    {
        $sId = session_id();
        $query = "SELECT * FROM tbl_cart WHERE sId = '$sId'";
        $result = $this->db->select($query);
        return $result;
    }
    public function get_product_cart_checkout()
    {
        $sId = session_id();
        $query = "SELECT * FROM tbl_cart WHERE sId = '$sId' AND tbl_cart.status=1";
        $result = $this->db->select($query);
        return $result;
    }
    public function update_sp_cart($stock,$soluong, $cartId)
    {
        $stock = mysqli_real_escape_string($this->db->link, $stock);
        $soluong = mysqli_real_escape_string($this->db->link, $soluong);
        $cartId = mysqli_real_escape_string($this->db->link, $cartId);
        if($stock >= $soluong){
            $query = "UPDATE tbl_cart SET soluong ='$soluong' WHERE cartId = '$cartId' ";
            $result = $this->db->update($query);
            if ($result) {
                header('Location:cart.php');
            } else {
                $msg = "<span class='error'>Cap nhat so luong khong thanh cong</span>";
                return $msg;
            }
        }
        else{
            $msg = "<span class='error'>So luong SP khong du</span>";
                return $msg;
        }
    }
    public function del_product_cart($cartid)
    {
        $cartid = mysqli_real_escape_string($this->db->link, $cartid);
        $query = "DELETE FROM tbl_cart WHERE cartId = '$cartid' ";
        $result = $this->db->delete($query);
        if ($result) {
            header('Location:cart.php');
        } else {
            $msg = "<span class='error'>Xoa san pham khong thanh cong</span>";
            return $msg;
        }
    }
    public function del_compare($customer_id)
    {
        $sId = session_id();
        $query = "DELETE FROM tbl_compare WHERE customer_id = '$customer_id'";
        $result = $this->db->delete($query);
        return $result;
    }
    public function check_cart()
    {
        $sId = session_id();
        $query = "SELECT * FROM tbl_cart WHERE sId = '$sId'";
        $result = $this->db->select($query);
        return $result;
    }
    public function del_all_data_cart()
    {
        $sId = session_id();
        $query = "DELETE FROM tbl_cart WHERE sId = '$sId'";
        $result = $this->db->select($query);
        return $result;
    }
    public function inserOrder($customers_id)
    {
        $sId = session_id();
        $query = "SELECT * FROM tbl_cart WHERE sId = '$sId'"; //chon sp tu gio hang
        $get_product = $this->db->select($query);
        $order_code = rand(0000,9999);
        //them vao tbl_placer
        $query_placed = "INSERT INTO tbl_placed(customer_id,order_code,status) VALUE ('$customers_id', '$order_code','0')"; //chon sp tu gio hang
        $insert_place = $this->db->insert($query_placed);
        if ($get_product) {
            while ($result = $get_product->fetch_assoc()) {
                $productid = $result['productId'];
                $productName = $result['productName'];
                $soluong = $result['soluong'];
                $price = $result['price'] * $soluong;
                $hinhanh = $result['hinhanh'];
                $customer_id = $customers_id;
                $query_order = "INSERT INTO tbl_order(order_code,productId, productName,soluong,price,hinhanh,customer_id)
                 VALUES('$order_code','$productid', '$productName', '$soluong', '$price', '$hinhanh','$customer_id')";
                $insert = $this->db->insert($query_order);
            }
        }
    }
    public function getAmountPrice($customers_id)
    {
        $query = "SELECT price FROM tbl_order WHERE customer_id = '$customers_id'";
        $result = $this->db->select($query);
        return $result;
    }
    public function get_cart_ordered($customers_id)
    {
        $query = "SELECT * FROM tbl_order WHERE customer_id = '$customers_id'";
        $get_cart_ordered = $this->db->select($query);
        return $get_cart_ordered;
    }
    public function check_order($customers_id)
    {
        $sId = session_id();
        $query = "SELECT * FROM tbl_order WHERE customer_id = '$customers_id'";
        $result = $this->db->select($query);
        return $result;
    }
    public function get_inbox_cart()
    {
        $query = "SELECT * FROM tbl_placed,tbl_customer WHERE tbl_placed.customer_id=tbl_customer.id ORDER BY date_created";
        $result = $this->db->select($query);
        return $result;
    }
    public function get_inbox_cart_history($customer_id){
        $query = "SELECT * FROM tbl_placed,tbl_customer WHERE tbl_placed.customer_id=tbl_customer.id AND tbl_placed.customer_id='$customer_id'
        ORDER BY date_created";
        $result = $this->db->select($query);
        return $result;
    }
    public function shifted($id)
    {
        $id = mysqli_real_escape_string($this->db->link, $id);
      
        $query = "UPDATE tbl_placed SET status ='1' WHERE order_code = '$id' ";
        $result = $this->db->update($query);
        if ($result) {
            $msg = "<span class='success'>Update Order thanh cong</span>";
            return $msg;
        } else {
            $msg = "<span class='error'>Update Order khong thanh cong</span>";
            return $msg;
        }
    }
    public function danhanhang($id){
        $id = mysqli_real_escape_string($this->db->link, $id);
      
        $query = "UPDATE tbl_placed SET status ='2' WHERE order_code = '$id' ";
        $result = $this->db->update($query);
        if ($result) {
            $msg = "<span class='success'>Update Order thanh cong</span>";
            return $msg;
        } else {
            $msg = "<span class='error'>Update Order khong thanh cong</span>";
            return $msg;
        }
    }
    public function del_shifted($id)
    {
        $id = mysqli_real_escape_string($this->db->link, $id);
        $query = "DELETE FROM tbl_placed  WHERE order_code = '$id'  ";
        $result = $this->db->update($query);
        if ($result) {
            $msg = "<span class='success'>Xoa don hang thanh cong</span>";
            return $msg;
        } else {
            $msg = "<span class='error'>Xoa don hang khong thanh cong</span>";
            return $msg;
        }
    }
    public function shifted_cf($id, $time, $price)
    {
        $id = mysqli_real_escape_string($this->db->link, $id);
        $time = mysqli_real_escape_string($this->db->link, $time);
        $price = mysqli_real_escape_string($this->db->link, $price);
        $query = "UPDATE tbl_order SET status ='2' WHERE customer_id = '$id' AND date_order='$time' AND price ='$price' ";
        $result = $this->db->update($query);
    }
}
?>