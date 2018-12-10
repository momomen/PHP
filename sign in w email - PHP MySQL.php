<?php

    session_start();


    if (array_key_exists('email',$_POST) || array_key_exists('password', $_POST)){
        
        $link = mysqli_connect("localhost", "root", "", "users");
    
        if (mysqli_connect_error()) {
            die ("Connection has failed");   
        };
        
        if ($_POST['email'] == "") {
            
            echo "<p>Email adress is required.</p>";
            
        } else if ($_POST['password'] == ""){
            
            echo "<p>Password is required</p>";
            
        } else {
            
            $query = "SELECT `id` FROM users WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."'";
            
            $result = mysqli_query($link, $query);
            
            if (mysqli_num_rows($result) > 0) {
                
                echo "<p>Email address is already registered!!</p>";
            
            } else {
            
                $query = "INSERT INTO `users` (`email`,`password`) VALUES ('".mysqli_real_escape_string($link, $_POST['email'])."', '".mysqli_real_escape_string($link, $_POST['password'])."')";
            
                if (mysqli_query($link, $query)) {
            
                    $_SESSION['email'] = $_POST['email'];
                    
                    header ("Location: session.php");
                
                } else {
                    
                    echo "<p>There was a problem signing you up. Please try again later.</p>";
                    
                };
            
            };
        
        };
    
    };

?>

<form method="post">
    <label for="email">Please enter your email here:</label>
    <input  id="email "type="email" name="email" placeholder="name@example.com">
    <br><br>
    <label for="password">Please enter your password:</label>
    <input id="password" type="password" name="password">
    <br><br>
    <button type="submit" name="submit">Sign Up</button>

</form>