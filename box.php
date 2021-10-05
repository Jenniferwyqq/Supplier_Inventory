<!DOCTYPE html>
<html>
    <head>
        <title>TOP SHOE</title>
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
            $result = $mysqli->query("SELECT box.id AS id, box.name AS boxname, brand.name AS brandname FROM box, brand WHERE box.brand_id = brand.id") or die($mysqli->error);
            //pre_r($result);
            ?>
        
            <div class="row justify-content-center">
                <table class="table">
                    <thead>
                        <tr>
							<th>ID</th>
                            <th>Name</th>
                            <th>Brand</th>
                            <th colspan="2">Action</th>
                        </tr>
                    </thead>
            <?php
                while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['boxname']; ?></td>
                        <td><?php echo $row['brandname']; ?></td>
                        <td>
                            <a href="index.php?edit=<?php echo $row['id']; ?>"
                               class="btn btn-info">Edit</a>
                            <a href="process.php?delete=<?php echo $row['id']; ?>"
                               class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>    
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