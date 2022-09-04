<?php 


if ($_SERVER['REQUEST_METHOD'] == 'GET' ){
        require_once 'db_connect.php';

  
     //set default time zone
  date_default_timezone_set("Asia/Dhaka");
  
  //get current timedate
  $current_time=date("h:i A");
  
  //get current date
  $current_date=date("Y-m-d");
 
  
     
        
        $shop_id =  $_GET['shop_id'];
        $owner_id = $_GET['owner_id'];  
        $year = $_GET['yearly'];  
        
        include('my_function.php');

        


         $jan=getMonthlyExpense('1',$year,$shop_id);
         $feb=getMonthlyExpense('2',$year,$shop_id);
         $mar=getMonthlyExpense('3',$year,$shop_id);
         $apr=getMonthlyExpense('4',$year,$shop_id);
         $may=getMonthlyExpense('5',$year,$shop_id);
         $jun=getMonthlyExpense('6',$year,$shop_id);
         $jul=getMonthlyExpense('7',$year,$shop_id);
         $aug=getMonthlyExpense('8',$year,$shop_id);
         $sep=getMonthlyExpense('9',$year,$shop_id);
         $oct=getMonthlyExpense('10',$year,$shop_id);
         $nov=getMonthlyExpense('11',$year,$shop_id);
         $dec=getMonthlyExpense('12',$year,$shop_id);
         
        
        
      
        $response = array();
    
            array_push($response, 
            array(
                'jan'=>$jan,
                'feb'=>$feb, 
                'mar'=>$mar, 
                'apr'=>$apr, 
                'may'=>$may,
                'jun'=>$jun,
                'jul'=>$jul,
                'aug'=>$aug,
                'sep'=>$sep,
                'oct'=>$oct,
                'sep'=>$sep,
                'oct'=>$oct,
                'nov'=>$nov,
                'dec'=>$dec
                
                
                ) 
            );
        
        echo json_encode($response);   
    


mysqli_close($con);

}

?>