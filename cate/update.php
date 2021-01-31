<?php 

 require("../db.php");//kết nối database
?>



<?php if ( $_SERVER['REQUEST_METHOD'] == "GET") : ?>
  <?php
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
  ?>
  <div class="container">  
  <form id="contact" action="" method="post"  enctype="multipart/form-data">
    <h3><?=$categoty["name"] ?></h3>
    <input hidden type="text" name="id" value="<?php echo $cateId ?>">
    <fieldset>
      <input value="<?=$categoty["name"] ?>" placeholder="Your category name" type="text" tabindex="1"  autofocus name="name">
    </fieldset>
    <fieldset>
      <textarea placeholder="Type your description" tabindex="5" name="description">
         <?=$categoty["description"] ?>
      </textarea>
    </fieldset>
    <fieldset>
      <input value="<?=$categoty["image"] ?>" placeholder="Your category image" type="file"  name="image">
    </fieldset>
    <fieldset>
      <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Submit</button>
      <button name="reset" type="reset" id="contact-reset" data-submit="...Sending">Reset</button>
    </fieldset>
  </form>
</div>
<?php
  ?>
<?php else : ?>
  <?php
     //thực hiện lấy dữ liệu và lưu xuống database
     //lấy dữ liệu name và description id image
    $name = $_POST["name"];
    $des = $_POST["description"];
    $image = $_FILES["image"];
    $id = $_POST["id"];
    
    // xử lý ảnh 

    $target_dir = "../uploads/category/";//thư mục chứa ảnh trên sever

    //1.sinh ra tên duy nhất từ thời gian
    $microtime = microtime();
    $microtime = str_replace(" ", "_", $microtime);
    $microtime = str_replace(".", "_", $microtime);

    $extension = pathinfo($image["name"],PATHINFO_EXTENSION);// lấy ra đuôi của ảnh

    $file_name = $target_dir . $microtime . "." . $extension;//sịnh ra tên ảnh mới 
    $uploaded = move_uploaded_file($image["tmp_name"],$file_name);//chuyển ảnh từ thư mục tmp của sever snag thư mục upload phù hợp -upload/category

    // thay thế đường dẫn ảnh sau khi up load 
    $file_name = str_replace("../" ,"",$file_name);

    if ($uploaded) {//nếu upload ảnh thành công
      $stmt = $conn->prepare("UPDATE category SET name=:name,description=:description,image=:image  WHERE id = :id;");
      $stmt->bindParam(':image', $file_name);
    }
    else{
      $stmt = $conn->prepare("UPDATE category SET name=:name,description=:description  WHERE id = :id;");

    }

   
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $des);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    header('Location: ../index.php'); 
    ?>
<?php endif; ?>