<?php

session_start();

$mysqli = new mysqli('localhost', 'root', '123', 'top_shoe') or die(mysqli_error($mysqli));

$id = 0;
$update = false;
$name = '';
$brand = '';

if (isset($_GET['search'])){
    $id = $_GET['search'];
	$brand = $_GET['brand'];
	$name = $_GET['name'];
	$color = $_GET['color'];
	$update = true;
    $result = $mysqli->query("SELECT box_id AS box_id, shoe_id AS shoe_id, length AS length, width AS width, height AS height, weight AS weight FROM box_dimension WHERE 1;") or die($mysqli->error());
    while($data=mysqli_fetch_assoc($result)){
        $row = $result->fetch_array();
        $box_id = $row['box_id'];
        $shoe_id = $row['shoe_id'];
		$length = $row['length'];
		$width = $row['width'];
		$height = $row['height'];
		$weight = $row['weight'];
    };
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
	$box = $_POST['box'];
	$res4 = "";
	
	//find shoe id
	$result8 = $mysqli->query("SELECT DISTINCT shoe.id AS sid FROM shoe WHERE shoe.name = '$name' AND shoe.color = '$color' AND shoe.material = '$material' AND shoe.brand_id = '$brand';") or die($mysqli->error);
	while($data2=mysqli_fetch_assoc($result8)){
        $shoe_id=$data2['sid'];
    }
	
	$resultbn = $mysqli->query("SELECT length AS length, width AS width, height AS height, weight AS weight FROM box_dimension WHERE box_dimension.shoe_id = '$shoe_id' AND box_dimension.box_id = $box;") or die($mysqli->error);
	
	while($test=mysqli_fetch_assoc($resultbn)){ 
			$res4.="".$test['length'].",".$test['width'].",".$test['height'].",".$test['weight']."";

    }
	echo $res4;

}

?>

