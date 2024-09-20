<?php
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "salesmaster");

$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

include('function.php');

if (isset($_GET['logout'])) {
    session_destroy();
    header('location: login.php');
    exit;
}

if (!isset($_SESSION["salesid"])) {
    $_SESSION["salesid"] = rand();
}

function selectSn($sn){
    global $db;
    $sql = $db->query("SELECT * FROM product WHERE sn = '$sn'");
    $row = mysqli_fetch_assoc($sql);
    return $row['item'];
}

// $productid = $_SESSION["productid"];

$user = $_SESSION['user'] ?? '';
$salesid = $_SESSION["salesid"];

if ($user) {
    $sql = $db->query("SELECT * FROM user WHERE sn = '$user' ");
    $row = mysqli_fetch_assoc($sql);
    $name = $row['name'];
    $status = $row['status'];
    $bid = $row['bid'];
    $admin = $row['admin'];

    if (!isset($_COOKIE['biztitle'])) {
        $sql = $db->query("SELECT * FROM business WHERE sn = '$bid' ");
        $row = mysqli_fetch_assoc($sql);
        $biztitle = $row['name'];

        setcookie('biztitle', $biztitle, time() + (86400 * 730), "/");
    }
}



// Alert Function

function Alert($note, $x = 1)
{
    echo $x == 1 ? '<div class="alert alert-success" role="alert">
  ' . $note . '!
</div>' : '<div class="alert alert-danger" role="alert">
  ' . $note . '!
</div>';
    return;
}

// Status Function

function status($status)
{
    $rem = "";
    if ($status == 0) {
        $rem = 'Deleted';
    } elseif ($status == 1) {
        $rem = 'In Cart';
    } else {
        $rem = 'Checked Out';
    }

    echo "$rem";
}

function stock($qty)
{
    $rem = "";
    if ($qty == 0) {
        $rem = 'Out of Stock';
    } elseif ($qty <= 20) {
        $rem = 'Almost Out Of Stock';
    } else {
        $rem = 'In Stock';
    }

    echo "$rem";
}

// Salesmaster Class

class Salesmaster
{
    function __construct()
    {
        if (array_key_exists("AddItem", $_POST)) {
            $this->AddItem();
        }
        if (array_key_exists("Checkout", $_POST)) {
            $this->Checkout();
        }
        if (isset($_POST['clearAll'])) {
            $this->clearAll();
        }
        if (isset($_GET["delete"])) {
            $this->delete();
        }
        if (isset($_GET['edit'])) {
            $this->edit();
        }
        if (array_key_exists("RegisterUser", $_POST)) {
            $this->RegisterUser();
        }
        if (array_key_exists('UserLogin', $_POST)) {
            $this->UserLogin();
        }
        if (isset($_GET['sn'])) {
            $this->updateUserStatus();
        }
        if (array_key_exists("AddProduct", $_POST)) {
            $this->AddProduct();
        }
        if (array_key_exists("AddCategories", $_POST)) {
            $this->AddCategories();
        } 
        if (isset($_GET["restore"])) {
            $this->restore();
        }
        if (isset($_GET['pedit'])) {
            $this->pedit();
        }
    }


    // AddItem Method

    function AddItem()

    {
        global $db, $salesid, $user, $bid;
        if (isset ($_POST['item'],$_POST['price'],$_POST['qty'],$_POST['amount'])) 
        {
            $item = $_POST['item'];
            $price = $_POST['price'];
            $qty = $_POST['qty'];
            $amount = $_POST['amount'];
        }
        $sql =  $db->query("INSERT INTO item (item,price,qty,amount,salesid,user,bid) VALUES ('$item','$price','$qty','$amount','$salesid','$user','$bid') ");
        if ($sql) {
            Alert('Successfully Added to cart');
        } else {
            Alert('Error Submitting data', 0);
        }
        return;
    }

    function sqLx($table,$col1,$val1,$col)
	{
		global $db;
	$sql=$db->query("SELECT * FROM $table WHERE $col1='$val1' " )or die(mysqli_error($db));	
        if(mysqli_num_rows($sql)==0){return ''; }
		$row = mysqli_fetch_assoc($sql); 
		return $row[$col];
	}

    // Checkout Method

    function Checkout()
    {
        global $db, $salesid, $user, $bid;

        extract($_POST);
        if ($total == 0) {
            header('location: ?');
        }
        $sql =  $db->query("INSERT INTO sales (customer,phone,total,discount,salesid,user,mode,bid) VALUES ('$customer','$phone','$total','$mydiscount','$salesid','$user','$mode','$bid') ");
        $db->query("UPDATE item SET status=2 WHERE salesid='$salesid' AND status=1");
        $sq = $db->query("SELECT * FROM customer WHERE bid='$bid' AND phone = '$phone' ");
        if (mysqli_num_rows($sq) == 0) {
            $sql2 =  $db->query("INSERT INTO customer (name,phone,bid) VALUES ('$customer','$phone','$bid') ");
            //echo 'Customer added successfully<br>';
        }

        if ($sql) {
            Alert('Successfully Submitted');
            unset($_SESSION['salesid']);
            $salesid = '';
        } else {
            Alert('Error Submitting data', 0);
        }
        return;
    }
    

