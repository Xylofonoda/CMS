<?php
session_start();

include_once('../includes/connection.php');


if(isset($_SESSION['logged_in'])){
    if(isset($_POST['title'], $_POST['content'])){
        $title = $_POST['title'];
        $content = nl2br($_POST['content']);

        if(empty($title) or empty($content)){
            $error = 'Všechny kolonky musí být vyplněny';
        }else{
            $query = $pdo->prepare('INSERT INTO articles (article_title, article_content, article_timestamp)VALUES(?, ?, ?)');
            $query->bindValue(1, $title);
            $query->bindValue(2, $content);
            $query->bindValue(3, time());

            $query->execute();
            header('Location:index.php');
        }
    }
    ?>
<html lang="en-us">
    <head>
        <title>CMS</title>
        <link rel = "stylesheet" href="../assets/style.css"/>
    </head>

  <body>
    <div class="container">
        <a href="index.php" id="logo">CMS</a>

        <br />

        <h4>Přidat článek</h4>

        <?php if(isset($error)){ ?>
            <small style="color:#aa0000;"><?php echo $error;?></small>
            <br /> <br />
        <?php }?>

        <form action="add.php" method="post" autocomplete="off">
            <input type="text" name="title" placeholder="Nadpis"/> <br /> <br />
            <textarea rows="15" cols="70" placeholder="Obsah" name="content"></textarea><br /><br />
            <input type="submit" value="Přidat"/>
      </form>
    </div>
  </body>
</html>

    <?php
}else{
    header('Location:index.php');
}
