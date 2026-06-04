<?php
include("../config/db.php");

$id = $_POST['id'];

$title = $_POST['Title'];
$price = $_POST['Price'];
$category = $_POST['Category'];
$type = $_POST['type'];
$description = $_POST['Description'];

$imageName = $_POST['oldImage'];

if(isset($_FILES['Image']))
{
    $imageName = time()."_".$_FILES['Image']['name'];

    move_uploaded_file(
        $_FILES['Image']['tmp_name'],
        "../uploads/".$imageName
    );
}

$stmt = $conn->prepare("
UPDATE products
SET
Title=?,
Price=?,
Category=?,
type=?,
Description=?,
Image=?
WHERE id=?
");

$stmt->bind_param(
"sissssi",
$title,
$price,
$category,
$type,
$description,
$imageName,
$id
);

$stmt->execute();

echo json_encode([
"success"=>true
]);
?>