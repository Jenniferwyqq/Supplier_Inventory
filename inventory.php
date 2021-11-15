<!DOCTYPE html>
<html>
    <head>
        <title>Inventory</title>
        <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>
    <body>
        <?php require_once 'inventoryprocess.php'; ?>
        
        <div class="container">
			<?php
				$mysqli = new mysqli('localhost','root','123','top_shoe') or die(mysqli_error($mysqli));
				$resultbrand = $mysqli->query("SELECT DISTINCT brand.id AS brandid, brand.name AS brand FROM `brand` WHERE 1;") or die($mysqli->error);
				
				
			?>
		</div>
		<div class="container">
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
						<input type="button" class="btn btn-secondary" value="SEARCH" onclick="setdivcontent()"> 
					</td>
				</tr>
			</table>
		</div>
		<style>
			th {background:#b8def5}
		</style>
		<style>
			.table-hover tbody tr:hover td {
				background: #FEF878;
			}
		</style>
		<div class="container" id="here">
	
		</div>
		<div class="container" id="view">
		</div>


        <script>
			$(document).on('change', '#brand', function(){
				var brand = $('#brand :selected').val();
				$.ajax({
					url:"inventoryprocess.php",				
					method:"POST",
					data:{
						brand:brand
					},					
					success:function(s_name){		
					s_name = "<option>-----</option>" +s_name;
					$('#name').html(s_name);
					}
				})
			});
		</script>
		<script>
			$(document).on('change', '#name', function(){				
				var brand = $('#brand :selected').val();
				var name = $('#name :selected').val();
				$.ajax({
					url:"inventoryprocess.php",				
					method:"POST",
					data:{
						brand1:brand,
						name:name
					},					
					success:function(s_color){		
					s_color = "<option>-----</option>" +s_color;					
					$('#color').html(s_color);
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
					url:"inventoryprocess.php",				
					method:"POST",
					data:{
						brand2:brand,
						name1:name,
						color:color
					},					
					success:function(s_material){		
					s_material = "<option>-----</option>" +s_material;
					$('#material').html(s_material);
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
					url:"inventoryprocess.php",				
					method:"POST",
					data:{
						brand3:brand,
						name2:name,
						color1:color,
						material:material
					},
					success:function(divStr){	
						document.getElementById("here").innerHTML = divStr;
					},
					error: function (divStr) {
						alert("Local error callback.");
					},
					complete: function (divStr) {
						//alert("Local completion callback.");
					}
				})//end ajax
				//window.location.reload();
			}
		</script>
		<script>
			$("#here").on('click','.saveChanges',function(){
				var yes = confirm('Are you sure？');
				if (yes) {
					var currentRow=$(this).closest("tr"); 
					var box=currentRow.find("td:eq(0)").text();
					var content=currentRow.find("td:eq(1)").text(); // get current row 1st TD value
					var brand = $('#brand :selected').val();
					var name = $('#name :selected').val();
					var color = $('#color :selected').val();
					var material = $('#material :selected').val();
					
					$.ajax({
						url:"inventoryprocess.php",
						type:"POST",
						data:{
							brand4:brand,
							name3:name,
							color2:color,
							material1:material,
							box:box,
							content:content
						},
						success:function(divStr1){	
							alert("update success");
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
			function detailclick(clicked_id){
				var brand = $('#brand :selected').val();
				var name = $('#name :selected').val();
				var color = $('#color :selected').val();
				var material = $('#material :selected').val();

				$.ajax({
					url:"inventoryprocess.php",				
					method:"POST",
					data:{
						brand5:brand,
						name4:name,
						color3:color,
						material2:material,
						box1:clicked_id
					},
					success:function(divStr1){		
						document.getElementById("view").innerHTML = divStr1;
					},
					error: function (divStr1) {
						alert("Local error callback.");
					},
					complete: function (divStr1) {
						//alert("Local completion callback.");
					}
				})//end ajax
				//window.location.reload();
			}
		</script>
    </body>
</html>
