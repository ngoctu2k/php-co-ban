<?php 
 require("../db.php");//kết nối database
 require("../db.php");
 $stmt = $conn->prepare("SELECT id, name FROM category");
 $stmt->execute();
$category = $stmt->fetchAll();
?>



<?php if ( $_SERVER['REQUEST_METHOD'] == "GET") : ?>
  <?php
  $proId = $_GET['id'];
  if (intval($proId) <= 0) {
    echo("Invalid product id");
    die;
  }
  $stmt = $conn->prepare("SELECT id, name, description, image , cate_id , price FROM product where id=$proId");
  $stmt->execute();
  $product = $stmt->fetch();
  var_dump($product);
 
  if (!$product) {
    echo("no  product id");
    die;
  }
  ?>
  <div class="container">  
  <form id="contact" action="" method="post"  enctype="multipart/form-data">
    <h3><?=$product["name"] ?></h3>
    <input hidden type="text" name="id" value="<?php echo $proId ?>">
    <fieldset>
      <input value="<?=$product["name"] ?>" placeholder="Your category name" type="text" tabindex="1"  autofocus name="name">
    </fieldset>
    <fieldset>
      <select name="cate_id" id="cate_id">
          <?php 
            if (count($category)>0) {
              foreach($category as $value){
                if ($value["id"] == $product["cate_id"]) {
                  ?>
                    <option selected value="<?=$value["id"]?>"><?=$value["name"]?></option>
                  <?php
                }
                else{
                  ?>
                    <option value="<?=$value["id"]?>"><?=$value["name"]?></option>
                  <?php
                }
                
              }
            }
          ?>
      </select>
    </fieldset>
    <fieldset>
      <textarea placeholder="Type your description" tabindex="5" name="description">
         <?=$product["description"] ?>
      </textarea>
    </fieldset>
    <fieldset>
      <input value="<?=$product["image"] ?>" placeholder="Your product image" type="file"  name="image">
    </fieldset>
    <fieldset>
      <input value="<?=$product["price"] ?>" placeholder="Your price name" type="number" name="price">
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
    $price = $_POST["price"];
    $cate_id = $_POST["cate_id"];
    
    // xử lý ảnh 

    $target_dir = "../uploads/product/";//thư mục chứa ảnh trên sever

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
      $stmt = $conn->prepare("UPDATE product SET name=:name,description=:description,image=:image,price=:price, cate_id=:cate_id  WHERE id = :id;");
      $stmt->bindParam(':image', $file_name);
    }
    else{
      $stmt = $conn->prepare("UPDATE category SET name=:name,description=:description,price=:price, cate_id=:cate_id  WHERE id = :id;");

    }

   
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $des);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':cate_id', $cate_id);
    $stmt->execute();
    header('Location: index.php'); 
    ?>
<?php endif; ?>