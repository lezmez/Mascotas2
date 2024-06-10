<?php
    session_start();

    include "conexion_be.php";

    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    $result = mysqli_query($conexion, "SELECT usuarios.nombre_completo, cargo.descripcion  FROM usuarios INNER JOIN cargo ON(usuarios.id_cargo=cargo.id) WHERE usuario='$usuario'
    and contrasena='$contrasena' ");
    $row = $result -> fetch_array(MYSQLI_ASSOC);
   

    if(mysqli_num_rows($result) > 0){
        $_SESSION['usuario'] = $usuario;       
        //header("location: ../bienvenida.php");
        //exit();
       if ($row['descripcion'] == 'Administrador'){
        header("location: ../bienvenida.php");
        exit();
       }
       else{
        header("location: ../bienvenida_cliente.php");
        exit();
       
       } 
    }else{
        echo '
            <script>
                alert("Usuario no existe, por favor verifique los datos introducidos");
                window.location = "../index.php";
            </script>
        ';
        exit();
    }

?>