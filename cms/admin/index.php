<?php
session_start();

include_once('../includes/connection.php');


if (isset($_SESSION['logged_in'])){
    ?>
<html lang="en-us">
    <head>
        <title>Content Management System</title>
        <link rel = "stylesheet" href="../assets/style.css"/>
    </head>
    <body>
    <div class="container">
        <a href="index.php" id="logo">Content Management System</a>

        <br />

        <ol>
            <li><a href="add.php">Přidat článek</a></li>
            <li><a href="delete.php">Vymazat článek</a></li>
            <li><a href="logout.php">Logout</a></li>

        </ol>
    </div>
  </body>
</html>

<?php
} else{
    if(isset($_POST['username'], $_POST['password'])){
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        if (empty($username) or empty($password)){
            $error = 'Je nutno vyplnit všechna pole';

        }else{
            $query = $pdo->prepare('SELECT * FROM users WHERE user_name = ? AND user_password = ?');

            $query->bindValue(1, $username);
            $query->bindValue(2, $password);

            $query->execute();

            $num = $query->rowCount();

            if($num==1){
                $_SESSION['logged_in'] = true;
                header('Location:index.php');
                exit();
            }else{
                $error = 'Nesprávné údaje';
            }
        }
    }
?>
    <html lang="en-us">
    <head>
        <title>Content Management System</title>
        <link rel = "stylesheet" href="../assets/style.css"/>
    </head>
    <body>
    <div class="container">
        <a href="index.php" id="logo">CMS</a>

        <br /> <br />
        <?php if(isset($error)){ ?>
            <small style="color:#aa0000;"><?php echo $error;?></small>
            <br /> <br />
        <?php }?>
        <form action="index.php" method="post" autocomplete="off">
            <input type="text" name="username" placeholder="Uživatel"/>
            <input type="password" name="password" placeholder="Heslo"/>
            <input type="submit" value="Login"/>


        </form>
    </div>
    </body>
    </html>
    <?php
}