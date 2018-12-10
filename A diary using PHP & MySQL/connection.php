<?php

$link = mysqli_connect("localhost", "root", "", "users");
    
        if (mysqli_connect_error()) {
            
            die ("Connection has failed");   
        };
        
?>