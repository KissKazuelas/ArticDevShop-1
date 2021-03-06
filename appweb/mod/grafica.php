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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>
</head>
<body>
    <?php include "header.php" ?>
    <div class="contenedor">
           <div id="info">
              <h1>VENTAS</h1>
              <canvas id="myChart" width="400" height="400"></canvas>
           </div>
    </div>
    <?php include "footer.php";?>
    <script src="https://kit.fontawesome.com/791abd0481.js" crossorigin="anonymous"></script>
    <script>
        var ctx= document.getElementById("myChart").getContext("2d");
        var myChart= new Chart(ctx,{
            type:"pie",
            data:{
                labels:['GPU','Procesadores','Teclados',],
                datasets:[{
                        data:[10,9,15],
                        backgroundColor:[
                            'rgb(66, 134, 244,1)',
                            'rgb(74, 135, 72,1)',
                            'rgb(229, 89, 50,1)'
                        ]
                }]
            },
            options:{
                scales:{
                    yAxes:[{
                            ticks:{
                                beginAtZero:true
                            }
                    }]
                }
            }
        });
    </script>
</body>
</html>