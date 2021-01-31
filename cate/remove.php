<?php 
 require("../db.php");

 $cateId = $_GET['id'];
 if (intval($cateId) <= 0) {
   echo("Invalid category id");
   die;
 }

 $stmt = $conn->prepare("SELECT id, name, description, image FROM category where id=$cateId");
 $stmt->execute();
 $categoty = $stmt->fetch();
 var_dump($categoty);

 if (!$categoty) {
   echo("no  category id");
   die;
 }
 $stmt = $conn->prepare("DELETE FROM category WHERE id=$cateId");
 $stmt->execute();
 header('Location: ../index.php');
?>