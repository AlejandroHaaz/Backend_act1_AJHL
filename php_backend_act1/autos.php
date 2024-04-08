<?php
include('conn.php');


//Hay que preguntarle si una variable está definido
//Verificamos la acción
if(isset($_GET['accion'])){
    $accion = $_GET['accion'];// lo que le pase al URL lo va a tomar con esta palabra GET
    
        //leer los datos de la  tabla usuario
        if($accion=='leer'){
            $sql = "SELECT * FROM autos WHERE 1"; //
            $result = $db->query($sql);

            //Si hay más de un resultado que los muestre, pero en caso de que no haya mostrar que no hay alumnos
            if($result -> num_rows>0){
                while($fila = $result -> fetch_assoc()){
                    $item['id'] = $fila['id'];
                    $item['marca'] = $fila['marca'];
                    $item['modelo'] = $fila['modelo'];
                    $item['año'] = $fila['año'];
                    $item['no_serie'] = $fila['no_serie'];
                    $arrautos[] = $item;
                }
                $response["status"] = "Ok";
                $response["mensaje"] = $arrautos;
            }else{
                $response["status"] = "Error";
                $response["mensaje"] = "No hay autos registrados";
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
            $marca = $data["marca"];
            $modelo = $data["modelo"];
            $año = $data["año"];
            $no_serie = $data["no_serie"];

            $qry = "INSERT INTO autos (marca, modelo, año, no_serie) VALUES ('$marca','$modelo','$año','$no_serie')";

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
    $marca = $data["marca"];
    $modelo = $data["modelo"];
    $año = $data["año"];
    $no_serie = $data["no_serie"];

    $qry = "UPDATE autos SET marca = '$marca', modelo = '$modelo', año = '$año', no_serie = '$no_serie' where id = '$id'";
    
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

    $qry = "DELETE FROM autos WHERE id = '$id'";

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
