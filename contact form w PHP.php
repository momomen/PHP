<?php

$error = "";

$successmessage = "";

    
    if ($_POST) {
        
        
        if ($_POST['email']) {
            
            $error .= "The email field is required.<br>";
            
        }
        
        if ($_POST['subject']) {
            
            $error .= "The subject field is required.<br>";
            
        }
            
        if ($_POST['content']) {
            
            $error .= "The content field is required.<br>";
            
        }
        
       if ($_POST['email'] && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
            
            $error .= "The email address is invalid.<br>";
            
        }
        
        if ($error != "") {
            
            $error =  '<div class="alert alert-danger" role="alert"><b>There were error(s) in your form:</b><br>'. $error .'</div>';
            
        } else {
            
            $emailTo = "me@mydomain.com";
            
            $subject = $_POST['subject'];
            
            $content = $_POST['content'];
            
            $headers = "From: ".$_POST['email'];
            
            if (mail($emailTo, $subject, $content, $headers)) {
                
                $successmessage = '<div class="alert alert-success" role="alert">Your message was sent. We will get back to you ASAP!</div>';
            
            } else {
                
                $error = '<div class="alert alert-danger" role="alert">Your message wasn\'nt sent. Please try again soon!</div>';
            
            }
        }
        
    }
    
    
    
?>

<html lang="en">
    
  <head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Contact Form</title>
      
      <style type="text/css">
          
        
          
          
      </style>
      
      
  </head>

  <body>
      
      <div class="container">
          
        <h1 class="display-5">Get in touch!</h1>
          
        <div id="error"><? echo $error.$successmessage; ?></div>
          
        <form method="post">
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" class="form-control" id="subject" name="subject">
            </div>
            <div class="form-group">
                <label for="content">What would you like to ask us?</label>
                <textarea class="form-control" id="content" name="content" rows="3"></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary" id="submit">Submit</button>
            
        </form>
      </div>
    
    
      
      
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
      
    <script type="text/javascript">
        
        
        $("form").submit(function (e) {
      
            
            var errormessage = "";
            
            if ($("#email").val() == "") {
                
                errormessage += "The email field is required.<br>";
                
            }
            
            if ($("#subject").val() == "") {
                
                errormessage += "The subject field is required.<br>";
                
            }
            
            if ($("#content").val() == "") {
                
                errormessage += "The content field is required.<br>";
                
            }
            
            if (isEmail($("#email").val()) == false && $("#email").val() != "") {
                
                errormessage += "You E-mail is not valid!<br>";
                
            }
            
            if (errormessage != "") {
                
                
                $("#error").html('<div class="alert alert-danger" role="alert"><b>There were error(s) in your form:</b><br>'+ errormessage +'</div>');
                
                return false;
                
            } else {
                
                return true;
                
            }
            
        });
          
          
    
    </script>
      
  </body>
</html