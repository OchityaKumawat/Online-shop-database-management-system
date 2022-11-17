<?php
include_once 'top.inc.php';
$condition='';
$condition1='';
if($_SESSION['ADMIN_ROLE']==1){
	$condition=" and product.added_by='".$_SESSION['ADMIN_ID']."'";
	$condition1=" and added_by='".$_SESSION['ADMIN_ID']."'";
}

if(isset($_GET['type']) && $_GET['type']!=''){
	$type=$_GET['type'];
	if($type=='status'){
		$operation=$_GET['operation'];
		$id=$_GET['id'];
		if($operation=='active'){
			$status='1';
		}else{
			$status='0';
		}
		$update_status_sql="update product set status='$status' $condition1 where id='$id'";
		mysqli_query($con,$update_status_sql);
	}
	
	if($type=='delete'){
		$id=$_GET['id'];
		$delete_sql="delete from product where id='$id' $condition1";
		mysqli_query($con,$delete_sql);
	}
}

$sql="select product.*,categories.categories from product,categories where product.categories_id=categories.id $condition order by product.id desc";
$res=mysqli_query($con,$sql);

?>
<div class="card-body">
<h4 class="box-title">Product </h4>
				   <h4 class="box-link"><a href="manage_product.php">Add Product</a> </h4>
<table class="styled-table">
    <thead>
        <tr>
            <th>#</th>
            <th>ID</th>
            <th>Categories</th>
            <th>Name</th>
            <th>Image</th>
            <th>MRP</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $i=1;
    while($row=mysqli_fetch_assoc($res)){?>
        <tr>
            <td><?php echo $i?></td>
            <td><?php echo $row['id']?></td>
            <td><?php echo $row['categories']?></td>
            <td><?php echo $row['name']?></td>
            <td><img style="height: 60px;width: 60px;" src="<?php echo PRODUCT_IMAGE_SITE_PATH.$row['image']?>"/></td>
            <td><?php echo $row['mrp']?></td>
            <td><?php echo $row['price']?></td>
            <td><?php echo $row['qty']?><br/>
							   <?php
							   $productSoldQtyByProductId=productSoldQtyByProductId($con,$row['id']);
							   $pneding_qty=$row['qty']-$productSoldQtyByProductId;
							   
							   ?>
							   Pending Qty: <?php echo $pneding_qty?>
        </td>
            <td><?php
            if($row['status']==1){
                echo "<a href='?type=status&operation=deactive&id=".$row['id']."'>Active</a>&nbsp;";
            }else{
                echo "<a href='?type=status&operation=active&id=".$row['id']."'>Deactive</a>&nbsp;";
            }
            echo "<a href='manage_product.php?id=".$row['id']."'>Edit</a>&nbsp;";
            echo "<a href='?type=delete&id=".$row['id']."'>Delete</a>";
            
            ?></td>
        </tr>
    <?php $i++; } ?>    
    </tbody>
</table>
        </div>
      </div>
    </div>
  </body>
</html>
