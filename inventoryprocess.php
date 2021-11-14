<?php
session_start();
$mysqli = new mysqli('localhost', 'root', '123', 'top_shoe') or die(mysqli_error($mysqli));

if (isset($_POST['brand'])){
	$brand = $_POST['brand'];
	$shoe_name = $mysqli->query("SELECT DISTINCT shoe.name AS name FROM shoe WHERE shoe.brand_id = '$brand';") or die($mysqli->error);
	$s_name = "";
	while($sname=mysqli_fetch_assoc($shoe_name)){
	   $s_name .= "
			<option value='{$sname["name"]}'>{$sname['name']}</option>
	   ";
	};
	echo $s_name;
}

if (isset($_POST['name'])){
	$brand = $_POST['brand1'];
	$name = $_POST['name'];
	$shoe_color = $mysqli->query("SELECT DISTINCT shoe.color AS color FROM shoe WHERE shoe.name = '$name' AND shoe.brand_id = '$brand';") or die($mysqli->error);
	$s_color = "";
	while($scolor=mysqli_fetch_assoc($shoe_color)){
	   $s_color .= "
		  <option value='{$scolor["color"]}'>{$scolor['color']}</option>
	   ";
	};
	echo $s_color;
}

if (isset($_POST['color'])){
	$brand = $_POST['brand2'];
	$name = $_POST['name1'];
	$color = $_POST['color'];
	$shoe_material = $mysqli->query("SELECT DISTINCT shoe.material AS material FROM shoe WHERE shoe.brand_id = '$brand' AND shoe.name = '$name' AND shoe.color = '$color';") or die($mysqli->error);
	$s_material = "";
	while($smaterial=mysqli_fetch_assoc($shoe_material)){
	   $s_material .= "
		  <option value='{$smaterial["material"]}'>{$smaterial['material']}</option>
	   ";
	};
	echo $s_material;
}

if (isset($_POST['brand3'])){
	$brand = $_POST['brand3'];
	$name = $_POST['name2'];
	$color = $_POST['color1'];
	$material = $_POST['material'];
	$divStr = "<table class=\"table table-hover table-bordered\"><tr><th>box</th><th>quantity</th><th></th></tr>";
	
	//find shoe id
	$shie_id = $mysqli->query("SELECT DISTINCT shoe.id AS sid FROM shoe WHERE shoe.name = '$name' AND shoe.color = '$color' AND shoe.material = '$material' AND shoe.brand_id = '$brand';") or die($mysqli->error);
	while($sid=mysqli_fetch_assoc($shie_id)){
		$shoe_id=$sid['sid'];
	}
	
	//find boxes
	$box = $mysqli->query("SELECT * FROM box WHERE box.brand_id = '$brand';") or die($mysqli->error);
	while ($boxes = $box->fetch_assoc()){ 
		$box_id = $boxes['id'];
		//find quantity of purchase
		$pquantity = $mysqli->query("SELECT SUM(quantity) AS psum FROM purchase WHERE purchase.shoe_id = '$shoe_id' AND purchase.box_id = '$box_id';") or die($mysqli->error);
		while($pq=mysqli_fetch_assoc($pquantity)){
			//find quantity of sell
			$squantity = $mysqli->query("SELECT SUM(quantity) AS ssum FROM sell WHERE sell.shoe_id = '$shoe_id' AND sell.box_id = '$box_id';") or die($mysqli->error);
			while($sq=mysqli_fetch_assoc($squantity)){
				//find quantity of revise
				$rquantity = $mysqli->query("SELECT SUM(quantity) AS rsum FROM inventory_revise WHERE inventory_revise.shoe_id = '$shoe_id' AND inventory_revise.box_id = '$box_id';") or die($mysqli->error);
				while($rq=mysqli_fetch_assoc($rquantity)){
					$psum=$pq['psum'];
					$ssum=$sq['ssum'];
					$rsum=$rq['rsum'];
					$sum = $psum - $ssum + $rsum;
					/*$editbtn = "<input type=\"button\" value=\"EDIT\" class=\"btn btn-info\" id=\"$box_id\" onclick=\"editclick(this.id)\">";
					//$editbtn = "<button class=\"saveChanges\" id=\"$box_id\" onclick=\"editclick(this.id\")\">ADD</button>";
					$detailbtn = "<input type=\"button\" value=\"VIEW\" class=\"btn btn-info\" id=\"$box_id\" onclick=\"detailclick(this.id)\">";

					if ($sum  == 0) {
						$divStr = $divStr . "<tr><td>" . $boxes['name'] . "</td><td id =\"myText\" contenteditable=\"true\">" .  '0' . "</td><td>" .  $editbtn . $detailbtn . "</td></tr>";
					} else {
						$divStr = $divStr . "<tr><td>" . $boxes['name'] . "</td><td id =\"myText\" contenteditable=\"true\">" .  $sum . "</td><td>" .  $editbtn . $detailbtn . "</td></tr>";
					}*/
					$editbtn = "<button class=\"saveChanges\" id=\"$box_id\" onclick=\"editclick(this.id\")\">ADD</button>";
					$detailbtn = "<input type=\"button\" value=\"VIEW\" class=\"btn btn-info\" id=\"$box_id\" onclick=\"detailclick(this.id)\">";
					if ($sum  == 0) {
						$divStr = $divStr . "<tr><td>" . $boxes['name'] . "</td><td contenteditable=\"true\">" .  '0' . "</td><td>" .  $editbtn . $detailbtn . "</td></tr>";
					} else {
						$divStr = $divStr . "<tr><td>" . $boxes['name'] . "</td><td contenteditable=\"true\">" .  $sum . "</td><td>" .  $editbtn . $detailbtn . "</td></tr>";
					}
				}
			}
		}
	}
	$divStr = $divStr . "</table>";
	echo $divStr;
}

