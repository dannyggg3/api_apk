<?php 


if ($_SERVER['REQUEST_METHOD'] == 'GET' ){
require_once 'db_connect.php';

   $search_text = $_GET['search_text'];
   $shop_id = $_GET['shop_id'];
   $owner_id = $_GET['owner_id'];  
  
  if(strlen($search_text)>1)
  {
       $query = "SELECT * FROM expense  WHERE  shop_id='$shop_id' AND owner_id='$owner_id' AND (expense_name LIKE '%$search_text%'  OR expense_note LIKE '%$search_text%' ) ";
  }
  else
  {
         $query = "SELECT * FROM expense WHERE shop_id='$shop_id' AND owner_id='$owner_id' ORDER BY expense_id DESC";
  }

        
        
        $result = mysqli_query($con, $query);
        $response = array();
        while( $row = mysqli_fetch_assoc($result) ){
            array_push($response, 
            array(
                'expense_id'=>$row['expense_id'], 
                'expense_name'=>$row['expense_name'], 
                'expense_note'=>$row['expense_note'], 
                'expense_amount'=>$row['expense_amount'], 
                'expense_date'=>$row['expense_date'],
                'expense_time'=>$row['expense_time']
                ) 
            );
        }
        echo json_encode($response);   
    


mysqli_close($con);

}

?>