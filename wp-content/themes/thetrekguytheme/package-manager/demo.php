<?php 
$title=!empty($_POST["title"])?$_POST["title"]:die("Please enter title");
$image=!empty($_POST["image"])?$_POST["image"]:die("Please choose an image");
$description=!empty($_POST["description"])?$_POST["description"]:die("Please enter description");
$price=!empty($_POST["price"])?$_POST["price"]:die("Please enter price");
$date=!empty($_POST["date"])?$_POST["date"]:die("Please enter date");
$id=!empty($_POST["package-id"])?$_POST["package-id"]:die("Did not recive package id");

$con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

if(!$con)
    die("Unable to connect to database.");

$r=mysqli_query($con,"CREATE TABLE IF NOT EXISTS ttg_packages(
        title varchar(100),
        image varchar(100),
        description varchar(1999),
        price varchar(100),
        date varchar(100)
       )");
if(mysqli_error($con))
   {
        die(mysqli_error($con));
   }

$r=mysqli_query($con,"update ttg_packages set title='$title',description='$description',price='$price',date='$date', image='$image' where id=$id");
if(mysqli_error($con))
   {
        die(mysqli_error($con));
   }
if($r)
echo "Updated!";
else
echo "No Match";
?>

<a href="?page=package-settings"><button>Go Back</button></a>
