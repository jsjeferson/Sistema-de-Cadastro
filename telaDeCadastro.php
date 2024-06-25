<?php

session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Sistema de cadastro</title>
    <link rel="stylesheet" href="css/estilo.css">
    <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.css">
    <style>
        * {
            margin: 0px;
            padding: 10px;
        }
    </style>
</head>
<!--<body style="background-color: #e3eaf5">-->
<body>
<div class="container-fluid">
    <div class="menu">
       <h1>Sistema de cadastro</h1>
        <div class="row">
            <div id="btn_cad" class="col-md-12">
                <center><a href="cadastroDePessoas.php" id="cad" class="btn btn-info shadow">Casdastrar pessoa</a>
                </center>
            </div>
        </div>
        <div class="row">
            <div id="btn_rel" class="col-md-12">
                <center><a href="gerarRelatorioPdf.php" id="rel" class="btn btn-info shadow">Gerar relatório</a>
                </center>
            </div>
        </div>

    </div>
</div>
<br>
<br>
<br>
<br>
<br>

<divc class="row">
    <div class="col-md-12">
        <center><a href="sair.php" id="sair" class="btn btn-danger shadow">Sair</a></center>
    </div>
</divc>

</div>
</body>
</html>




