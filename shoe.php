<!DOCTYPE html>
<html>
    <head>
        <title>Shoe_Catalog</title>
        <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php
            $mysqli = new mysqli('localhost','root','123','top_shoe') or die(mysqli_error($mysqli));
			$resultbrand = $mysqli->query("SELECT DISTINCT brand.id AS brandid, brand.name AS brand FROM `brand` WHERE 1;") or die($mysqli->error);
        ?>
		<div class="container">
			<div style="text-align:center;">
				<h2> Shoe Catalog </h2>
			</div>
			<table id="main" class="table table-bordered">
				<thead>
					<tr>
						<th>BRAND</th>
						<th>STYLE</th>
						<th>COLOR</th>
						<th>MATERIAL</th>
						<th></th>
					</tr>
				</thead>
				<tr>
					<td>
						<div>
							<select id='brand'>
								<option>-----</option>
								<?php
								while($data=mysqli_fetch_assoc($resultbrand)){
								?>
									 <option value="<?php echo $data['brandid'];?>"><?php echo $data['brand'];?></option>
								<?php
								}
								?>
							</select>
						</div>
					</td>
					<td>
						<div>
							<select id='name'>
								<option>-----</option>
							</select>
						</div>
					</td>
					<td>
						<div>
							<select id='color'>
								<option>-----</option>
							</select>
						</div>
					</td>
					<td>
						<div>
							<select id='material'>
								<option>-----</option>
							</select>
						</div>
					</td>
					<td>
						<input type="hidden" id="shoe_id" name="shoe_id" value="0">
						<input type="button" value="SEARCH" onclick="setdivcontent()"> 
					</td>
				</tr>
			</table>
		
			<style>
				th {background:#b8def5;}
				.table-hover tbody tr:hover td {
					background: #FEF878;
				}
				.btn-group button {
				  background-color: #04AA6D; /* Green background */
				  border: 1px solid green; /* Green border */
				  color: white; /* White text */
				  padding: 10px 24px; /* Some padding */
				  cursor: pointer; /* Pointer/hand icon */
				  float: left; /* Float the buttons side by side */
				}

				/* Clear floats (clearfix hack) */
				.btn-group:after {
				  content: "";
				  clear: both;
				  display: table;
				}

				.btn-group button:not(:last-child) {
				  border-right: none; /* Prevent double borders */
				}

				/* Add a background color on hover */
				.btn-group button:hover {
				  background-color: #3e8e41;
				}
			</style>
			<div class="btn-group">
			    <button id="shoe_dim_btn">shoe_dimension</button>
			    <button id="box_dim_btn">box_dimension</button>
				<button id="photo_btn">photo</button>
			</div>
			<div id="display">
			</div>
		</div>
	
        <script>
			$(document).on('change', '#brand', function(){
				var brand = $('#brand :selected').val();
				$.ajax({
					url:"shoeprocess.php",				
					method:"POST",
					data:{
						brand:brand
					},					
					success:function(shoename){		
					shoename = "<option>-----</option>" +shoename;
					$('#name').html(shoename);
					}
				})
			});
		</script>
		
		<script>
			$(document).on('change', '#name', function(){				
				var brand = $('#brand :selected').val();
				var name = $('#name :selected').val();
				$.ajax({
					url:"shoeprocess.php",				
					method:"POST",
					data:{
						brand1:brand,
						name:name
					},					
					success:function(shoecolor){		
					shoecolor = "<option>-----</option>" +shoecolor;					
					$('#color').html(shoecolor);
					}
				})
			});
		</script>
		<script>
			$(document).on('change', '#color', function(){
				var brand = $('#brand :selected').val();
				var name = $('#name :selected').val();
				var color = $('#color :selected').val();
				$.ajax({
					url:"shoeprocess.php",				
					method:"POST",
					data:{
						brand2:brand,
						name1:name,
						color:color
					},					
					success:function(shoematerial){		
					shoematerial = "<option>-----</option>" +shoematerial;
					$('#material').html(shoematerial);
					}
				})
			});
		</script>
		<script>
			function setdivcontent(){
				var brand = $('#brand :selected').val();
				var name = $('#name :selected').val();
				var color = $('#color :selected').val();
				var material = $('#material :selected').val();
				
				$.ajax({
					url:"shoeprocess.php",				
					method:"POST",
					data:{
						brand3:brand,
						name2:name,
						color1:color,
						material:material
					},
					success:function(array){
						alert("select shoe_dimension / box_dimension / photo");
						var result = $.parseJSON(array);
						document.getElementById("shoe_id").value = result[3];
						const shoebtn = document.getElementById("shoe_dim_btn");
						const boxbtn = document.getElementById("box_dim_btn");
						const photobtn = document.getElementById("photo_btn");
						alert(array);
						shoebtn.onclick = function () {
							//alert("HI");
						 	document.getElementById("display").innerHTML = result[0];
						};
						boxbtn.onclick = function () {
							//alert("deeee");
							document.getElementById("display").innerHTML = result[1];
						};
						photobtn.onclick = function () {
							document.getElementById("display").innerHTML = result[2];
						};
					},
					error: function (array) {
						alert("Local error callback.");
					},
					complete: function (array) {
						//alert("Local completion callback.");
					}
				})
			}
		</script>
		<script>
			$("#display").on('click','.saveChanges',function(){
			//function editclick(ixd){
				//alert(ixd);
				var yes = confirm('Are you sure？');
				if (yes) {
					var brand = $('#brand :selected').val();
					var name = $('#name :selected').val();
					var color = $('#color :selected').val();
					var material = $('#material :selected').val();
					var $currentRow=$(this).closest("tr"); 
					var size=$currentRow.find("td:eq(0)").text();
					var length=$currentRow.find("td:eq(1)").text();
					var width=$currentRow.find("td:eq(2)").text();
					var height=$currentRow.find("td:eq(3)").text();
					var weight=$currentRow.find("td:eq(4)").text();
					
					
					$.ajax({
						url:"shoeprocess.php",
						type:"POST",
						data:{
							brand4:brand,
							name3:name,
							color2:color,
							material1:material,
							size:size,
							length:length,
							width:width,
							height:height,
							weight:weight
						},
						success:function(divStr1){	
							alert(divStr1);
						},
						error: function (divStr1) {
							alert("Local error callback.");
						},
						complete: function (divStr1) {
							//alert("Local completion callback.");
						}
					});
				}
			});
		</script>
		<script>
			$("#display").on('click','.hasChanges',function(){
				var yes = confirm('Are you sure？');
				if (yes) {
					var brand = $('#brand :selected').val();
					var name = $('#name :selected').val();
					var color = $('#color :selected').val();
					var material = $('#material :selected').val();
					var $currentRow=$(this).closest("tr"); 
					var box=$currentRow.find("td:eq(0)").text();
					var length=$currentRow.find("td:eq(1)").text();
					var width=$currentRow.find("td:eq(2)").text();
					var height=$currentRow.find("td:eq(3)").text();
					var weight=$currentRow.find("td:eq(4)").text();
					alert(height);

					$.ajax({
						url:"shoeprocess.php",
						type:"POST",
						data:{
							brand5:brand,
							name4:name,
							color3:color,
							material2:material,
							box:box,
							length1:length,
							width1:width,
							height1:height,
							weight1:weight
						},
						success:function(divStr2){	
							alert(divStr2);
						},
						error: function (divStr2) {
							alert("Local error callback.");
						},
						complete: function (divStr1) {
							//alert("Local completion callback.");
						}
					});
				}
			});
		
		</script>
		
		
<?php

	if(isset($_POST['upload'])){
		
		$filename = $_FILES['image']['name'];
		$shoe_id = $_POST['shoe_id'];
		$image_id = 1;
		
		$search_image_id = $mysqli->query("SELECT photo.image_id AS iid FROM photo WHERE photo.shoe_id = '$shoe_id';") or die($mysqli->error);
		while($data6=mysqli_fetch_assoc($search_image_id)){
			$image_id=$data6['iid'] + 1;
		}
		
	   // Getting file name
	   $filename = $_FILES['image']['name'];
		if($filename != ""){
		   // Valid extension
		   $valid_ext = array('png','jpeg','jpg');
				
		   $photoExt1 = @end(explode('.', $filename)); // explode the image name to get the extension
		   $phototest1 = strtolower($photoExt1);
				
		   $new_profle_pic = time().'.'.$phototest1;
				
		   // Location
		   $location = "image/".$new_profle_pic;

		   // file extension
		   $file_extension = pathinfo($location, PATHINFO_EXTENSION);
		   $file_extension = strtolower($file_extension);

		   // Check extension
		   if(in_array($file_extension,$valid_ext)){  

				// Compress Image
				compressedImage($_FILES['image']['tmp_name'],$location,60);
					
			}
			else
			{
					echo "File format is not correct.";
			}

			 $sql = "INSERT INTO photo(shoe_id, image_id, image) VALUES ('" . $shoe_id . "', '" . $image_id . "', '".$new_profle_pic."')";

			if (mysqli_query($mysqli, $sql)) 
			{
				echo "New record created successfully";
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
				}
		} else {
			
		}
	}	

	// Compress image
	function compressedImage($source, $path, $quality) {

			$info = getimagesize($source);

			if ($info['mime'] == 'image/jpeg') 
				$image = imagecreatefromjpeg($source);

			elseif ($info['mime'] == 'image/gif') 
				$image = imagecreatefromgif($source);

			elseif ($info['mime'] == 'image/png') 
				$image = imagecreatefrompng($source);

			imagejpeg($image, $path, $quality);

	}

	?>
		

		
		
		
    </body>
</html>
