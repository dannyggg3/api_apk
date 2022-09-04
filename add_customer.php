<?php 

require_once 'db_connect.php';

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ){

    $name = $_POST['customer_name'];
    $cell = $_POST['customer_cell'];
    $email = $_POST['customer_email'];
    $address = $_POST['customer_address'];
    $type_dni = $_POST['type_dni'];
    $dni = $_POST['dni'];
    // $shop_id = $_POST['shop_id'];
    // $owner_id = $_POST['owner_id'];     

    $validate = true;
    $validate_message = "";

    if ( trim($dni) == ''){
        $validate = false;
        $validate_message = 'La Identificación del Cliente es Requerida!';
        echo $validate_message;
    } 

    if ( trim($type_dni) == ''){
        $validate = false;
        $validate_message = 'El Tipo de Identificación del Cliente es Requerido!';
        echo $validate_message;
    } 

    if ( trim($name) == ''){
        $validate = false;
        $validate_message = 'El Nombre del Cliente es Requerido!';
        echo $validate_message;
    } 

    if ( trim($cell) == ''){
        $validate = false;
        $validate_message = 'El Número Celular del Cliente es Requerido!';
        echo $validate_message;
    } 

    if ( trim($email) == ''){
        $validate = false;
        $validate_message = 'El Email del Cliente es Requerido!';
        echo $validate_message;
    } 

    if ( trim($address) == ''){
        $validate = false;
        $validate_message = 'La Dirección del Cliente es Requerida!';
        echo $validate_message;
    }

    if ( $validate ) {
         
        $query = "SELECT id FROM customers  WHERE  cedula = '".trim($dni)."'";
         
        $result = mysqli_query($con, $query);
        $response = array();
        $id_customer = 0;
        while( $row = mysqli_fetch_assoc($result) ){
            $id_customer = $row['id'];
        }

        if($id_customer > 0)
        {
            $query = "Update customers set updated_at = now(), name = '".trim($name)."', email = '".trim($email)."', phone_number = '".trim($cell)."', address = '".trim($address)."', tipo = '".trim($type_dni)."' where id = '".trim($id_customer)."'" ;
        }
        else
        {
            //customer_group_id = 1 => Estandar
            //city = '-'
            $query = "INSERT INTO customers (created_at, updated_at, city, customer_group_id, name,email,phone_number,address,tipo,cedula,user_id) VALUES (now(), now(), '-', 1, '$name','$email','$cell','$address','$type_dni','$dni',1)";
        }

        if ( mysqli_query($con, $query) ){
          
                $response["value"] = "success";
           
            echo json_encode($response);
        } else {
            $response["value"] = "failure";
            $response["massage"] = "Por favor Validar " . $validate_message;
            echo json_encode($response);
        }
    }

    mysqli_close($con);

} else {
    $response["value"] = "failure";
    $response["massage"] = "Por favor Validar el Típo de Método";
    echo json_encode($response);
}

?>