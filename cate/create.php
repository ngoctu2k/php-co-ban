<style>
  <?php include '../css/style.css'; ?>
</style>
<?= $_SERVER['REQUEST_METHOD']?>
<?php if ( $_SERVER['REQUEST_METHOD'] == "GET") : ?>
  <div class="container">  
    <form id="contact" action="" method="post"  enctype="multipart/form-data">
      <h3>Ông Chủ Kim 2k</h3>
      <fieldset>
        <input placeholder="Your category name" type="text" tabindex="1"  autofocus name="name">
      </fieldset>
      <fieldset>
        <textarea placeholder="Type your description" tabindex="5" name="description"></textarea>
      </fieldset>
      <fieldset>
        <input placeholder="Your category image" type="file"  name="image">
      </fieldset>
      <fieldset>
        <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Submit</button>
        <button name="reset" type="reset" id="contact-reset" data-submit="...Sending">Reset</button>
      </fieldset>
    </form>
  </div>
<?php else : ?>
  <?php 
    require("../db.php");
    $name = $_POST["name"];
    $des = $_POST["description"];
    $image = $_FILES["image"];

    $target_dir = "../uploads/category/";

    $microtime = microtime();
    $microtime = str_replace(" ", "_", $microtime);
    $microtime = str_replace(".", "_", $microtime);

    $extension = pathinfo($image["name"],PATHINFO_EXTENSION);

    $file_name = $target_dir . $microtime . "." . $extension;
    $uploaded = move_uploaded_file($image["tmp_name"],$file_name);

    // thay thế đường dẫn ảnh sau khi up load 
    $file_name = str_replace("../" ,"",$file_name);

    if ($uploaded) {
      $stmt = $conn->prepare("INSERT INTO category (name, description, image) VALUES (:name, :description, :image)");
      $stmt->bindParam(':image', $file_name);
    }
    else{
      $stmt = $conn->prepare("INSERT INTO category (name, description) VALUES (:name, :description)");
    }

    
   
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $des);
    $stmt->execute();
    header('Location: ../index.php');

  ?>
<?php endif; ?>
