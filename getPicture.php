<?php
/*
Call this script with /getPicture.php?pic=<index>
Returns the picture with index = MAX_ID - <index>
*/
include_once('config.php');

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
if($maxId >= 0){
    if(isset($_GET['pic'])){
        $pic = $_GET['pic'];
        $index = $maxId - $pic;
        $sql2 = 'SELECT filename, type FROM pictures WHERE (id=' . $index . ')';
        $r = $conn->query($sql2);
        $file = ROOT_DIRECTORY;
        if ($r->num_rows > 0) {
            $row = $r->fetch_assoc();
            $file .= $row['filename'];
        }
        $conn->close();
        $type = 'image/jpeg';
        ob_clean();
        header('Content-Type: '.$type);
        if (file_exists($file)) {
            readfile($file);
        }
    }
}

?>
