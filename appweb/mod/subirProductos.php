<?php
    require "../inc/initialconfig.php";
    if( !(isset($_SESSION["admin"])&&!empty($_SESSION["admin"]))){
      header('Location: ../../index.php');  
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ArticDev Shop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/appweb/css/styles.css">
    <link rel="stylesheet" href="/appweb/css/styleAdd.css">
</head>
<body>
    <?php include "header.php" ?>
    <div class="contenedor">
           <!--<div id="imgpro">
               <img src="prueba.jpg" alt="">
           </div>-->
           <div id="info">
              <h1>AGREGAR PRODUCTOS</h1>
               <form action="uploadProduct.php" enctype="multipart/form-data" method="POST">
                   <label for="nombre">Nombre</label><br>
                   <input type="text" id="nombre" name="nombre" required><br>
                   <label for="cate">Categoria</label><br>
                   <input list="categoria" name="categorias" pattern="Procesadores|Tarjetas Graficas|Teclados|Mouses" />
                   <datalist id="categoria">
                        <option value="Procesadores">
                        <option value="Tarjetas Graficas">
                        <option value="Teclados">
                        <option value="Mouses">
                        </datalist><br>
                   <label for="img">Imagen del producto</label><br>
                   <input type="file" id="img" name="imagen" require><br>
                   <label for="descript">Descripcion</label><br>
                   <textarea name="descripcion" id="descript" cols="60" rows="5" placeholder="Maximo __ caracteres" required></textarea><br>
                   <input class="btn btn-success btn-lg" type="submit" value="Agregar">
               </form>
           </div>
    </div>
    <?php include "footer.php";?>
    <script src="https://kit.fontawesome.com/791abd0481.js" crossorigin="anonymous"></script>
</body>
</html>