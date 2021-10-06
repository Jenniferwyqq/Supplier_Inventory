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
        ?>
			
			
        
            <div class="row justify-content-center">
                <table class="table">
                    <thead>
                        <tr>
							<th>STYLE</th>
                            <th>COLOR</th>
                            <th>MATERIAL</th>
							<th>BOX</th>
                            <th colspan="2">Action</th>
                        </tr>
                    </thead>
                    <tr>
                        <td> <select id="cmbMake" name="style">
						<?php
						while ($row = $result1->fetch_assoc()): ?>
						    <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
						<?php endwhile; ?>  
						</select></td>
						
						<td> <select id="cmbMake1" name="color">
						$document.on('change', '#name', function(){
							name = $('#name :selected').val();
							$ajax({
							  url:"process.php",				
							  method:"POST",
							  data:{
								 name:name
							  },					
							  success:function(res){					
								   $('#color').html(res);
							  }
							})
							});
								
						</select></td>						
                        <td> <input type="text" name="id3" value=""></td>
                        <td> <input type="text" name="id4" value=""></td>
                        <td> <input type="text" name="id5" value=""></td>
                        <td> <input type="text" name="id6" value=""></td>
                        <td> <input type="text" name="id7" value=""></td>
                    </tr>  
                </table>
            </div>
            <?php
            
            function pre_r( $array ) {
                echo '<pre>';
                print_r($array);
                echo '</pre>';
            }
        ?>
        
        <div class="row justify-content-center">
        <form action="process.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" 
                   value="<?php echo $name; ?>" placeholder="Enter your name">
            </div>
            <div class="form-group">
            <label>Brand</label>
            <input type="text" name="brand" 
                   value="<?php echo $brand; ?>" class="form-control" placeholder="Enter your brand">
            </div>
            <div class="form-group">
            <?php 
            if ($update == true): 
            ?>
                <button type="submit" class="btn btn-info" name="update">Update</button>
            <?php else: ?>
                <button type="submit" class="btn btn-primary" name="save">Save</button>
            <?php endif; ?>
            </div>
        </form>
        </div>
        </div>
    </body>
</html>