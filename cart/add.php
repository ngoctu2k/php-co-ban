<?php 
  require("../db.php");  //kết nối tới csdl 
  session_start();//start using session (bat buoc)
//get product id from url 

  if (isset($_GET["id"])) {
    $pro_id = $_GET["id"];
    if (is_numeric($pro_id)) {//kiemtra id truyen có phải số hay không 

      // lấy sản phẩm với id truyền vào 
      $stmt = $conn->prepare("SELECT id, name, description, image , cate_id , price FROM product where id=$pro_id");
      $stmt->execute();
      $product = $stmt->fetch();
      if (!$product) {//kiểm tra sản phẩm có tồn tại hay không
        echo"Không có ản phẩm ";die;
      }
      $arrayValue = [];
      if (!isset($_SESSION["cart"])) {// kieemr tra xem session giỏ hàng có toonftaij hay không
        // nếu không tôn tại 
        $product["quantity"]=1;
        array_push($arrayValue,$product);//thêm sản phẩm có quantity =1 vào section 
      }
      else{
        //kiểm tra xem sản phẩm đã tồn tại trong sessction hay chưa
        $arrayValue = $_SESSION["cart"];
        $index =  -1;
        for ($i=0; $i < count($arrayValue) ; $i++) {//sử dụng vòng lặp để kiểm tra product đã tồn tai chưa 
          $item = $arrayValue[$i];
          if ( $item["id"]=$pro_id) {// nếu tồn tại thì thay  đổi giá trị của biến index
            $index = $i;
            break;
          }
        }
        if ($index>=0) {
          $arrayValue[$index]["quantity"] +=1;//nếu tồn tại thì thêm 1 quantity
        }
        else{// nếu chauw thì set quantity =1 và thêm vào sesssion
          $product["quantity"]=1;
          array_push($arrayValue,$product);//thêm sản phẩm có quantity =1 vào section 
        }
      }
    }
    else{
      echo" not a number";
    }
  }
  $_SESSION["cart"]=$arrayValue;
  var_dump($_SESSION["cart"]);die;
  header('Location: index.php'); 
?>