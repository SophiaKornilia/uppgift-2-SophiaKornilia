<?php
include_once('includes/functions.php');
$list = fetchNewsletters();
//Här ska vi lista innehållet från databasen(newsletters)
//skapa en tom array för nyhetsbrevens data

// När jag klickar på knappen
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Kolla vilken user om man är inloggad
    if (!isset($_SESSION['user_id'])) {
        echo ("Du är inte inloggad");
    } else {
        $user_id = $_SESSION['user_id'];
    }
    //Kolla vilket newsletter id som man klickat på
    //Gör en query för att lägga in i db
    if (isset($_POST['newsletter_id'])) {
        $newsletter_id = $_POST['newsletter_id'];

        //koppla upp mot databasen
        $mysqli = new mysqli('db', 'root', 'notSecureChangeMe', 'task2');

        // Kontrollera anslutningen
        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }


        $insertQuery = $mysqli->prepare("INSERT INTO Subscriptions (newsletter_id, user_id) VALUES (?, ?)");
        $insertQuery->bind_param("ii", $newsletter_id, $user_id);

        if ($insertQuery->execute()) {
            echo "Prenumerationen har lagts till i databasen.";
        } else {
            echo "Fel vid insättning i databasen: " . $mysqli->error;
        }

        // $insertQuery->close();
        // $mysqli->close();
    } else {
        echo "Fel: newsletter_id saknas";
    }
}

?>

<?php
$title = "subscriber account";
include_once('includes/header.php');
?>
<h3 style="display: flex; justify-content: center; align-items: center;">Newsletters</h3>
<?php
foreach ($list as $item) {
?>
    <div style="margin: 20px; padding: 20px; border: 1px solid #ccc; ">
        <p><?php echo ($item["title"]); ?></p>
        <div>
            <?php echo ($item['description']) ?>
        </div>

        <form method="POST" style=" display: flex; flex-direction: column;">
            <input type="hidden" name="newsletter_id" value="<?php echo $item['id'] ?>">
            <button type="submit" name="subscribe" style="align-self: flex-end; margin-top: auto; ">Subscribe on this newletter</button>
        </form>
    </div>
<?php
}
?>

<?php
include_once('includes/footer.php')
?>