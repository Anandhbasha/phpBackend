<?php
include("../config/db.php");

$title = $_POST['Title'];
$price = $_POST['Price'];
$category = $_POST['Category'];
$type = $_POST['type'];
$description = $_POST['Description'];

$imageName = "";

if(isset($_FILES['Image']))
{
    $imageName = time()."_".$_FILES['Image']['name'];

    move_uploaded_file(
        $_FILES['Image']['tmp_name'],
        "../uploads/".$imageName
    );
}

$stmt = $conn->prepare("
INSERT INTO products
(Title,Price,Category,type,Description,Image)
VALUES(?,?,?,?,?,?)
");

$stmt->bind_param(
"sissss",
$title,
$price,
$category,
$type,
$description,
$imageName
);

$stmt->execute();

echo json_encode([
"success"=>true
]);
?>