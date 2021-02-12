<?php
$error = "";
$success = "";
if(array_key_exists("submit",$_POST)){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    include 'connection.php';

    if($_POST['email'] == "")
    {
        $error.="Email id is required<br>";
    }
    if($_POST['password'] == "")
    {
        $error.="Password is required<br>";
    }

    if($error == "")
    {
        $query = "SELECT `Cust.No` FROM `customers` WHERE email='".mysqli_real_escape_string($link,$_POST['email'])."' LIMIT 1";
        $result = mysqli_query($link,$query);
        
        if(mysqli_num_rows($result)>0)
        {
            $error="Email id is already registered<br>";            
        }
        else
        {
            $query = "INSERT INTO `customers` (Name,Email,Password,Balance) VALUES('".mysqli_real_escape_string($link,$_POST['name'])."','".mysqli_real_escape_string($link,$_POST['email'])."','".mysqli_real_escape_string($link,$_POST['password'])."',0)";

            if(!mysqli_query($link,$query))
            {
                $error="Could not create Account.<br>";
            }
            else{
                $success = "Account created Successfully.";
            }
            
        }
    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>TSF Bank</title>
    <link href="style.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <script defer src=script.js></script>
</head>

<body>
    <main>
        <?php include 'menubar.php' ?>
        <section class ="error" >
            <p><?php echo $error; ?>
        </section>
        <section class ="success" >
            <p><?php echo $success; ?>
        </section>
        <section class="middle">
            <h2 class="intro">Bank <span class="green">Safely</span> and <br>
                <span class="green">Securely</span> with TSF Bank
            </h2>
            <img class="bank-image" src="bank.jpg">
        </section>

        <section class="transactions">
            <a href ="customers.php" ><button type="button">User Accounts</button></a>
            <a href = "customers.php"><button type="button">Transfer Money</button></a>
        </section>

        <section class="footer">
            <h2 class="open-account">Open your Account Now!</h2>
            <button class="open-account-btn" type="button">Open Account</button>
        </section>

        <section class ="credits">
            <p> © Feb 2021 Made by : Jindam SaiSuraj</p>
            <p> GRIP The Sparks Foundation </p>
        </section>

        <div class="modal hidden">
            <button class="btn--close-modal">&times;</button>
            <h2 class="modal__header">
                Open your bank account <br />
                in just <span class="highlight">5 minutes</span>
            </h2>
            <form method = "post" class="modal__form">
                <label>Name</label>
                <input type="text" name ="name" />
                <label>Email</label>
                <input type="email" name = "email" />
                <label>Password</label>
                <input type="password" name ="password" />
                <button class="btn" name = "submit">Submit &rarr;</button>
            </form>
        </div>
        <div class="overlay hidden"></div>
    </main>
</body>

</html>