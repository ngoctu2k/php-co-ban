<style>
  <?php include '../css/style.css'; ?>
</style>
<?= $_SERVER['REQUEST_METHOD']?>
<?php 
   require("../db.php");
   $stmt = $conn->prepare("SELECT id, name FROM category");
   $stmt->execute();
  $category = $stmt->fetchAll();
?>

<?php if ( $_SERVER['REQUEST_METHOD'] == "GET") : ?>
  <div class="container">  
    <form id="contact" action="" method="post"  enctype="multipart/form-data">
      <h3>Ông Chủ Kim 2k</h3>
      <h3>Craete New Product</h3>
      <fieldset>
        <input placeholder="Your product name" type="text" tabindex="1"  autofocus name="name">
      </fieldset>
      <fieldset>
       <select name="cate_id" id="cate_id">
        <?php 
          if (count($category)>0) {
            foreach($category as $value){
                ?>
                  <option value="<?=$value["id"]?>"><?=$value["name"]?></option>
                <?php
            }
          }
        ?>
       </select>
      </fieldset>
      <fieldset>
        <textarea placeholder="Type your description" tabindex="5" name="description"></textarea>
      </fieldset>
      <fieldset>
        <input placeholder="Your product image" type="file"  name="image">
      </fieldset>
      <fieldset>
        <input placeholder="Your product price" type="number"  name="price">
      </fieldset>
     
      <fieldset>
        <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Submit</button>
        <button name="reset" type="reset" id="contact-reset" data-submit="...Sending">Reset</button>
      </fieldset>
    </form>
  </div>
<?php else : ?>
  <?php 
   
    $name = $_POST["name"];
    $des = $_POST["description"];
    $image = $_FILES["image"];
    $price = $_POST["price"];
    $cate_id = $_POST["cate_id"];

    

    $target_dir = "../uploads/product/";

    $microtime = microtime();
    $microtime = str_replace(" ", "_", $microtime);
    $microtime = str_replace(".", "_", $microtime);

    $extension = pathinfo($image["name"],PATHINFO_EXTENSION);

    $file_name = $target_dir . $microtime . "." . $extension;
    $uploaded = move_uploaded_file($image["tmp_name"],$file_name);

    // thay thế đường dẫn ảnh sau khi up load 
    $file_name = str_replace("../" ,"",$file_name);

    if ($uploaded) {
      $stmt = $conn->prepare("INSERT INTO product (name, description, image, cate_id, price) VALUES (:name, :description, :image, :cate_id, :price)");
      $stmt->bindParam(':image', $file_name);
    }
    else{
      $stmt = $conn->prepare("INSERT INTO product (name, description, cate_id, price) VALUES (:name, :description ,:cate_id, :price)");
    }

    
   
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $des);
    $stmt->bindParam(':cate_id', $cate_id);
    $stmt->bindParam(':price', $price);
    $stmt->execute();
    header('Location: index.php');

  ?>
<?php endif; ?>
