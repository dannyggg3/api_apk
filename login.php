<?php 



if ( $_SERVER['REQUEST_METHOD'] == 'POST' ){

   require_once 'db_connect.php';
   
    $email = $_POST['email'];
    $password = $_POST['password'];

        $sql="SELECT u.name, u.id, r.id, r.name AS user_type, u.warehouse_id AS shop_id, u.warehouse_id AS owner_id,u.password FROM users u INNER JOIN roles r ON r.id = role_id WHERE u.email ='".$email."'";
         
        $result =  mysqli_query($con,$sql);
        $num_rows =mysqli_num_rows($result);
         
        
    while($row = mysqli_fetch_array($result))
    {
    
        $staff_name=$row['name'];
        $staff_id=$row['id'];
        $shop_id=$row['shop_id'];
        $owner_id=$row['owner_id'];    
        
        $user_type=$row['user_type'];
        $user_pass=$row['password'];

    }

    /*if (!password_verify($password, $user_pass)) 
    {
        $response["value"] = "failure";
        $response["message"] ="[+]Invalid cell or password! Try again! - ".$email." - ".$staff_name." * ".(password_verify($password, $user_pass))." - ".$user_pass;
        echo json_encode($response);
        return;
    }*/

       
        $sql2="SELECT name shop_name, phone shop_contact, email shop_email, address shop_address, '$' currency_symbol ,  'OPEN' shop_status FROM warehouses w WHERE w.id='1'";
        $result2 =  mysqli_query($con,$sql2);
        $num_rows2 =mysqli_num_rows($result2);
       


 while($row2 = mysqli_fetch_array($result2))
  {
  
  $shop_name=$row2['shop_name'];
  $shop_contact=$row2['shop_contact'];
  $shop_email=$row2['shop_email'];  
  $shop_address=$row2['shop_address'];
  $currency_symbol=$row2['currency_symbol'];
  $shop_status=$row2['shop_status'];
  }



  
  
        if($num_rows>0 AND $num_rows2>0)
	
       {
        
        $response["name"] = $staff_name;
        $response["id"] = $staff_id;    
     
        $response["user_type"] = $user_type;  
        
        
        $response["value"] = "success";
        $response["message"] = "Login Successfull!";
        
        
        $tax = 1;
        
        //shop info
        $response["shop_name"] = $shop_name;
        $response["shop_contact"] = $shop_contact;
        $response["shop_email"] = $shop_email;
        $response["shop_address"] = $shop_address;
        $response["tax"] = $tax;
        $response["currency_symbol"] = $currency_symbol;
        $response["shop_status"] = $shop_status;
        $response["owner_id"] = 1;
        $response["shop_id"] = 1;
        
        echo json_encode($response);
       }
       
       else {
            $response["value"] = "failure";
            $response["message"] ="Invalid cell or password! Try again! - ".$email." - ".$password." * ".(password_hash($password,PASSWORD_DEFAULT));
            echo json_encode($response);
        }
        
       
    

   

} else {
    $response["value"] = "failure";
    $response["message"] = "Oops! Try again!";
    echo json_encode($response);
}

//close db connection
 mysqli_close($con);

?>