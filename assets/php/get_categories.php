<?php
include("server_data.php");
include("query_sql.php");

$sql = "SELECT news.category FROM news";
$results = ConsultarSQL($servidor, $usuario, $contrasena, $basedatos, $sql);

$categories = array();
foreach ($results as $result){
    $categories[]=$result["category"];
}
$categories = array_unique($categories);

$format = '<div class="d-flex justify-content-between align-items-center p-4 w-100 h-100 flex-wrap">';
foreach ($categories as $category){
    $format .= '<div class="d-flex justify-content-center align-items-center rounded rounded-pill categoria-label p-3 text-center">
                    ' . $category . '
                </div>';
}
$format .= '</div>';
echo $format;


