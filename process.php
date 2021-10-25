<?php

session_start();

$mysqli = new mysqli('localhost', 'root', '123', 'top_shoe') or die(mysqli_error($mysqli));

$id = 0;
$update = false;
$name = '';
$brand = '';

if (isset($_POST['save'])){
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    
    $mysqli->query("INSERT INTO data (name, brand) VALUES('$name', '$brand')") or
            die($mysqli->error);
        
    $_SESSION['message'] = "Record has been saved!";
    $_SESSION['msg_type'] = "success";
    
    header("brand: index.php");
    
}

if (isset($_GET['delete'])){
    $id = $_GET['delete'];
    $mysqli->query("DELETE FROM data WHERE id=$id") or die($mysqli->error());
    
    $_SESSION['message'] = "Record has been deleted!";
    $_SESSION['msg_type'] = "danger";
    
    header("brand: index.php");
}

if (isset($_GET['edit'])){
    $id = $_GET['edit'];
    $update = true;
    $result = $mysqli->query("SELECT * FROM data WHERE id=$id") or die($mysqli->error());
    if (count($result)==1){
        $row = $result->fetch_array();
        $name = $row['name'];
        $brand = $row['brand'];
    }
}

if (isset($_POST['update'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    
    $mysqli->query("UPDATE data SET name='$name', brand='$brand' WHERE id=$id") or
            die($mysqli->error);
    
    $_SESSION['message'] = "Record has been updated!";
    $_SESSION['msg_type'] = "warning";
    
    header('brand: index.php');
}
	
if (isset($_POST['brand'])){
	$brand = $_POST['brand'];
	$result1 = $mysqli->query("SELECT DISTINCT shoe.name AS name FROM shoe WHERE shoe.brand_id = '$brand';") or die($mysqli->error);

	$res = "";//把準備回傳的變數res準備好
	while($data=mysqli_fetch_assoc($result1)){
	   $res .= "
			<option value='{$data["name"]}'>{$data['name']}</option>
	   ";//將對應的型號項目遞迴列出
	};
	echo $res;//將型號項目丟回給ajax
}

if (isset($_POST['name'])){
	$brand = $_POST['brand1'];
	$name = $_POST['name'];
	$result2 = $mysqli->query("SELECT DISTINCT shoe.color AS color FROM shoe WHERE shoe.name = '$name' AND shoe.brand_id = '$brand';") or die($mysqli->error);

	$res1 = "";//把準備回傳的變數res準備好
	while($data=mysqli_fetch_assoc($result2)){
	   $res1 .= "
		  <option value='{$data["color"]}'>{$data['color']}</option>
	   ";//將對應的型號項目遞迴列出
	};
	echo $res1;//將型號項目丟回給ajax
}

if (isset($_POST['color'])){
	$brand = $_POST['brand2'];
	$name = $_POST['name1'];
	$color = $_POST['color'];
	$result3 = $mysqli->query("SELECT DISTINCT shoe.material AS material FROM shoe WHERE shoe.brand_id = '$brand' AND shoe.name = '$name' AND shoe.color = '$color';") or die($mysqli->error);

	$res2 = "";//把準備回傳的變數res準備好
	while($data=mysqli_fetch_assoc($result3)){
	   $res2 .= "
		  <option value='{$data["material"]}'>{$data['material']}</option>
	   ";//將對應的型號項目遞迴列出
	};
	echo $res2;//將型號項目丟回給ajax
}

if (isset($_POST['material'])){
	$brand = $_POST['brand3'];
	$name = $_POST['name2'];
	$color = $_POST['color1'];
	$material = $_POST['material'];
	$result4 = $mysqli->query("SELECT DISTINCT box.id AS boxid, box.name AS box FROM box WHERE box.brand_id = '$brand';") or die($mysqli->error);

	$res3 = "";//把準備回傳的變數res準備好
	while($data=mysqli_fetch_assoc($result4)){
	   $res3 .= "
		  <option value='{$data["boxid"]}'>{$data['box']}</option>
	   ";//將對應的型號項目遞迴列出
	};
	echo $res3;//將型號項目丟回給ajax
}

if (isset($_POST['brand4'])){
	$brand = $_POST['brand4'];
	$name = $_POST['name3'];
	$color = $_POST['color2'];
	$material = $_POST['material1'];
	$quantity = $_POST['quantity'];
	$price = $_POST['price'];
	$purchasedate = $_POST['purchasedate'];
	$result5 = $mysqli->query("SELECT purchase_date.id AS pid FROM purchase_date WHERE purchase_date.date = '$purchasedate' AND purchase_date.brand_id = '$brand';") or die($mysqli->error);
	


	$res4 = "test";//把準備回傳的變數res準備好
	while($data=mysqli_fetch_assoc($result5)){
	   $res4 .= "
		 {$data["pid"]} /　
	   ";//將對應的型號項目遞迴列出
	};
	echo $res4;//將型號項目丟回給ajax
}
?>

