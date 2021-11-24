<?php

session_start();
$mysqli = new mysqli('localhost', 'root', '123', 'top_shoe') or die(mysqli_error($mysqli));


	
if (isset($_POST['brand'])){
	$brand = $_POST['brand'];
	$shoe_name = $mysqli->query("SELECT DISTINCT shoe.name AS name FROM shoe WHERE shoe.brand_id = '$brand';") or die($mysqli->error);

	$shoename = "";
	while($data=mysqli_fetch_assoc($shoe_name)){
	   $shoename .= "
			<option value='{$data["name"]}'>{$data['name']}</option>
	   ";
	};
	echo $shoename;
}

if (isset($_POST['name'])){
	$brand = $_POST['brand1'];
	$name = $_POST['name'];
	$shoe_color = $mysqli->query("SELECT DISTINCT shoe.color AS color FROM shoe WHERE shoe.name = '$name' AND shoe.brand_id = '$brand';") or die($mysqli->error);

	$shoecolor = "";
	while($data1=mysqli_fetch_assoc($shoe_color)){
	   $shoecolor .= "
		  <option value='{$data1["color"]}'>{$data1['color']}</option>
	   ";
	};
	echo $shoecolor;
}

if (isset($_POST['color'])){
	$brand = $_POST['brand2'];
	$name = $_POST['name1'];
	$color = $_POST['color'];
	$shoe_material = $mysqli->query("SELECT DISTINCT shoe.material AS material FROM shoe WHERE shoe.brand_id = '$brand' AND shoe.name = '$name' AND shoe.color = '$color';") or die($mysqli->error);

	$shoematerial = "";
	while($data2=mysqli_fetch_assoc($shoe_material)){
	   $shoematerial .= "
		  <option value='{$data2["material"]}'>{$data2['material']}</option>
	   ";
	};
	echo $shoematerial;
}

//display info
if (isset($_POST['material'])){
	$brand = $_POST['brand3'];
	$name = $_POST['name2'];
	$color = $_POST['color1'];
	$material = $_POST['material'];
	$shoe_id = 0;
	$search_shoe1 = $mysqli->query("SELECT DISTINCT shoe.id AS sid FROM shoe WHERE shoe.name = '$name' AND shoe.brand_id = '$brand' AND shoe.color = '$color' AND shoe.material = '$material';") or die($mysqli->error);
	while($data2=mysqli_fetch_assoc($search_shoe1)){
		$shoe_id = $data2['sid'];
	}	
	
	//shoe_dimensino_table
	$divStr = "<table id=\"shoetable\" class=\"table table-hover table-bordered table-condensed table-striped\"><tr><th>size</th><th>length</th><th>width</th><th>height</th><th>weight</th><th></th></tr>";
	$dimension = $mysqli->query("SELECT * FROM shoe_dimension WHERE shoe_dimension.shoe_id = '$shoe_id';") or die($mysqli->error);
	$dimension->fetch_assoc();
	
	while ($row = $dimension->fetch_assoc()){
		$size = $row['size'];
		$length = $row['length'];
		$width = $row['width'];
		$height = $row['height'];
		$weight = $row['weight'];
		$editbtn = "<button class=\"saveChanges\" id=\"$size\" onclick=\"editclick(this);\">UPDATE</button>";
		$divStr = $divStr . "<tr id\"$size\"><td>" . $size . "</td><td contenteditable=\"true\">" .  $length . "</td><td contenteditable=\"true\">" .  $width . "</td><td contenteditable=\"true\">" .  $height . "</td><td contenteditable=\"true\">" .  $weight . "</td><td>" .  $editbtn . "</td></tr>";
	}
	$divStr = $divStr . "</table>";
	
	//box_dimensino_table
	$divStr1 = "<table id=\"boxtable\" class=\"table table-hover table-bordered table-condensed table-striped\"><tr><th>box</th><th>length</th><th>width</th><th>height</th><th>weight</th><th></th></tr>";
	$dimension1 = $mysqli->query("SELECT * FROM box_dimension WHERE box_dimension.shoe_id = '$shoe_id';") or die($mysqli->error);
	
	while ($row1 = $dimension1->fetch_assoc()){
		$box = $row1['box_id'];
		$length = $row1['length'];
		$width = $row1['width'];
		$height = $row1['height'];
		$weight = $row1['weight'];
		$editbtn = "<button class=\"hasChanges\" id=\"$box\" onclick=\"editclick(this.id)\">UPDATE</button>";
		
		$boxname = $mysqli->query("SELECT DISTINCT box.name AS bname FROM box WHERE box.id = '$box';") or die($mysqli->error);
		while ($row2 = $boxname->fetch_assoc()){
			$box_name = $row2['bname'];
		}
		$divStr1 = $divStr1 . "<tr><td>" . $box_name . "</td><td contenteditable=\"true\">" .  $length . "</td><td contenteditable=\"true\">" .  $width . "</td><td contenteditable=\"true\">" .  $height . "</td><td contenteditable=\"true\">" .  $weight . "</td><td>" .  $editbtn . "</td></tr>";
	}
	$divStr1 = $divStr1 . "</table>";
	
	$divStr2 = "
	<div>
		<h3> Select File To Upload </h3>
		<form method='post' action='' enctype='multipart/form-data'>
			<input type='file' name='image' ><br>
			<input type=\"hidden\" id=\"shoe_id\" name=\"shoe_id\" value=\"". $shoe_id ."\">
			<input type='submit' value='Upload Image' name='upload'>  
		</form>
	<div class=\"row\">
	<table border=\"2\">
		<tr>
			<td>No.</td>
			<td>Images</td>
		</tr>";
	$no = 1;
	$records = mysqli_query($mysqli,"select * from photo WHERE photo.shoe_id = $shoe_id "); 
	while($data3 = mysqli_fetch_array($records)){
		$path = "image/" . $data3['image'];
		
		$photo = "<img style=\"max-height: 400px ;max-width: 500px\" src= '" . $path . "' >";
		$divStr2 = $divStr2 . "<tr><td>" . $no . "</td><td>" . $photo . "</td></tr>";
		$no++;
	}
	$divStr2 = $divStr2 . "</table></div>";
	

	echo json_encode(array($divStr, $divStr1, $divStr2, $shoe_id));
}

//update shoe_dimension
if (isset($_POST['size'])){
	$brand = $_POST['brand4'];
	$name = $_POST['name3'];
	$color = $_POST['color2'];
	$material = $_POST['material1'];
	$size = $_POST['size'];
	$length = $_POST['length'];
	$width = $_POST['width'];
	$height = $_POST['height'];
	$weight = $_POST['weight'];
	$result = "FAIL!";
	//find shoe id
	$search_shoe2 = $mysqli->query("SELECT DISTINCT shoe.id AS sid FROM shoe WHERE shoe.name = '$name' AND shoe.color = '$color' AND shoe.material = '$material' AND shoe.brand_id = '$brand';") or die($mysqli->error);
	while($data4=mysqli_fetch_assoc($search_shoe2)){
        $shoe_id1=$data4['sid'];
    }
	
	$update_dimension = $mysqli->query("UPDATE shoe_dimension SET shoe_dimension.length = '$length', shoe_dimension.width = '$width', shoe_dimension.height = '$height', shoe_dimension.weight = '$weight' WHERE shoe_dimension.shoe_id = '$shoe_id1' AND shoe_dimension.size = '$size';") or die($mysqli->error);
	if($update_dimension==true){
		$result = "UPDATE SUCCESS!";
	}
	echo $result;
}





?>
