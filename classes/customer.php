<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/format.php');
?>
<?php
class customer
{

    private $db;
    private $fm;
    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }
    public function insert_binhluan()
    {
        $product_id = $_POST['product_id_binhluan'];
        $tenbinhluan = $_POST['tennguoibinhluan'];
        $binhluan = $_POST['binhluan'];
        if ($tenbinhluan == '' || $binhluan == '') {
            $alert = " <span class='error'>Khong duoc de trong du lieu </span>";
            return $alert;
        } else {
            $query = "INSERT INTO tbl_comment(tenbinhluan, binhluan,product_id) VALUES('$tenbinhluan',
            '$binhluan','$product_id') ";
            $result = $this->db->insert($query);
            if ($result) {
                $alert = "<span class='success'>Binh luan se duoc admin kiem duyet</span>";
                return $alert;
            } else {
                $alert = "<span class='error'>Binh luan khong thanh cong</span>";
                return $alert;
            }
        }
    }
    public function insert_customer($data)
    {
        $name = mysqli_real_escape_string($this->db->link, $data['name']);
        $city = mysqli_real_escape_string($this->db->link, $data['city']);
        $zipcode = mysqli_real_escape_string($this->db->link, $data['zipcode']);
        $email = mysqli_real_escape_string($this->db->link, $data['email']);
        $address = mysqli_real_escape_string($this->db->link, $data['address']);
        $country = mysqli_real_escape_string($this->db->link, $data['country']);
        $phone = mysqli_real_escape_string($this->db->link, $data['phone']);
        $password = mysqli_real_escape_string($this->db->link, md5($data['password']));

        if (
            $name == "" || $city == "" || $zipcode == ""  || $email == "" || $address == "" || $country == "" || $phone == ""
            || $password == ""
        ) {
            $alert = " <span class='error'>Khong duoc de trong du lieu </span>";
            return $alert;
        } else {
            $check_email = "SELECT * FROM tbl_customer WHERE email = '$email' LIMIT 1";
            $result_ckeck = $this->db->select($check_email);
            if ($result_ckeck) {
                $alert = " <span class='error'>Email da ton tai </span>";
                return $alert;
            } else {
                $query = "INSERT INTO tbl_customer(name, city,zipcode, email,address,country,phone,password) VALUES('$name',
            '$city','$zipcode','$email','$address','$country','$phone','$password') ";
                $result = $this->db->insert($query);
                if ($result) {
                    $alert = "<span class='success'>Them nguoi dung thanh cong</span>";
                    return $alert;
                } else {
                    $alert = "<span class='error'>Them nguoi dung khong thanh cong</span>";
                    return $alert;
                }
            }
        }
    }
    public function login_customer($data)
    {
        $email = mysqli_real_escape_string($this->db->link, $data['email']);
        $password = mysqli_real_escape_string($this->db->link, md5($data['password']));

        if (empty($email) || empty($password)) {
            $alert = " <span class='error'>Khong duoc de trong du lieu </span>";
            return $alert;
        } else {
            $check_login = "SELECT * FROM tbl_customer WHERE email = '$email' AND password = '$password' LIMIT 1";
            $result_ckeck = $this->db->select($check_login);
            if ($result_ckeck != false) {
                $value = $result_ckeck->fetch_assoc();
                Session::set('customer_login', true);
                Session::set('customer_id', $value['id']);
                Session::set('customer_name', $value['name']);
                header('Location:order.php');
            } else {
                $alert = " <span class='error'>Email hoac Pass khong dung </span>";
                return $alert;
            }
        }
    }
    public function show_customer($id)
    {
        $query = "SELECT * FROM tbl_customer WHERE id = '$id' ";
        $result = $this->db->select($query);
        return $result;
    }
    public function show_order($order_code)
    {
        $query = "SELECT * FROM tbl_order WHERE order_code = '$order_code' ";
        $result = $this->db->select($query);
        return $result;
    }
    public function update_customer($data, $id)
    {
        $name = mysqli_real_escape_string($this->db->link, $data['name']);
        $zipcode = mysqli_real_escape_string($this->db->link, $data['zipcode']);
        $email = mysqli_real_escape_string($this->db->link, $data['email']);
        $address = mysqli_real_escape_string($this->db->link, $data['address']);
        $phone = mysqli_real_escape_string($this->db->link, $data['phone']);

        if ($name == "" || $zipcode == "" || $email == "" || $address == "" || $phone == "") {
            $alert = " <span class='error'>Khong duoc de trong du lieu </span>";
            return $alert;
        } else {
            $query = "UPDATE tbl_customer SET name='$name', zipcode='$zipcode', email='$email', address='$address', phone='$phone' WHERE id='$id'";
            $result = $this->db->update($query);

            if ($result) {
                $alert = "<span class='success'>Sua nguoi dung thanh cong</span>";
                return $alert;
            } else {
                $alert = "<span class='error'>Sua nguoi dung khong thanh cong</span>";
                return $alert;
            }
        }
    }
}
?>