    function AddProduct(){
        global $db, $productid;
        extract($_POST);

        $sql =  $db->query("INSERT INTO product (category,item,productid,qty,cost,sp) VALUES ('$category','$item','$productid','$qty','$cost','$sp')");
    
        if ($sql) {
            Alert('Successfully Added to Store');
            unset($_SESSION['productid']);
            $productid = '';
        } else {
            Alert('Error Submitting data', 0);
        }
    }
     
    // AddCategories
    // function AddCategories(){
    //     global $db, $description;
    //     extract($_POST);

    //     $sql =  $db->query("INSERT INTO categories (title,description) VALUES ('$title','$description')");
        
    //     if ($sql) {
    //         Alert('Successfully Added to Categories');

    //     } else {
    //         Alert('Error Submitting data', 0);
    //     }
      
    //     }

    function AddCategories() {
        global $db, $description;
        extract($_POST);
    
        $sql = $db->query("INSERT INTO categories (title,description) VALUES ('$title','$description')");
    
        if ($sql) {
            Alert('Successfully Added to Categories');
        } else {
            Alert('Error Submitting data', 0);
        }
    }
    
    function DeleteCategories($sn) {
        global $db;
    
        $sql = $db->query("DELETE FROM categories WHERE sn = '$sn'");
    
        if ($sql) {
            Alert('Successfully Deleted Category');
        } else {
            Alert('Error Deleting Category', 0);
        }
    }
    
    

    // clearAll Method

    function clearAll()
    {
        global $db, $salesid;
        $db->query("DELETE FROM item WHERE salesid ='$salesid'");
        return;
    }

    // Edit method

    function edit()
    {
        global $db, $sn;

        
        $sn = $_GET['edit'];
        $salesid = $_SESSION['salesid'] = $_GET['salesid'];
        $sql = $db->query("DELETE FROM sales WHERE sn='$sn' ");
        $db->query("UPDATE item SET status = 1 WHERE salesid='$salesid' AND status=2 ");
        if ($sql) { Alert('Successfully edited');
        } else { Alert('Error editing data',0);
        };

        header('location: ?');


        return;
    }

    // Delete Method

    function delete()
    {
        global $db, $sn;

        $sn =  $_GET["delete"];
        $sql = $db->query("UPDATE item SET status=0 WHERE sn = '$sn'");
        if ($sql) { //Alert('Successfully deleted');
        } else { //Alert('Error deleting data',0);
        };

        return;
    }

    function restore(){
        global $db, $sn;

        $sn =  $_GET["restore"];
        $sql = $db->query("UPDATE item SET status=1 WHERE sn = '$sn'");
        if ($sql) { //Alert('Successfully deleted');
        } else { //Alert('Error deleting data',0);
        };

        return;
    }

    // Register new user

    function RegisterUser()
    {
        global $db, $bid;
        extract($_POST);
        $password = md5($password);
        $sql =  $db->query("INSERT INTO user (name,phone,email,password,bid) VALUES ('$name','$phone','$email','$password','$bid') ");
        if ($sql) {
            Alert('Successfully Registered');
        } else {
            Alert('Error Submitting data', 0);
        };

        return;
    }

    // User Login Method

    function UserLogin()
    {
        global $db;
        //extract($_POST);
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        // $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $sql = $db->query("SELECT * FROM user WHERE email='$email' AND password='$password' ");
        if (mysqli_num_rows($sql) == 1) {
            $row = mysqli_fetch_assoc($sql);
            $_SESSION['user'] = $row['sn'];
            header('location: index.php');
            exit;
        } else {
            Alert('Error Submitting data', 0);
        }

        return;
    }

    // Update User Status Method

    function updateUserStatus()
    {
        global $db, $sn;

        $sn = $_GET['sn'];
        $status = $_GET['status'];
        if ($this->User($sn, 'admin') == 1) {
            $status = 1;
        }
        $sql = $db->query("UPDATE user SET status='$status' WHERE sn='$sn' ");
        header('location: ?');
        return;
    }

    // User Function

    function User($user, $opt = 'name')
    {
        global $db;
        $sql = $db->query("SELECT * FROM user WHERE sn = '$user' ");
        $row = mysqli_fetch_assoc($sql);
        return mysqli_num_rows($sql) == 1 ? $row[$opt] : '';
    }


    function sqL1($table, $key, $value) 
    {
        global $db;
        $sql = $db->query("SELECT * FROM $table WHERE $key = '$value' AND status=1");
        return mysqli_num_rows($sql);
    }



    function pedit()
    {
        global $db, $sn;

        $sn = $_GET['pedit'];
        $_SESSION["product"] = $_GET['productid'];
        $sql = $db->query("DELETE FROM product WHERE sn='$sn' ");
        header('location: ?');

        return;
    }

}


$sales = new Salesmaster;

//$salesid = $_SESSION['salesid']??'';
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    </script>
</body>
</html>
