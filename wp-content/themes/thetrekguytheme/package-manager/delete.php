<?php 

$id=!empty($_GET["package-id"])?$_GET["package-id"]:die("Please enter package id");

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

$r=mysqli_query($con,"delete from ttg_packages where id=$id");
if(mysqli_error($con))
   {
        die(mysqli_error($con));
   }

echo "Deleted"




?>

<a href="?page=package-settings"><button>Go Back</button></a>
