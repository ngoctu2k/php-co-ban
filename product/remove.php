<?php 
 require("../db.php");

 $proId = $_GET['id'];
 if (intval($proId) <= 0) {
   echo("Invalid category id");s
   die;
 }

 $stmt = $conn->prepare("SELECT id FROM product where id=$proId");
 $stmt->execute();
 $product = $stmt->fetch();
 var_dump($product);

 if (!$product) {
   echo("no  product id");
   die;
 }
 $stmt = $conn->prepare("DELETE FROM product WHERE id=$proId");
 $stmt->execute();
 header('Location: index.php');
?>