if (isset($_POST['brand4'])){
	$brand = $_POST['brand4'];
	$name = $_POST['name3'];
	$color = $_POST['color2'];
	$material = $_POST['material1'];
	$box = $_POST['box'];
	$content = $_POST['content'];
	$sum1 = 0;
	
	//find shoe id
	$shie_id1 = $mysqli->query("SELECT DISTINCT shoe.id AS sid FROM shoe WHERE shoe.name = '$name' AND shoe.color = '$color' AND shoe.material = '$material' AND shoe.brand_id = '$brand';") or die($mysqli->error);
	while($sid1=mysqli_fetch_assoc($shie_id1)){
		$shoe_id1=$sid1['sid'];
	}
	
	//find box id
	$boxid = $mysqli->query("SELECT DISTINCT box.id AS bid FROM box WHERE box.name = '$box' AND box.brand_id = '$brand';") or die($mysqli->error);
	while($bid1=mysqli_fetch_assoc($boxid)){
		$box_id=$bid1['bid'];
	}
	
	//find quantity of purchase
	$pquantity1 = $mysqli->query("SELECT SUM(quantity) AS psum FROM purchase WHERE purchase.shoe_id = '$shoe_id1' AND purchase.box_id = '$box_id';") or die($mysqli->error);
	while($pq1=mysqli_fetch_assoc($pquantity1)){
		//find quantity of sell
		$squantity1 = $mysqli->query("SELECT SUM(quantity) AS ssum FROM sell WHERE sell.shoe_id = '$shoe_id1' AND sell.box_id = '$box_id';") or die($mysqli->error);
		while($sq1=mysqli_fetch_assoc($squantity1)){
			//find quantity of revise
			$rquantity1 = $mysqli->query("SELECT SUM(quantity) AS rsum FROM inventory_revise WHERE inventory_revise.shoe_id = '$shoe_id1' AND inventory_revise.box_id = '$box_id';") or die($mysqli->error);
			while($rq1=mysqli_fetch_assoc($rquantity1)){
				$psum1=$pq1['psum'];
				$ssum1=$sq1['ssum'];
				$rsum1=$rq1['rsum'];
				$sum1 = $psum1 - $ssum1 + $rsum1;
			}
		}
	}
	
	//get today's day
	$date = date("Y-m-d");
	
	//find if data in inventory_revise_date
	$redate="test";
	$re_date = $mysqli->query("SELECT * FROM inventory_revise_date WHERE inventory_revise_date.date = '$date' AND inventory_revise_date.brand_id = '$brand';") or die($mysqli->error);
	while($rdate=mysqli_fetch_assoc($re_date)){
        $redate=$rdate['id'];
    }
	
    if($redate=="test"){
		$resultre = $mysqli->query("INSERT INTO inventory_revise_date (date, brand_id) VALUES ('$date', '$brand');") or die($mysqli->error);
		if($resultre==true){
			$resultrev = $mysqli->query("SELECT * FROM inventory_revise_date WHERE inventory_revise_date.date = '$date' AND inventory_revise_date.brand_id = '$brand';") or die($mysqli->error);
			while($datarev=mysqli_fetch_assoc($resultrev)){
				$redate=$datarev['id'];
			}
		}		
    };
	
	$fquantity = $content - $sum1;
	
	//insert data to rev, employee set 1
	$resultnr = $mysqli->query("INSERT INTO inventory_revise (revise_id, box_id, shoe_id, quantity, employ_id) VALUES ('$redate', '$box_id', '$shoe_id1', '$fquantity', '1');") or die($mysqli->error);
	
	if ($mysqli->query($resultnr) == TRUE) {
	  echo $fquantity;
	} else {
	  echo $fquantity;
	}
}

