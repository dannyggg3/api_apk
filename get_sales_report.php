<?php 


if ($_SERVER['REQUEST_METHOD'] == 'GET' ){
        require_once 'db_connect.php';

        $getReportType= $_GET['type'];
        include('my_function.php');
        
         $shop_id = $_GET['shop_id'];
         $owner_id = $_GET['owner_id'];  
         $year = $_GET['yearly'];  

        


         $total_order_price=getOrderPriceByType($getReportType,$shop_id,$year);
         $total_discount=getDiscountPriceByType($getReportType,$shop_id,$year);
         $total_tax=getTaxPriceByType($getReportType,$shop_id,$year);

 
        
        
      
        $response = array();
    
            array_push($response, 
            array(
                'total_order_price'=>$total_order_price, 
                'total_tax'=>$total_tax, 
                'total_discount'=>$total_discount  
                
                
                ) 
            );
        
        echo json_encode($response);   
    


mysqli_close($con);

}

?>