<?php
  require_once "db.php";

  if(isset($_SESSION['user_id'])!="") {
    header("Location: dashboard.php");
  }

    if (isset($_POST['signup'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']); 
        if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
            $name_error = "Name must contain only alphabets and space";
        }
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
            $email_error = "Please Enter Valid Email ID";
        }
        if(strlen($password) < 6) {
            $password_error = "Password must be minimum of 6 characters";
        }       
        if(strlen($mobile) < 10) {
            $mobile_error = "Mobile number must be minimum of 10 characters";
        }
        if($password != $cpassword) {
            $cpassword_error = "Password and Confirm Password doesn't match";
        }
        if (!$error) {
            if(mysqli_query($conn, "INSERT INTO users(name, email, mobile ,password) VALUES('" . $name . "', '" . $email . "', '" . $mobile . "', '" . md5($password) . "')")) {
             header("location: index.php");
             exit();
            } else {
               echo "Error: " . $sql . "" . mysqli_error($conn);
            }
        }
        mysqli_close($conn);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Теристическое агенство</title>
    <link rel="stylesheet" href="css/reg.css">
</head>
<body>
    <div class="container">
        <div class="block">
            <div>
                <div class="page-header">
                    <h2>Регистрация</h2>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                    <div class="form-group">
                        <label>Имя</label>
                        <input type="text" name="name" class="form-control" value="" maxlength="50" required="">
                        <span class="text-danger"><?php if (isset($name_error)) echo $name_error; ?></span>
                    </div>

                    <div class="form-group ">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="" maxlength="30" required="">
                        <span class="text-danger"><?php if (isset($email_error)) echo $email_error; ?></span>
                    </div>

                    <div class="form-group">
                        <label>Телефон</label>
                        <input type="text" name="mobile" class="form-control" value="" maxlength="12" required="">
                        <span class="text-danger"><?php if (isset($mobile_error)) echo $mobile_error; ?></span>
                    </div>

                    <div class="form-group">
                        <label>Пароль</label>
                        <input type="password" name="password" class="form-control" value="" maxlength="8" required="">
                        <span class="text-danger"><?php if (isset($password_error)) echo $password_error; ?></span>
                    </div>  

                    <div class="form-group">
                        <label>Повторите пароль</label>
                        <input type="password" name="cpassword" class="form-control" value="" maxlength="8" required="">
                        <span class="text-danger"><?php if (isset($cpassword_error)) echo $cpassword_error; ?></span>
                    </div>

                    <input type="submit" class="btn btn-primary" name="signup" value="Зарегистрироваться">
                    <div>
                        Аккаунт уже есть?<a href="index.php" class="btn btn-default">Авторизироваться</a>
                    </div>
                </form>
            </div>
        </div>    
    </div>
</body>
</html>
