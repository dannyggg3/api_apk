<?php 


if ($_SERVER['REQUEST_METHOD'] == 'GET' ){
require_once 'db_connect.php';

   $search_text = $_GET['search_text'];
   $shop_id = $_GET['shop_id'];
   $owner_id = $_GET['owner_id'];     
  
  if(strlen($search_text)>1)
  {
       $query = "SELECT id as customer_id, name as customer_name, phone_number as customer_cell, address as customer_address, email  as customer_email ,tipo, cedula  FROM customers  WHERE  name LIKE '%{$search_text}%'  OR cedula LIKE '%{$search_text}%' ORDER BY name";
  }
  else
  {
         $query = "SELECT  id as customer_id, name as customer_name, phone_number as customer_cell, address as customer_address, email  as customer_email ,tipo,cedula FROM customers ORDER BY name";
  }

 
        
        $result = mysqli_query($con, $query);
        $response = array();
        while( $row = mysqli_fetch_assoc($result) ){
            array_push($response, 
            array(
                'customer_id'=>$row['customer_id'], 
                'customer_name'=>$row['customer_name'], 
                'customer_cell'=>$row['customer_cell'], 
                'customer_address'=>$row['customer_address'], 
                'customer_email'=>$row['customer_email'],
                'dni'=>$row['cedula'],
                'type_dni'=>$row['tipo']
                ) 
            );
        }
        echo json_encode($response);   
    


mysqli_close($con);

}

?>