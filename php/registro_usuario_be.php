<?php

    include "conexion_be.php";

    $primer_nombre = $_POST["primer_nombre"];
    $segundo_nombre = $_POST["segundo_nombre"];
    $primer_apellido = $_POST["primer_apellido"];
    $segundo_apellido = $_POST["segundo_apellido"];
    $correo = $_POST["correo"];
    $usuario = $_POST["usuario"];
    $contrasena = $_POST["contrasena"];

    //Encriptamiento de la contraseña
    //$contrasena = hash('sah512', $contrasena);

    $query = "INSERT INTO usuarios(primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, correo, usuario, contrasena)
              VALUES('$primer_nombre', '$segundo_nombre', '$primer_apellido', '$segundo_apellido', '$correo', '$usuario', '$contrasena')";

    //verificar que el correo no se repita en la base de datos
    $verificar_correo = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo='$correo' ");

    if(mysqli_num_rows($verificar_correo) > 0){
        echo '
            <script>
                alert("Este correo ya esta registrado, intenta con otro diferente");
                window.location = "../index.php";
            </script>
        ';
        exit();
    }

     //verificar que el usuario no se repita en la base de datos
     $verificar_usuario = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario='$usuario' ");

     if(mysqli_num_rows($verificar_usuario) > 0){
         echo '
             <script>
                 alert("Este usuario ya esta registrado, intenta con otro diferente");
                 window.location = "../index.php";
             </script>
         ';
         exit();
     }

    $ejecutar = mysqli_query($conexion, $query);

    if($ejecutar){
        echo '
            <script>
                alert("Usuario registrado exitosamente");
                window.location = "../index.php";
            </script>
        ';
    }else{
        echo '
            <script>
                alert("Intentalo de nuevo, usuario no registrado");
                window.location = "../index.php";
            </script>
        ';
    }

    mysqli_close($conexion);
?>