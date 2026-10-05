<?php

header("Content-Type: application/json; charset=utf-8");

if (empty($_GET["codigo"])) {
    http_response_code(400);
    echo json_encode(["error" => "falta el parametro 'codigo'"]);
    exit;
}

$codigo = trim($_GET["codigo"]);

//NOS CONECTAMOS A LA BASE DE DATOS
$con = mysqli_connect("localhost", "root", "", "database");

if (!$con) {
    http_response_code(500);
    echo json_encode(["error" => "error de conexion a la base de datos"]);
    exit;
}

mysqli_set_charset($con, "utf8mb4");

$consulta = mysqli_prepare($con, "SELECT `FROM` FROM `table` WHERE `SELECT` = ?");

mysqli_stmt_bind_param($consulta, "s", $codigo);

mysqli_stmt_execute($consulta);

$resultado = mysqli_stmt_get_result($consulta);

$colonias = [];

while ($row = mysqli_fetch_assoc($resultado)) {
    $colonias[] = $row["FROM"];
}

echo json_encode($colonias, JSON_UNESCAPED_UNICODE);

mysqli_stmt_close($consulta);

mysqli_close($con);

?>