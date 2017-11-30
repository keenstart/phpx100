<?php

use App\DBConnection;
use App\Data;

require 'vendor/autoload.php';
    set_time_limit(30);
    session_start();

    $db = new DBConnection();
    $data = new Data($db);
    $data->stopLoading();
    $data->loadTransaction();
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="sqlitetutorial.net">
        <title>PHP Demo for Admixt</title>
        <link href="http://v4-alpha.getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="res/css/index.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="res/js/scripts.js"></script>
 
    </head>
    <body>
        <div class="container">
            <div id="OnOff" hidden>1</div>
            <div class="row">
                <div class="btn-group-horizontal xybutton">
                    <button id="loadMillion" class="btn btn-primary" >Click to Insert 1Mil rows</button> 
                </div>
            </div>  
            <br>

            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
            </div> 

            <br> 
            <div class = "Ajax">
                <div class="row">    
                    <div class="btn-group-horizontal xybutton">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">#</span>
                            <input id="userID" type="text" class="form-control" placeholder="Enter User ID 1 - 100" aria-label="UserID" aria-describedby="basic-addon1">
                            <button id="loadajax" class="btn btn-primary" >Load UserID from Ajax</button> 
                        </div>
                    </div>
                </div>
                <br>
                <div class="ajaxTable" >
                    <div class="page-header">
                        <h1>User Transaction Demo</h1>
                    </div>
         
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Transacction ID</th>
                                <th>Transacction Detail</th>
                                <th>user ID</th>
                                <th>Username</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
     
                        </tbody>
                    </table>                
                </div>
            </div>
        </div>
    </body>
</html>