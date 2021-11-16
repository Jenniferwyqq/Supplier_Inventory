<?php

session_start();
$mysqli = new mysqli('localhost', 'root', '123', 'top_shoe') or die(mysqli_error($mysqli));

if (isset($_POST['brand'])){
    $brand = $_POST['brand'];
	$name = $_POST['name'];
	$color = $_POST['color'];
	$material = $_POST['material'];
	$search = 0;
	$test = "NO";
	$divStr = "";

	$search_shoe = $mysqli->query("SELECT DISTINCT shoe.id AS sid FROM shoe WHERE shoe.name = '$name' AND shoe.brand_id = '$brand';") or die($mysqli->error);
	while($data=mysqli_fetch_assoc($search_shoe)){
       if ($data['sid'] != "") {
		   $search= 1;
	   }
    }
	
	$insert_shoe = $mysqli->query("INSERT INTO shoe(name, color, material, brand_id) VALUES('$name', '$color', '$material', '$brand');") or die($mysqli->error);
	if ($insert_shoe = true){
		if ($search == 0){
			$divStr = "<div class=\"container table table-bordered table table-hover table table-condensed table-striped\"><table id=\"shoedimension\" class=\"table\"><caption style=\"caption-side:top\">$name is a new style, please fill up the size dimansion table</caption><tr><th>size</th><th>length</th><th>width</th><th>height</th><th>weight</th></tr>";

			$size = 5.0;
			while ($size <= 11){
				$divStr = $divStr . "<tr><td>" . $size . "</td><td contenteditable=\"true\">0</td><td contenteditable=\"true\">0</td><td contenteditable=\"true\">0</td><td contenteditable=\"true\">0</td></tr>";

				if ($size >= 9){
					 $size += 1;
				} else {
					$size += 0.5;
				}
			}
		} 
	}
	$divStr = $divStr . "</table><td><tr><button style=\"button-side:right\" type=\"button\" class=\"btn btn-danger\ onclick=\"updateValue()\">UPDATE</button></td></tr></div>";
	echo $divStr;
}

if (isset($_POST['shoeDTable'])){
	/*$brand = $_POST['brand1'];
	$name = $_POST['name1'];
	$color = $_POST['color1'];
	$material = $_POST['material1'];
	$shoeDTable = $_POST['shoeDTable'];
	$shoe_id = "";
	$search_shoe1 = $mysqli->query("SELECT DISTINCT shoe.id AS sid FROM shoe WHERE shoe.name = '$name' AND shoe.brand_id = '$brand';") or die($mysqli->error);
	while($data1=mysqli_fetch_assoc($search_shoe1)){
       $shoe_id = $data1['sid'];
    }

	$rowLength = shoeDTable.rows.length;
	$insertSQL = "INSERT INTO shoe_dimension(shoe_id, size, length, width, height, weight) VALUES('$shoe_id', ";

	//loops through rows  
	$i = 0;
	while ($i < rowLength){

	   //gets cells of current row
	   $shoeDCells = shoeDTable.rows.item(i).cells;

	   //gets amount of cells of current row
	   $cellLength = shoeDCells.length;

	   //loops through each cell in current row
	   $j=0;
	   while($j < cellLength){
		  // get your cell info here 
		  $size = j[0];
		  $length = j[1];
		  $width = j[2];
		  $height = j[3];
		  $weight = j[4];
		  // var cellVal = shoeDCell.item(j).innerHTML; 
		  $insertSQL = $insertSQL . "'$size', '$length', '$width', '$height', '$weight'";
			 $j = $j + 1;
	   }
	   $i = $i + 1;
	}
	$insertSQL = $insertSQL . ");\") or die($mysqli->error);";
	$result = $mysqli->query($insertSQL);
	*/
	echo $result;
}
?>