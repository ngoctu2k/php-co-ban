<style>
  <?php include '../css/style.css'; ?>
</style>
<?php
  require("../db.php");

  //check có category không ? nếu không có lấy ra toàn bộ dữ liệu của product ? 
  //? nếu có category id truyền theo lấy ra toàn bộ sản phẩm có cate_id = cate id truyền vào 
  if (isset($_GET["cate_id"])) {
    $cate_id =$_GET["cate_id"];
    $stmt = $conn->prepare("SELECT  p.id as product_id,
                                    p.name as product_name,
                                    p.description as product_description,
                                    p.image as product_image,	    
                                    p.price as product_price,
                                    c.name as cate_name
                             FROM product p LEFT JOIN category c ON p.cate_id = c.id
                             WHERE p.cate_id = :cate_id");
    $stmt->bindParam(":cate_id",$cate_id);
  }
  else{
    $stmt = $conn->prepare("SELECT  p.id as product_id,
                                    p.name as product_name,
                                    p.description as product_description,
                                    p.image as product_image,	    
                                    p.price as product_price,
                                    c.name as cate_name
                                FROM product p LEFT JOIN category c ON p.cate_id = c.id");
  }
  $stmt->execute();
  $product = $stmt->fetchAll();
  ?>
<table>
  <tr>
    <th>id</th>
    <th>Name</th>
    <th>description</th>
    <th>image</th>
    <th>category name</th>
    <th>price</th>
    <th>action</th>
  </tr>
  <?php  foreach($product as $value): ?>
    
        <tr>
            <td><?=$value["product_id"];?></td>
            <td>
                <a href="product/index.php?prod_id=<?=$value["product_id"];?>"><?=$value["product_name"];?></a>
            </td>
            <td><?=$value["product_description"];?></td> 
            <td>
               <img width="100px" height = "100px" src=" <?="../".$value["product_image"]; ?>" alt="">
            </td>
            <td>
                <a href="../index.php"><?=$value["cate_name"];?></a>
            </td>
            <td><?=$value["product_price"];?></td>
            <td>
               <a href="update.php?id=<?=$value["product_id"];?> ">Update</a>
               <a href="remove.php?id=<?=$value["product_id"];?> ">Remove</a>
               <a href="../cart/add.php?id=<?=$value["product_id"];?> ">Mua ngay </a>
            </td>
        </tr>
  <?php endforeach;?>
  <tr>
    <td colspan="5">
      <a href="create.php">Create new product</a>
    </td> 
  </tr>
</table>