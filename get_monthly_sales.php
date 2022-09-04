<?php 


if ($_SERVER['REQUEST_METHOD'] == 'GET' ){
        require_once 'db_connect.php';


        $shop_id =  $_GET['shop_id'];
        $owner_id = $_GET['owner_id'];  
        $year = $_GET['yearly'];  
  
     //set default time zone
  date_default_timezone_set("Asia/Dhaka");
  
  //get current timedate
  $current_time=date("h:i A");
  
  //get current date
  $current_date=date("Y-m-d");
  
  
        // $getReportType= $_GET['type'];
        include('my_function.php');

        
         $total_order_price=getOrderPriceByType('all',$shop_id,$year);
         $total_discount=getDiscountPriceByType('all',$shop_id,$year);
         $total_tax=getTaxPriceByType('all',$shop_id,$year);

 


         $jan=getMonthlySalesAmount('1',$year,$shop_id);
         $feb=getMonthlySalesAmount('2',$year,$shop_id);
         $mar=getMonthlySalesAmount('3',$year,$shop_id);
         $apr=getMonthlySalesAmount('4',$year,$shop_id);
         $may=getMonthlySalesAmount('5',$year,$shop_id);
         $jun=getMonthlySalesAmount('6',$year,$shop_id);
         $jul=getMonthlySalesAmount('7',$year,$shop_id);
         $aug=getMonthlySalesAmount('8',$year,$shop_id);
         $sep=getMonthlySalesAmount('9',$year,$shop_id);
         $oct=getMonthlySalesAmount('10',$year,$shop_id);
         $nov=getMonthlySalesAmount('11',$year,$shop_id);
         $dec=getMonthlySalesAmount('12',$year,$shop_id);
         
        
        
      
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
                'dec'=>$dec,
                'total_order_price'=>$total_order_price, 
                'total_tax'=>$total_tax, 
                'total_discount'=>$total_discount
                ) 
            );
        
        echo json_encode($response);   
    


mysqli_close($con);

}

?>