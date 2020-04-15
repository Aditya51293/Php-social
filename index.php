<?php

$conn=mysqli_connect("localhost:3309","root","","social");

$query="INSERT INTO test VALUES(1,'aditya')";

if(mysqli_connect_errno()){
    echo "connection to db failed".mysqli_connect_errno();
}

$stmt=mysqli_query($conn,$query);

?>




<html>
<head>
    <title>Swirlfeed</title>
</head>

<body>
</body>
</html>