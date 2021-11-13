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

if (isset($_POST['brand4'])){
	$brand = $_POST['brand4'];
	$name = $_POST['name3'];
	$color = $_POST['color2'];
	$material = $_POST['material1'];

	$divStr = "<table class=\"table table-hover table-bordered\"><tr><th>box</th><th>quantity</th><th></th></tr>";
	
	//find shoe id
	$result10 = $mysqli->query("SELECT DISTINCT shoe.id AS sid FROM shoe WHERE shoe.name = '$name' AND shoe.color = '$color' AND shoe.material = '$material' AND shoe.brand_id = '$brand';") or die($mysqli->error);
	while($data2=mysqli_fetch_assoc($result10)){
		$shoe_id=$data2['sid'];
	}
	
	//find boxes
	$result11 = $mysqli->query("SELECT * FROM box WHERE box.brand_id = '$brand';") or die($mysqli->error);
	while ($boxes = $result11->fetch_assoc()){ 
		$box_id = $boxes['id'];
		
		//find quantity of purchase
		$pquantity = $mysqli->query("SELECT SUM(quantity) AS psum FROM purchase WHERE purchase.shoe_id = '$shoe_id' AND purchase.box_id = '$box_id';") or die($mysqli->error);
		while($data3=mysqli_fetch_assoc($pquantity)){

			//find quantity of sell
			$squantity = $mysqli->query("SELECT SUM(quantity) AS ssum FROM sell WHERE sell.shoe_id = '$shoe_id' AND sell.box_id = '$box_id';") or die($mysqli->error);
			while($data4=mysqli_fetch_assoc($squantity)){
				
				//find quantity of revise
				$rquantity = $mysqli->query("SELECT SUM(quantity) AS rsum FROM inventory_revise WHERE inventory_revise.shoe_id = '$shoe_id' AND inventory_revise.box_id = '$box_id';") or die($mysqli->error);
				while($data5=mysqli_fetch_assoc($rquantity)){
					$psum=$data3['psum'];
					$ssum=$data4['ssum'];
					$rsum=$data5['rsum'];
					$sum = $psum - $ssum + $rsum;
					//$editbtn = "<input type=\"button\" value=\"EDIT\" class=\"btn btn-info\" id=\"$box_id\" onclick=\"editclick(this.id)\">";
					$editbtn = "<button class=\"saveChanges\" id=\"$box_id\" onclick=\"editclick(this.id)\">ADD</button>";
					$detailbtn = "<input type=\"button\" value=\"VIEW\" class=\"btn btn-info\" id=\"$box_id\" onclick=\"detailclick(this.id)\">";

					if ($sum  == 0) {
						$divStr = $divStr . "<tr><td>" . $boxes['name'] . "</td><td id =\"myText\" contenteditable=\"true\">" .  '0' . "</td><td>" .  $editbtn . $detailbtn . "</td></tr>";
					} else {
						$divStr = $divStr . "<tr><td>" . $boxes['name'] . "</td><td id =\"myText\" contenteditable=\"true\">" .  $sum . "</td><td>" .  $editbtn . $detailbtn . "</td></tr>";
						
					}
				}
			}
		}
	}
	$divStr = $divStr . "</table>";
	$test = "HEYYY";
	$divStr2 = array();
	$divStr2['divStr'] = $divStr;
	$divStr2['test'] = $test;
	echo json_encode($divStr2);
}

