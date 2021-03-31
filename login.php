<!-- PHP -->
<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "elections";

$conn = new mysqli($servername, $username, $password, $dbname);
session_start();

if($conn->connect_error)
{
    die("Connection failed :" . $conn->connect_error);
}

if(isset($_POST['connect'], $_POST['login'], $_POST['password'])) {
    connect($conn, $_POST['login'], $_POST['password']);
}

function connect($conn, $login, $password)
{
    $sqlCheck = "SELECT * FROM users WHERE users.login = ? and users.password = ?";
    $stmt = $conn->prepare($sqlCheck);
    $stmt->bind_param("ss", $login, $password);
    $stmt->execute();
    $result = $stmt->get_result();
 
    if($result->num_rows == 0)
    {
        echo "<script> alert('identifiant incorrect'); </script>";
    } 
    else 
    {
        $_SESSION['connected'] = true;
        $_SESSION['userId'] = $result->fetch_assoc()['Id'];
        header('Location: account.php');
        exit();
    }
}

?>

<!-- HTML -->
<!DOCTYPE html>
<html> 
	<head>
        <title>Connexion</title>
		<meta charset="UTF-8">
        <link rel="stylesheet" href="css\login.css"/>
	</head>
    <body>
        <form method="post" action="login.php">
        <div class="login_input">
            <h1>Connection</h1>

            <div class="textbox">
                <input type="text" placeholder="Identifiant" name="login"/>
            </div>

            <div class="textbox">
                <input type="password" placeholder="Mot de passe" name="password"/>
            </div>
          
            <input type="submit" name="connect" value="Connecter" class="connect">
        </div>
    </body>
</html>