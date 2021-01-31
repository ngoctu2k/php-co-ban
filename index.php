<style>
  <?php include 'css/style.css'; ?>
</style>
<?php
   require("db.php");
  $stmt = $conn->prepare("SELECT id, name, description, image FROM category");
  $stmt->execute();
  $category = $stmt->fetchAll();
  ?>
  
<table>
  <tr>
    <th>id</th>
    <th>Name</th>
    <th>description</th>
    <th>image</th>
    <th>action</th>
  </tr>
  <?php  foreach($category as $value): ?>
    
        <tr>
            <td><?=$value["id"];?></td>
            <td>
                <a href="product/index.php?cate_id=<?=$value["id"];?>"><?=$value["name"];?></a>
            </td>
            <td><?=$value["description"];?></td> 
            <td>
               <img width="100px" height = "100px" src=" <?= $value["image"]; ?>" alt="">
            </td>
            <td>
               <a href="cate/update.php?id=<?=$value["id"];?> ">Update</a>
               <a href="cate/remove.php?id=<?=$value["id"];?> ">Remove</a>
            </td>
        </tr>
  <?php endforeach;?>
  <tr>
    <td colspan="5">
      <a href="cate/create.php">Create new</a>
    </td> 
  </tr>
</table>

