<?php
/*
Call this script with /getPicture.php?pic=<index>
Returns the picture with index = MAX_ID - <index>
*/
include_once 'config.php';

$conn = new mysqli(MYSQL_HOST, MYSQL_DB, MYSQL_USER, MYSQL_PASS);

//Get max index of stored images
$sql1 = 'SELECT MAX(id) FROM pictures';
$maxId = -1;
$r = $conn->query($sql1);
if ($r->num_rows > 0) {
    $row = $r->fetch_array();
    $maxId = $row[0];
}

// Get the image specified in the request (pic)
if ($maxId >= 0) {
    if (isset($_GET['pic'])) {
        $pic = $_GET['pic'];
        $index = $maxId - $pic;
        $sql2 = 'SELECT * FROM pictures WHERE (id='.$index.')';
        $r = $conn->query($sql2);
        $id = '';
        $time = '';
        $type = '';
        if ($r->num_rows > 0) {
            $row = $r->fetch_assoc();
            $id = $row['id'];
            $time = $row['date'];
            $type = $row['type'];
        }
        $conn->close();
        $data = array('id' => $id, 'timestamp' => $time, 'type' => $type);
        header('Content-type: text/javascript');
        echo json_encode($data);
    }
}
