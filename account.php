<?php
session_start();

if(!isset($_SESSION['userId']))
{
    header('Location: login.php');
    exit();
}

if(isset($_GET['disconnect']))
{
    session_destroy();
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
    <head>
    <title>Gestion</title>
	<meta charset="UTF-8">
    <link rel="stylesheet" href="css\account.css"/>
    </head>
    <body>
    <div class="gestion">
            <h1>Gestion</h1>
            <!-- Cet idée de page est reprise de celle de Quentin -->

            <div class="textbox">
                <a href="result.php"> <input type="submit" name="result" value="Voir les résultats"> </a>
          
                <a href="vote.php"> <input type="submit" name="vote" value="Votez"> </a>
  
                <form method="get" action="account.php">
                     <input type="submit" name="disconnect" value="Déconnecter">
                </form>

            </div>
    </div>
    </body>
</html>