<?php

include("../config/db.php");

$id = $_GET['id'];

$stmt = $conn->prepare(
"DELETE FROM products WHERE id=?"
);

$stmt->bind_param("i",$id);
$stmt->execute();

echo json_encode([
"success"=>true
]);

?>