if (isset($_POST['brand5'])){
	$brand = $_POST['brand5'];
	$name = $_POST['name4'];
	$color = $_POST['color3'];
	$material = $_POST['material2'];
	$box = $_POST['box1'];
	$divStr1 = "<table class=\"table table-hover table-bordered\"><tr><th>active</th><th>date</th><th>quantity</th></tr>";
	
	//find shoe id
	$shie_id2 = $mysqli->query("SELECT DISTINCT shoe.id AS sid FROM shoe WHERE shoe.name = '$name' AND shoe.color = '$color' AND shoe.material = '$material' AND shoe.brand_id = '$brand';") or die($mysqli->error);
	while($sid2=mysqli_fetch_assoc($shie_id2)){
		$shoe_id2=$sid2['sid'];
	}
	
	//find quantity of purchase
	$pquantity2 = $mysqli->query("SELECT * FROM purchase WHERE purchase.shoe_id = '$shoe_id2' AND purchase.box_id = '$box';") or die($mysqli->error);
	while($pq2=mysqli_fetch_assoc($pquantity2)){
		//find date
		$purdateid = $pq2['purchase_id'];
		$purdate = $mysqli->query("SELECT DISTINCT purchase_date.date AS pdate FROM purchase_date WHERE purchase_date.id = $purdateid;") or die($mysqli->error);
		while($pudate=mysqli_fetch_assoc($purdate)){
			$pdate=$pudate['pdate'];
		}
		$divStr1 = $divStr1 . "<tr><td>" . 'purchase' . "</td><td>" .  $pdate . "</td><td>" .  $pq2['quantity'] . "</td></tr>";
	}	

	//find quantity of sell
	$squantity2 = $mysqli->query("SELECT * FROM sell WHERE sell.shoe_id = '$shoe_id2' AND sell.box_id = '$box';") or die($mysqli->error);
	while($sq2=mysqli_fetch_assoc($squantity2)){
		//find date
		$selldateid = $sq2['sell_id'];
		$selldate = $mysqli->query("SELECT DISTINCT sell_date.date AS sdate FROM sell_date WHERE sell_date.id = $selldateid;") or die($mysqli->error);
		while($sedate=mysqli_fetch_assoc($selldate)){
			$sdate=$sedate['sdate'];
		}
		$divStr1 = $divStr1 . "<tr><td>" . 'sell' . "</td><td>" .  $sdate . "</td><td>" .  $sq2['quantity'] . "</td></tr>";
	}	

	//find revise of sell
	$rquantity2 = $mysqli->query("SELECT * FROM inventory_revise WHERE inventory_revise.shoe_id = '$shoe_id2' AND inventory_revise.box_id = '$box';") or die($mysqli->error);
	while($rq2=mysqli_fetch_assoc($rquantity2)){
		//find date
		$revdateid = $rq2['revise_id'];
		$revdate = $mysqli->query("SELECT DISTINCT inventory_revise_date.date AS rdate FROM inventory_revise_date WHERE inventory_revise_date.id = $revdateid;") or die($mysqli->error);
		while($redate=mysqli_fetch_assoc($revdate)){
			$rdate=$redate['rdate'];
		}
		$divStr1 = $divStr1 . "<tr><td>" . 'revise' . "</td><td>" .  $rdate . "</td><td>" .  $rq2['quantity'] . "</td></tr>";
	}	
	
	$divStr1 = $divStr1 . "</table>";
	echo $divStr1;
}
?>
