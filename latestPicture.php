<?php

include_once('config.php');

$conn = new mysqli(MYSQL_HOST, MYSQL_DB, MYSQL_USER, MYSQL_PASS);
$sql = 'SELECT filename, type FROM pictures WHERE (id=(SELECT MAX(id) FROM pictures))';
$r = $conn->query($sql);
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

?>
