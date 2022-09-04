<?php


if ( $_SERVER['REQUEST_METHOD'] == 'POST' ){
    
$target_dir = "../product_images/";
$temp = explode(".", $_FILES["file"]["name"]);
$newfilename =round(microtime(true)) . '.' . end($temp);
 
$target_file_name = $target_dir .$newfilename;

 
    
$response = array();

 $name =  $_POST['product_name'];
 $code =  $_POST['product_code'];
 $category_id =  $_POST['category_id'];
 $description =  $_POST['product_description'];
 $sell_price =  $_POST['product_sell_price'];
 $weight =$_POST['product_weight'];
 $weight_unit_id =  $_POST['product_weight_unit_id'];
 $suppliers_id =$_POST['suppliers_id'];
 $stock =  $_POST['product_stock'];
 $image_name =$newfilename;
 $shop_id =  $_POST['shop_id'];
 $owner_id =  $_POST['owner_id'];
 
 $tax =  $_POST['tax'];

 
 
 

 //importing db_connect.php script 
 require_once('db_connect.php');
 
  $sql = "Insert into products (product_name,product_code,product_category_id,product_description,product_sell_price,product_weight,product_weight_unit_id,product_supplier_id,product_image,product_stock,shop_id,owner_id,tax) values('$name','$code',$category_id,'$description',$sell_price,'$weight',$weight_unit_id,$suppliers_id,'$image_name',$stock,'$shop_id','$owner_id','$tax')";
 
 
// Check if image file is a actual image or fake image
if (isset($_FILES["file"])) 
{
   if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file_name)) 
   {
       
     if(mysqli_query($con,$sql))
     {
     $response["value"] = "success";
     echo json_encode($response);
     }
     else
     {
       
            $response["value"] = "failure";
            echo json_encode($response);
     }
   }
   else 
   {
       $response["value"] = "failure";
            echo json_encode($response);
   }
   
     mysqli_close($con);
}
else 
{
      $response["value"] = "failure";
            echo json_encode($response);
}

}

else
{

 $response["value"] = "failure";
 echo json_encode($response);
 echo json_encode($response);

}

?>