<!DOCTYPE html>
<html>
    <head>
        <title>Purchase</title>
        <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php require_once 'process.php'; ?>
        
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?=$_SESSION['msg_type']?>">
                <?php 
                    echo $_SESSION['message']; 
                    unset($_SESSION['message']);
                ?>
            </div>
        <?php endif ?>
        <div class="container">
        <?php
            $mysqli = new mysqli('localhost','root','123','top_shoe') or die(mysqli_error($mysqli));
            $result = $mysqli->query("SELECT shoe.id AS shoeid, box.id AS boxid, purchase_id AS dateid, employ.id AS empid, shoe.name AS style, shoe.color AS color, box.name AS box, purchase.unit_price AS unit_qrice, purchase.quantity AS quantity, purchase_date.date AS date, employ.id AS employ_id FROM shoe, box, purchase_date, purchase, employ WHERE purchase.shoe_id = shoe.id AND purchase.box_id = box.id AND purchase.purchase_id = purchase_date.id AND purchase.employ_id = employ.id;") or die($mysqli->error);
            //pre_r($result);
			$result1 = $mysqli->query("SELECT DISTINCT shoe.name AS name FROM `shoe` WHERE 1;") or die($mysqli->error);
			$result2 = $mysqli->query("SELECT DISTINCT shoe.color AS color FROM `shoe` WHERE 1;") or die($mysqli->error);
        ?>
			
		
        
		<div class="row justify-content-center">
			<table class="table">
				<thead>
					<tr>
						<th>STYLE</th>
						<th>COLOR</th>
						<th>MATERIAL</th>
						<th>BOX</th>
						<th>QUANTITY</th>
						<th colspan="2">Action</th>
					</tr>
				</thead>
				<div class="row justify-content-center">
					<tr>
						<td>
							<div>
								<select id='name'>
									<option>-----</option>
									<?php
									$result4 = $mysqli->query("SELECT DISTINCT shoe.name AS name FROM `shoe` WHERE 1;") or die($mysqli->error);
									while($data=mysqli_fetch_assoc($result4)){
									?>
										  <option value="<?php echo $data['name'];?>"><?php echo $data['name'];?></option>
									<?php
									}
									?>
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
							<div>
								<select id='box'>
									<option>-----</option>
									
									<?php
									$result5 = $mysqli->query("SELECT DISTINCT box.name FROM box, brand WHERE box.brand_id = 數字;") or die($mysqli->error);
									while($data=mysqli_fetch_assoc($result5)){
									?>
										  <option value="<?php echo $data['name'];?>"><?php echo $data['name'];?></option>
									<?php 
									}
									?>
								</select>
							</div>
						</td>
						<td>
							<input type="text" name="name" value="" placeholder="Enter the quantity">
						</td>
						<td>
							<button type="submit" class="btn btn-info" name="update">Update</button>   
						</td>
					</tr>
				</div>
			</table>
		</div>
		<input id = 'abc' type="text" style="font-size:12px" value="修改文字大小為 12px"><br>
		<?php
		
		function pre_r( $array ) {
			echo '<pre>';
			print_r($array);
			echo '</pre>';
		}
        ?>
        
		<script>
			$(document).on('change', '#name', function(){
				var name = $('#name :selected').val();//注意:selected前面有個空格！
				$.ajax({
					url:"process.php",				
					method:"POST",
					data:{
						name:name
					},					
					success:function(res){					
					$('#color').html(res);
					}
				})//end ajax
			});
		</script>
		<script>
			$(document).on('change', '#color', function(){
				var name = $('#name :selected').val();//注意:selected前面有個空格！
				var color = $('#color :selected').val();//注意:selected前面有個空格！
				$.ajax({
					url:"process.php",				
					method:"POST",
					data:{
						
						color:color,
						xname:name
					},					
					success:function(res1){						
					$('#material').html(res1);
					$('#abc').html(value=res1);
					}
				})//end ajax
			});
		</script>
    </body>
</html>
