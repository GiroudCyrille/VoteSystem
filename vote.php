<!-- PHP -->
<?php 
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "elections";

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection


if($conn->connect_error)
{
    die("Connection failed :" . $conn->connect_error);
}

if(!isset($_SESSION['connected'], $_SESSION['userId']))
{
    header('Location: login.php');
    exit();
}

if(isset($_POST['save'], $_POST['candidat'])) {
    insertVote($conn, $_POST['candidat']);
}

function createSelectOption($conn)
{
    $newSql = "SELECT DISTINCT * from candidats";
    $stmt = $conn->prepare($newSql);
    $stmt->execute();
    $result = $stmt->get_result();

    while($row = $result->fetch_assoc()) {
        echo '<option value="'. $row['id'] .'">' . $row['name'] .'</option>';
    }
}

function insertVote($conn, $idcandi)
{
    $sqlCheck = 'SELECT * FROM votes WHERE votes.idelecteur = ?';
    $stmt = $conn->prepare($sqlCheck);
    $stmt->bind_param("i", $_SESSION['userId']);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0)
    {
        echo "<script> alert('Vous avez déjà votez'); document.location='account.php' </script>";
        
    } else {
        $sql = 'INSERT INTO votes (idcandidat, idelecteur) VALUES (?,?)';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $idcandi, $_SESSION['userId']);

        if($stmt->execute()) 
        {
            echo "<script> alert('Votre vote à était pris en compte !'); document.location='account.php'</script>";
        }
        else { 
            echo "<script> alert('Impossible de prendre en compte votre vote'); document.location='account.php'</script>";
        }
    }
}
?>

<!-- HTML -->
<!DOCTYPE html>
<html> 
	<head>
        <title>Vote</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css\vote.css">
	</head>
    <body>
        <form method="post" action="vote.php">

        <div class="vote">

        <h1>Vote</h1>

        <div>
        <select name="candidat">
            <?php createSelectOption($conn)?>
        </select>
        </div>

        <input type="submit" name="save" value="Voter" class="vote_btn">
        
        </div>
    </body>
</html>