<?php
include('conn.php');


//Hay que preguntarle si una variable está definido
//Verificamos la acción
if(isset($_GET['accion'])){
    $accion = $_GET['accion'];// lo que le pase al URL lo va a tomar con esta palabra GET
    
        //leer los datos de la  tabla usuario
        if($accion=='leer'){
            $sql = "SELECT * FROM propiedad_autos WHERE 1"; //
            $result = $db->query($sql);

            //Si hay más de un resultado que los muestre, pero en caso de que no haya mostrar que no hay alumnos
            if($result -> num_rows>0){
                while($fila = $result -> fetch_assoc()){
                    $item['id'] = $fila['id'];
                    $item['id_autos'] = $fila['id_autos'];
                    $item['id_clientes'] = $fila['id_clientes'];
                    $arrpropiedad[] = $item;
                }
                $response["status"] = "Ok";
                $response["mensaje"] = $arrpropiedad;
            }else{
                $response["status"] = "Error";
                $response["mensaje"] = "No hay datos registrados";
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
            $id_autos = $data["id_autos"];
            $id_clientes = $data["id_clientes"];
    
            $qry = "INSERT INTO propiedad_autos (id_autos, id_clientes) VALUES ('$id_autos','$id_clientes')";

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
    $id_autos = $data["id_autos"];
    $id_clientes = $data["id_clientes"];

    $qry = "UPDATE propiedad_autos SET id_autos = '$id_autos', id_clientes = '$id_clientes' WHERE id = '$id'";
    
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

    $qry = "DELETE FROM propiedad_autos WHERE id = '$id'";

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

