<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Hiya!</title>
  </head>
  <style>
      body{
          background-color: #1F1D36;
          color: white;
      }
      h1{
          color : white;
      }
  </style>
  <body>
    
    <?php 
        // setting the variable values to default
        $showalert = false;
        $showerror = false;
        // if server gets request method as post
        if($_SERVER["REQUEST_METHOD"]== "POST"){            
            include 'components/conn.php';
            //taking in the values entered by the user and stored in the variables
            $username = $_POST["username"];
            $password = $_POST["password"];
            $cpassword = $_POST["cpassword"];
            //$exists = false;
            //$existsql= false;
            // to see if the username is taken or no
            $existsql = "SELECT * FROM  `users` WHERE username ='$username'";            
            $result= mysqli_query($conn,$existsql);
            //if the username exists on any other rows in the database
            $numexistrows = mysqli_num_rows($result);
            if($numexistrows>0){
                //$exists = true;
                $showerror = "username exists";

            }
            else
            {
                $exists = false;            
                //setting passwords to match
                if (($password==$cpassword)){
                    $hash = password_hash($password,PASSWORD_DEFAULT);
                    //sql query to insert into the database
                    $sql = "INSERT INTO `users` ( `username`, `password`, `date`) VALUES ('$username', '$hash', current_timestamp());";
                    //executing the sql query
                    $result = mysqli_query($conn,$sql);
                    // if query is successful then show the user green alert 
                    if ($result){
                        $showalert = true;
                    }
                }
                else{
                    // if query not successful then show the user error message
                    $showerror = "Password don't match";
                }  
            }

        }
        
        require 'components/_nav.php'
    ?>
    <!-- alert message to showcase successful signup -->
    <?php
        if($showalert)
            {    
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>SignUp Successful!</strong> Your account has been created successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
            }
            // alert message for not succesful signup
            if($showerror)
            {    
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> '. $showerror.'
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
            }
    ?>
    <!-- Making the sign up form  -->
    <div class="container col-sm-6">
        <h1>Join Us today by signing up</h1>

        <form action = "/LoginSystem/signup.php" method = "Post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="username" maxlength ="11" class="form-control" id="username" name = "username" aria-describedby="emailHelp"required> 
                <div id="uname" class="form-text">We'll never share your information with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" maxlength ="23" class="form-control" id="exampleInputPassword1" name= "password"required>
                <div id="pass" class="form-text">Must have one uppercase and number in it.</div>
            </div>
            <div class="mb-3">
                <label for="cpassword" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="cpassword" name= "cpassword"required>
                <div id="cpass" class="form-text">Please confrim Your password</div>
            </div>            
            <button type="submit" class="btn btn-primary">Sign Up</button>
        </form>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
  </body>
</html>