<?php 

require_once 'db_connect.php';

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ){

    $id = $_POST['customer_id'];
    $name = $_POST['customer_name'];
    $cell = $_POST['customer_cell'];
    $email = $_POST['customer_email'];
    $address = $_POST['customer_address'];
    $type_dni = $_POST['type_dni'];
    $dni = $_POST['dni'];
    //$owner_id = $_POST['owner_id']; 

    $validate = true;
    $validate_message = "";

    if ( trim($id) == ''){
        $validate = false;
        $validate_message = 'No se reconoce el Cliente!';
        echo $validate_message;
    } 

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

        // $query = "Update customers set updated_at = now(), user_id = '".trim($owner_id)."', name = '".trim($name)."', email = '".trim($email)."', phone_number = '".trim($cell)."', address = '".trim($address)."', tipo = '".trim($type_dni)."', cedula = '".trim($dni)."' where id = '".trim($id)."'" ;

         $query = "Update customers set updated_at = now(), name = '".trim($name)."', email = '".trim($email)."', phone_number = '".trim($cell)."', address = '".trim($address)."', tipo = '".trim($type_dni)."', cedula = '".trim($dni)."' where id = '".trim($id)."'" ;


        if ( mysqli_query($con, $query) ){
            $response["value"] = "success";
            echo json_encode($response);
        } else {
            $response["value"] = "failure";
          
            echo json_encode($response);
        }
        mysqli_close($con);

    }
    else {
        $response["value"] = "Por favor Validar " . $validate_message;
        echo json_encode($response);
    }


} else {
    $response["value"] = "failure";
    echo json_encode($response);
}

?>