<?php

    session_start();

    $error = "";

    if (array_key_exists("logout", $_GET)){
        
        unset($_SESSION);
        setcookie('id', '', time()-60*60);
        $_COOKIE["id"] = "";
        
    } else if(array_key_exists('id', $_SESSION) AND $_SESSION['id'] OR array_key_exists('id',$_COOKIE) AND $_COOKIE['id']) {
        
        header("Location: session.php");
        
    };

    if (array_key_exists('submit',$_POST)){
        
        include("connection.php");
        
        if (!$_POST['email']) {
            
            $error .= "<p>An email adress is required.</p>";
            
        };
            
        if (!$_POST['password']){
            
            $error .= "<p>A password is required</p>";
            
        };
        
        if ($error != ""){
            
            $error = "<p>There were error(s) in your form:</p>".$error;
            
        } else {
            
            if ($_POST['signup'] == '1') {
            
                $query = "SELECT `id` FROM users WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."' LIMIT 1";

                $result = mysqli_query($link, $query);

                if (mysqli_num_rows($result) > 0) {

                    $error = "<p>Email address is already registered!!</p>";

                } else {

                    $query = "INSERT INTO `users` (`email`,`password`) VALUES ('".mysqli_real_escape_string($link, $_POST['email'])."', '".mysqli_real_escape_string($link, $_POST['password'])."')";

                    if (!mysqli_query($link, $query)) {

                       $error = "<p>Could not sign you up. Please try again later.";

                    } else {

                        $query = "UPDATE `users` SET password = '".md5(md5(mysqli_insert_id($link)).$_POST['password'])."' WHERE id = ".mysqli_insert_id($link)." LIMIT 1";

                        mysqli_query($link, $query);

                        $_SESSIONS['id'] = mysqli_insert_id($link);

                        if (array_key_exists('checkbox', $_POST)) {

                            setcookie('id', mysqli_insert_id($link), time()+ 60*60*24*365);

                        }

                        header("Location: session.php");

                    };

                };
                
            } else {
                
                $query = "SELECT id FROM `users` WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."'";
                
                $result = mysqli_query($link, $query);
                
                $row = mysqli_fetch_array($result);
                
                if (isset($row)) {
                    
                    $hashedPassword = md5(md5($row['id']).$_POST['password']);
                         
                    if ($hashedPassword OR $_POST['password'] == $row['password']) {
                        
                        $_SESSION['id'] = $row['id'];
                        
                        if (array_key_exists('checkbox', $_POST)) {

                            setcookie('id', $row['id'], time()+ 60*60*24*365);

                        }

                        header("Location: session.php");
                        
                    } else {
                        
                        $error = "<p>That email/password combination could not be found!</p>";
                        
                    }
                    
                } else {
                    
                    $error = "<p>That email/password combination could not be found!</p>";
                    
                }
                
            };
        
        };
    
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
                
                text-align: center;
                background: none;
                color: white;
                
            }
            
            .container {
                
                width: 450px;
                margin-top: 125px;
                
            }
            
            #signUpLink{
                
                display: none;
                
            }
            
            #login{
                
                display: none;
                
            }
            
            
            #landingText {
                
                font-size: 17px;
                
            }
            
        </style>

    </head>
      
    <body>
        
        <div class="container">
            
            <h1>Secret Diary</h1>
            
            <p id="landingText"><b>Store your thoughts permanently and securely</b></p>
        
            <div id="error" class="alert alert-danger"><?php echo $error; ?></div>

            <form  class="form-group" method="post" id="signUp">
                
                <p>Interested? Sign-up now.</p>
                
                <div class="form-group">
                    <label for="email" class="sr-only">Email</label>
                    <input  id="email" class="form-control" type="email" name="email" placeholder="name@example.com">
                </div>
                
                <div class="form-group">
                    <label for="password" class="sr-only">Password</label>
                    <input id="password" class="form-control" type="password" name="password" placeholder="Password">
                </div>

                <input type="hidden" name="signup" value="1">
                
                <div class="form-check my-3">
                    <input type="checkbox" class="form-check-input" id="cb1" name="checkbox" value="1">
                    <label class="form-check-label" for="cb1">Stay logged in</label>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success" name="submit">Sign Up</button>
                </div>

            </form>
            
            <a href="#login" id="loginLink" class="text-white"><b>Log in</b></a>

            <form  class="form-group" method="post" id="login">
                
                <p>Log in using your username and password.</p>
                
                <div class="form-group">
                    <label for="email1" class="sr-only">Email</label>
                    <input  id="email1" class="form-control" type="email" name="email" placeholder="name@example.com">
                </div>
                
                <div class="form-group">
                    <label for="password1" class="sr-only"></label>
                    <input id="password1" class="form-control" type="password" name="password" placeholder="Password">
                </div>

                <input type="hidden" name="signup" value="0">

                <div class="form-check mb-3">
                    <input type="checkbox" id="cb2" class="form-check-input" name="checkbox" value="1">
                    <label for="cb2" class="form-check-label">Stay logged in</label>
                </div>

                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-success">log in!</button>
                </div>
                
                <a href="#signUp" id="signUpLink" class="text-white"><b>Sign Up</b></a>
                

            </form>
        
        </div>
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
      
    <script type="text/javascript">
        
        $("#loginLink").click(function(){
            
            $("#signUpLink").show();
            $("#signUp").hide();
            $("#login").show();
            $("#loginLink").hide();
            
        });
        
        $("#signUpLink").click(function(){
            
            $("#signUpLink").hide();
            $("#signUp").show();
            $("#login").hide();
            $("#loginLink").show();
            
        });
        
        if ($("#error").html() == "") {
            
            $("#error").hide();
            
        } else {
            
            $("#error").show();
        };
        
    </script>
        
    </body>

</html>