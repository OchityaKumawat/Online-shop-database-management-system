<?php
include_once 'top.inc.php';
isAdmin();
if(isset($_GET['type'])&& $_GET['type']!=''){
    $type=$_GET['type'];
    if($type=='status'){
        $operation=$_GET['operation'];
        $id=$_GET['id'];
        if($operation=='active'){
            $status='1';
        }else{
            $status='0';
        }
        $update_status_sql="update categories set status='$status' where id='$id'";
        mysqli_query($con,$update_status_sql);
    }
    if($type=='delete'){
        $id=$_GET['id'];
        $delete_sql="delete from categories where id='$id'";
        mysqli_query($con,$delete_sql);
    }

}

$sql="select * from categories order by categories asc";
$res=mysqli_query($con,$sql);

?>
<div class="card-body">
<h4 class="box-title">Categories </h4>
				   <h4 class="box-link"><a href="manage_categories.php">Add Categories</a> </h4>
<table class="styled-table">
    <thead>
        <tr>
            <th>S.No</th>
            <th>ID</th>
            <th>Categories</th>
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
            <td><?php
            if($row['status']==1){
                echo "<a href='?type=status&operation=deactive&id=".$row['id']."'>Active</a>&nbsp;";
            }else{
                echo "<a href='?type=status&operation=active&id=".$row['id']."'>Deactive</a>&nbsp;";
            }
            echo "<a href='manage_categories.php?id=".$row['id']."'>Edit</a>&nbsp;";
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