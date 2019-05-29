<?php 
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

$package_table=mysqli_query($con,"select * from ttg_packages");
if(mysqli_error($con))
   {
        die(mysqli_error($con));
   }

if($package_table){
    echo "<table>";
     echo "<tr><th>Title</th><th>Price</th><th>Date</th><th>Actions</th></tr>";
    while($r=mysqli_fetch_row($package_table)){
        
        echo "<tr><td>$r[0]</td><td>$r[3]</td><td>$r[4]</td><td><a href=\"?page=package-settings&ttg-page=2.php&package-id=$r[5]\">Edit</a>  <a href=\"?page=package-settings&ttg-page=delete.php&package-id=$r[5]\">Delete</a></td></tr>";

    }
    echo "</table>";
}

?>
<a href="?page=package-settings&ttg-page=add.php"><button>Add Package</button></a>