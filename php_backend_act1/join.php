<?php
include('conn.php');

if(isset($_GET['accion'])){
    $accion = $_GET['accion']; // Lo que le pase al URL lo va a tomar con esta palabra GET

    // Nueva acción "join" para mostrar los datos de los vehículos que pertenecen a un cliente
    if($accion == 'join'){
        // Verificar si el ID del cliente está presente en la URL
        if(isset($_GET['id_clientes'])){
            $id_clientes = $_GET['id_clientes'];

            // Preparar la consulta SQL
            $sql = "SELECT autos.* FROM autos
                    JOIN propiedad_autos ON autos.id = propiedad_autos.id_autos
                    WHERE propiedad_autos.id_clientes = '$id_clientes'";

            // Ejecutar la consulta
            $result = $db->query($sql);

            // Verificar si se encontraron resultados
            if($result->num_rows > 0){
                $autos = array(); // Inicializar la lista de autos
                while($row = $result->fetch_assoc()){
                    $autos[] = $row; // Añadir cada auto a la lista
                }
                $response["status"] = "Ok";
                $response["autos"] = $autos;
            } else {
                $response["status"] = "Error";
                $response["mensaje"] = "No se encontraron autos para el cliente especificado";
            }
        } else {
            $response["status"] = "Error";
            $response["mensaje"] = "ID del cliente no proporcionado";
        }
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
}
