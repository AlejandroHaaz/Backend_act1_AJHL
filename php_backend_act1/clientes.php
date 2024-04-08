<?php
include('conn.php');


//Hay que preguntarle si una variable está definido
//Verificamos la acción
if(isset($_GET['accion'])){
    $accion = $_GET['accion'];// lo que le pase al URL lo va a tomar con esta palabra GET
    
        //leer los datos de la  tabla usuario
        if($accion=='leer'){
            $sql = "SELECT * FROM clientes WHERE 1"; //
            $result = $db->query($sql);

            //Si hay más de un resultado que los muestre, pero en caso de que no haya mostrar que no hay alumnos
            if($result -> num_rows>0){
                while($fila = $result -> fetch_assoc()){
                    $item['id'] = $fila['id'];
                    $item['nombre'] = $fila['nombre'];
                    $item['email'] = $fila['email'];
                    $arrclientes[] = $item;
                }
                $response["status"] = "Ok";
                $response["mensaje"] = $arrclientes;
            }else{
                $response["status"] = "Error";
                $response["mensaje"] = "No hay clientes registrados";
            }
        }
        header('Content-Type: application/json');
        echo json_encode($response); //
        
        if($accion=='insertar'){
        
        }
}

//Si yo paso los datos como JSON a traves del body
$data=json_decode(file_get_contents('php://input'), true);
if(isset($data)){

    //obtengo la acción
    $accion = $data["accion"];

    //verifico el tipo de acción
if($accion=='insertar'){
            //obtener los demas datos del body
            $nombre = $data["nombre"];
            $email = $data["email"];
    
            $qry = "INSERT INTO clientes (nombre, email) VALUES ('$nombre','$email')";

            if($db->query($qry)){
                $response["status"] = 'OK';
                $response["mensaje"] = 'El registro se creo correctamente';
            }else{
                $response["status"] = 'ERROR';
                $response["mensaje"] = 'No se pudo guardar el regisro debido a un error';
            }

            header('Content-Type: applidation/json');
            echo json_encode($response);

    }
 }

 if($accion == 'modificar'){
    $id = $data["id"];
    $nombre = $data["nombre"];
    $email = $data["email"];

    $qry = "UPDATE clientes SET nombre = '$nombre', email = '$email' WHERE id = '$id'";
    
    if($db->query($qry)){
        $response["status"] = 'OK';
        $response["mensaje"] = 'El registro se modifico correctamente';
    }
    else{
        $response["status"] = 'ERROR';
        $response["mensaje"] = 'El registro no se modifico correctamente';
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

if($accion=='borrar'){
    //obtener los demas datos del body
    $id = $data["id"];

    $qry = "DELETE FROM clientes WHERE id = '$id'";

    if($db->query($qry)){
        $response["status"] = 'OK';
        $response["mensaje"] = 'El registro se creo correctamente';
    }else{
        $response["status"] = 'ERROR';
        $response["mensaje"] = 'No se pudo guardar el regisro debido a un error';
    }

    header('Content-Type: applidation/json');
    echo json_encode($response);

}