if (isset($_POST['clicked_id'])){
	$brand = $_POST['brand5'];
	$name = $_POST['name4'];
	$color = $_POST['color3'];
	$material = $_POST['material2'];
	$clicked_id =  $_POST['clicked_id'];//box_id
	$divStr1 = "<table class=\"table table-hover table-bordered\"><tr><th>active</th><th>date</th><th>quantity</th></tr>";
	
	//find shoe id
	$result10 = $mysqli->query("SELECT DISTINCT shoe.id AS sid FROM shoe WHERE shoe.name = '$name' AND shoe.color = '$color' AND shoe.material = '$material' AND shoe.brand_id = '$brand';") or die($mysqli->error);
	while($datashoe=mysqli_fetch_assoc($result10)){
		$shoe_id=$datashoe['sid'];
	}
	
	//find quantity of purchase
	$pinventory = $mysqli->query("SELECT * FROM purchase WHERE purchase.shoe_id = '$shoe_id' AND purchase.box_id = '$clicked_id';") or die($mysqli->error);
	while($data3=mysqli_fetch_assoc($pinventory)){
		//find date
		$purdate = $data3['purchase_id'];
		$result11 = $mysqli->query("SELECT DISTINCT purchase_date.date AS date FROM purchase_date WHERE purchase_date.id = $purdate;") or die($mysqli->error);
		while($datadate=mysqli_fetch_assoc($result11)){
			$pdate=$datadate['date'];
		}
		$divStr1 = $divStr1 . "<tr><td>" . 'purchase' . "</td><td>" .  $pdate . "</td><td>" .  $data3['quantity'] . "</td></tr>";
	}	

	//find quantity of sell
	$sinventory = $mysqli->query("SELECT * FROM sell WHERE sell.shoe_id = '$shoe_id' AND sell.box_id = '$clicked_id';") or die($mysqli->error);
	while($datasell=mysqli_fetch_assoc($sinventory)){
		//find date
		$selldate = $datasell['sell_id'];
		$result12 = $mysqli->query("SELECT DISTINCT sell_date.date AS sdate FROM sell_date WHERE sell_date.id = $selldate;") or die($mysqli->error);
		while($datadate=mysqli_fetch_assoc($result12)){
			$sdate=$datadate['sdate'];
		}
		$divStr1 = $divStr1 . "<tr><td>" . 'sell' . "</td><td>" .  $sdate . "</td><td>" .  $datasell['quantity'] . "</td></tr>";
	}	

	//find revise of sell
	$rinventory = $mysqli->query("SELECT * FROM inventory_revise WHERE inventory_revise.shoe_id = '$shoe_id' AND inventory_revise.box_id = '$clicked_id';") or die($mysqli->error);
	while($datarev=mysqli_fetch_assoc($rinventory)){
		//find date
		$revdate = $datarev['revise_id'];
		$result13 = $mysqli->query("SELECT DISTINCT inventory_revise_date.date AS rdate FROM inventory_revise_date WHERE inventory_revise_date.id = $revdate;") or die($mysqli->error);
		while($datadate=mysqli_fetch_assoc($result13)){
			$rdate=$datadate['rdate'];
		}
		$divStr1 = $divStr1 . "<tr><td>" . 'revise' . "</td><td>" .  $rdate . "</td><td>" .  $datarev['quantity'] . "</td></tr>";
	}	
	
	$divStr1 = $divStr1 . "</table>";
	echo $divStr1;
}

if (isset($_POST['content'])){
	$brand = $_POST['brand6'];
	$name = $_POST['name5'];
	$color = $_POST['color4'];
	$material = $_POST['material3'];
	$box = $_POST['box'];
	$content = $_POST['content'];
	$rquantity = "";
	$sum = "";
	//find shoe id
	$result10 = $mysqli->query("SELECT DISTINCT shoe.id AS sid FROM shoe WHERE shoe.name = '$name' AND shoe.color = '$color' AND shoe.material = '$material' AND shoe.brand_id = '$brand';") or die($mysqli->error);
	while($datashoe=mysqli_fetch_assoc($result10)){
		$shoe_id=$datashoe['sid'];
	}
	
	//find quantity of purchase
	$pquantity = $mysqli->query("SELECT SUM(quantity) AS psum FROM purchase WHERE purchase.shoe_id = '$shoe_id' AND purchase.box_id = '$box';") or die($mysqli->error);
	while($data3=mysqli_fetch_assoc($pquantity)){
		//find quantity of sell
		$squantity = $mysqli->query("SELECT SUM(quantity) AS ssum FROM sell WHERE sell.shoe_id = '$shoe_id' AND sell.box_id = '$box';") or die($mysqli->error);
		while($data4=mysqli_fetch_assoc($squantity)){
			//find quantity of revise
			$rquantity = $mysqli->query("SELECT SUM(quantity) AS rsum FROM inventory_revise WHERE inventory_revise.shoe_id = '$shoe_id' AND inventory_revise.box_id = '$box';") or die($mysqli->error);
			while($data5=mysqli_fetch_assoc($rquantity)){
				$psum=$data3['psum'];
				$ssum=$data4['ssum'];
				$rsum=$data5['rsum'];
				$sum = $psum - $ssum + $rsum;
			}
		}
	}
	$rquantity = $content - $sum;
	
	//get today's day
	$date = date("Y-m-d");
	
	//find if data in inventory_revise_date
	$res4="test";
	$resultdate = $mysqli->query("SELECT * FROM inventory_revise_date WHERE inventory_revise_date.date = '$date' AND inventory_revise_date.brand_id = '$brand';") or die($mysqli->error);
	while($datad=mysqli_fetch_assoc($resultdate)){
        $res4=$datad['id'];
    }
	
    if($res4=="test"){
		$resultre = $mysqli->query("INSERT INTO inventory_revise_date (date, brand_id) VALUES ('$date', '$brand');") or die($mysqli->error);
		if($resultre==true){
			$resultrev = $mysqli->query("SELECT * FROM inventory_revise_date WHERE inventory_revise_date.date = '$date' AND inventory_revise_date.brand_id = '$brand';") or die($mysqli->error);
			while($datarev=mysqli_fetch_assoc($resultrev)){
				$res4=$datarev['id'];
			}
		}		
		else{
			echo  "Error: " . $resultre;
		};
    };
	
	//insert data to rev, employee set 1
	$resultnr = $mysqli->query("INSERT INTO inventory_revise (revise_id, box_id, shoe_id, quantity, employ_id) VALUES ('$res4', '$box', '$shoe_id', '$rquantity', '1');") or die($mysqli->error);
	
	//insert data
	
	
	
	echo $resultnr;
}
?>
