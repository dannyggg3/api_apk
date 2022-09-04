<?php 


if ($_SERVER['REQUEST_METHOD'] == 'GET' ){
require_once 'db_connect.php';
include('my_function.php');

   $product_id = $_GET['product_id'];
   $shop_id = $_GET['shop_id'];
  
    //SQL inner join query with 3 tables
          //SQL inner join query with 3 tables
         $query = "SELECT * FROM products INNER JOIN
    weight_unit ON weight_unit.weight_unit_id = products.product_weight_unit_id WHERE shop_id='$shop_id' AND product_id='$product_id' ORDER BY product_id DESC";
      
        
        
        $result = mysqli_query($con, $query);
        $response = array();
        while( $row = mysqli_fetch_assoc($result) ){
            array_push($response, 
            array(
                'product_id'=>$row['product_id'], 
                'product_name'=>$row['product_name'], 
                'product_code'=>$row['product_code'], 
                'product_category_id'=>$row['product_category_id'],
                'product_category_name'=>categoryName($row['product_category_id']),
                'suppliers_name'=>$row['suppliers_name'],
                'product_supplier_id'=>$row['product_supplier_id'],
                'product_description'=>$row['product_description'],
                'product_sell_price'=>$row['product_sell_price'],
                'product_weight'=>$row['product_weight'],
                'weight_unit_name'=>$row['weight_unit_name'],
                'weight_unit_id'=>$row['weight_unit_id'],
                'product_suppler'=>$row['product_supplier'],
                'product_image'=>$row['product_image'],
                'product_stock'=>$row['product_stock'],
                'tax'=>$row['tax']
                
                ) 
            );
        }
        echo json_encode($response);   
    
mysqli_close($con);

}

?>