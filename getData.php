<?php

use App\DBConnection;
use App\Data;

require 'vendor/autoload.php';
  
$db = new DBConnection();
$data = new Data($db);

$user_id = $_GET["userid"]; 

$result = [];

$result = $data->getUserTransaction($user_id);

echo json_encode($result);

?>
