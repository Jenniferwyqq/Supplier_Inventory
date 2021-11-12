<?php

session_start();

$mysqli = new mysqli('localhost', 'root', '123', 'top_shoe') or die(mysqli_error($mysqli));
	
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
	$quantity = $_POST['quantity'];
	$selldate = $_POST['selldate'];
	$res4 = "test";//把準備回傳的變數res準備好
	
	$divStr = "<table class=\"table\"><tr><th>brand</th><th>style</th><th>color</th><th>material</th><th>box</th><th>quantity</th><th>status</th></tr>";
	
	//brand name
	$brandname = $mysqli->query("SELECT brand.name AS brn FROM brand WHERE brand.id = '$brand';") or die($mysqli->error);
	while($databrand=mysqli_fetch_assoc($brandname)){
        $brname=$databrand['brn'];
    }
	
	//brand name
	$boxname = $mysqli->query("SELECT box.name AS bn FROM box WHERE box.id = '$box';") or die($mysqli->error);
	while($databox=mysqli_fetch_assoc($boxname)){
        $bname=$databox['bn'];
    }
	
	$result5 = $mysqli->query("SELECT DISTINCT sell_date.id AS seid FROM sell_date WHERE sell_date.date = '$selldate' AND sell_date.brand_id = '$brand';") or die($mysqli->error);
	
	while($data=mysqli_fetch_assoc($result5)){
        $res4=$data['seid'];
    }
	
	//find if data in sell_date
    if($res4=="test"){
		$result6 = $mysqli->query("INSERT INTO sell_date (date, brand_id) VALUES ('$selldate', '$brand');") or die($mysqli->error);
		if($result6==true){
			$result7 = $mysqli->query("SELECT DISTINCT sell_date.id AS seid FROM sell_date WHERE sell_date.date = '$selldate' AND sell_date.brand_id = '$brand';") or die($mysqli->error);
			while($data1=mysqli_fetch_assoc($result7)){
				$res4=$data1['seid'];
			}
		}		
		else{
			echo  "Error: " . $result6;
		};
    };
	
	//find shoe id
	$result8 = $mysqli->query("SELECT DISTINCT shoe.id AS sid FROM shoe WHERE shoe.name = '$name' AND shoe.color = '$color' AND shoe.material = '$material' AND shoe.brand_id = '$brand';") or die($mysqli->error);
	
	while($data2=mysqli_fetch_assoc($result8)){
        $shoe_id=$data2['sid'];
    }
	

	
	//insert data to sell, employee set 1
	$result9 = $mysqli->query("INSERT INTO sell (sell_id, box_id, shoe_id, quantity, employ_id) VALUES ('$res4', '$box', '$shoe_id', '$quantity', '1');") or die($mysqli->error);

	$divStr = $divStr . "<tr><td>" . $brname . "</td><td>" .  $name . "</td><td>" . $color . "</td><td>" . $material . "</td><td>" . $bname . "</td><td>" . $quantity . "</td><td>" . "updated success!" . "</td></tr>";

	$divStr = $divStr . "</table>";
	echo $divStr;
}
?>
