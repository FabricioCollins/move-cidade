<?php
header('Content-Type: application/zip; charset=UTF-8');
header('Content-Disposition: attachment; filename="movecidade_dump.zip"');
header('Pragma: no-cache');
header('Expires: 0');
error_reporting(E_ALL | E_STRICT);

include_once ('database_access.php');
include_once ('utils.php');

$db = new database_access();
$db->open();

$result = $db->get_database_dump();

print($result);

$db->close();
?>