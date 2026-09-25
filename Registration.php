<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="Registration.css">
</head>
<body>
    <div class="container">
        <?php

if (isset($_POST["submit"])) {

    $fullname = $_POST["fullname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $passwordRepeat = $_POST["Repeat_password"];
    
    $passwordHash= password_hash($password,PASSWORD_DEFAULT);
    $errors = array();

    if (empty($fullname) OR empty($email) OR empty($password) OR empty($passwordRepeat)) {
        array_push($errors, "All fields are required");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Email is not valid");
    }

    if (strlen($password) < 8) {
        array_push($errors, "Password must be at least 8 characters long");
    }

    if ($password !== $passwordRepeat) {
        array_push($errors, "Password does not match");
    }
      require_once "database.php";
 $sql="SELECT *FROM users WHERE email='$email'";
  $result =mysqli_query($conn,$sql);
  $rowCount=mysqli_num_rows($result);
  if($rowCount>0)
    {
        array_push($errors,"Email allready exists!");
    }
    if (count($errors) > 0) {

        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }

    } else {
        
  
    $sql ="INSERT INTO users (full_name, email,password	)VALUES(?,?,?)";
   $stmt= mysqli_stmt_init($conn);
   $prepareStmt= mysqli_stmt_prepare($stmt,$sql);
   if($prepareStmt)
    {
        mysqli_stmt_bind_param($stmt,"sss",$fullname,$email,$passwordHash);
        mysqli_stmt_execute($stmt);
        echo "<div class='alert alert-success'>Registration Successful!</div>";
    }
    else{
        die("something want wrong");
    }
        }
}
?>
        <form action="Registration.php" method="post">
            <div class="form-group">
                <input type="text" name="fullname" placeholder="Full Name:"> 
            </div>

            <div class="form-group">
                <input type="email" name="email" placeholder="Email:"> 
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password:"> 
            </div>
            <div class="form-group">
                <input type="password" name="Repeat_password" placeholder="Repeat Password:"> 
            </div>
            <div class="form-grouptration">
                <input type="submit" value="Register" name="submit">
            </div>
        </form>

    </div>
</body>
</html>