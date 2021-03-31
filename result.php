<?php 
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

// function createInput($conn) {

// $sql = "SELECT candidats.name, COUNT(votes.idcandidat) as count
// FROM votes
// INNER JOIN candidats ON candidats.id = votes.idcandidat
// GROUP BY candidats.name
// ORDER BY `count` DESC";
// $stmt = $conn->prepare($sql);
// $stmt->execute();
// $result = $stmt->get_result();

// if($result->num_rows > 0)
// {
//     while($row = $result->fetch_assoc())
//     {
//         echo '<p> Candidat : ' . $row['name'] . ' Nombre de votes : ' . $row['count'] .' </p>';
//     }
// }
// else
// {
//     echo "Aucun gagnant";
// }
// }

function createInput($conn)
{
    $sql = "SELECT candidats.name, COUNT(votes.idcandidat) as count
    FROM votes
    INNER JOIN candidats ON candidats.id = votes.idcandidat
    GROUP BY candidats.name
    ORDER BY `count` DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
  
    echo "<div class='textbox'>";
    if($result->num_rows > 0)
    {
        $i = 0;
        while($row = $result->fetch_assoc())
        {
            if($i == 0)
                echo "<p> <strong> Le gagnant est " . $row['name'] . " avec " . $row['count'] ." voix </strong> </p>";
            else
                echo "<p> Le candidat " . $row['name'] . " à obtenu " . $row['count'] . " voix </p>";
            $i++;
        }
    }
    else
        echo "<p> Aucun gagnant déterminer. </p>";
    
    echo "</div>";
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Resultat</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css\result.css">  
    </head>
    <body>
    <div class="result">
        <h1>Résultats</h1>

        <?php createInput($conn); ?>
      
        <a href="account.php"> <input type="submit" value="Gestion" name="back"> </a>
     </div>
    </body>
</html>