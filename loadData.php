<?php

use App\DBConnection;
use App\Data;

require 'vendor/autoload.php';
  
$db = new DBConnection();
$data = new Data($db);

if(isset($_GET["onoff"])) {
    $OnOff = $_GET["onoff"];
    if($OnOff == 1) {
        $data ->insertData();
    } else {
        $data->stopLoading();
        $data->loadTransaction();
    }
} else {
    $progress = $data->getProgress();
    if(!empty($progress)) {
        echo $progress;
    }
}


?>
