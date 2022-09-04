<?php 


if ($_SERVER['REQUEST_METHOD'] == 'GET' ){
        require_once 'db_connect.php';

        $getReportType= $_GET['type'];
        $shop_id = $_GET['shop_id'];
        $owner_id = $_GET['owner_id'];  

        include('my_function.php');

        


         $total_expense_price=getExpenseByType($getReportType,$shop_id);
         
        
        
      
        $response = array();
    
            array_push($response, 
            array(
                'total_expense_price'=>$total_expense_price, 
               
                
                
                ) 
            );
        
        echo json_encode($response);   
    


mysqli_close($con);

}

?>