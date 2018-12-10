<?php

session_start();

$diaryContent = "";

if (array_key_exists('id', $_COOKIE) && $_COOKIE['id']) {
    
    $_SESSION['id'] = $_COOKIE['id'];
    
};

if (array_key_exists('id', $_SESSION) && $_SESSION['id']) {
    
    $success =  "You are logged in. <a href='SD-1.php?log out=1' class='text-white'><b>Log out</b></a>";
    
    include("connection.php");
    
    $query = "SELECT diary FROM `users` WHERE id = ".mysqli_real_escape_string($link, $_SESSION['id'])." LIMIT 1";
    
    $row = mysqli_fetch_array(mysqli_query($link, $query));
    
    $diaryContent = $row['diary'];
    
} else {
    
    header("Location: SD-1.php");
    
};

?>


<html lang="en">
    
    <head>
    
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <title>Secret Diary!</title>
        
        <style type="text/css">
            
            html { 
              
              background: url(pic.jpg) no-repeat center center fixed; 
              -webkit-background-size: cover;
              -moz-background-size: cover;
              -o-background-size: cover;
              background-size: cover;
          }
            
            body {
                
                background: none;
                
            }
            
            #textArea{
                
                margin-top: 15px;
                width: 100%;
                height: 100%;
                
            }
            
        </style>

    </head>
      
    <body>
        
        <!--<p id="success"><?php// echo $success; ?></p>-->
        
        <nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-between">
            <a class="navbar-brand" href="session.php">Secret Diary</a>
            <button class="navbar-toggler" type="button" name="submit" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            
            
            <a href="SD-1.php?logout=1"><button class="btn btn-outline-success my-2 my-sm-0" type="submit">Logout</button></a>
            
        </nav>
        
        <div class="container-fluid">
        
            <textarea class="form-control" id="textArea"><?php echo $diaryContent; ?></textarea>
        
        </div>
        
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
      
    <script type="text/javascript">
        
        $('#textArea').bind('input propertychange', function() {

            $.ajax({
                method: "POST",
                url: "updatedatabase.php",
                data: { content: $('#textArea').val() }
            });
            
        });
        
    </script>
        
    </body>

</html>
