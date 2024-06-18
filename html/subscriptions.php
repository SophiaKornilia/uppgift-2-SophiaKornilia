<?php
include_once('includes/functions.php');

if (!is_signed_in()) {
    header('Location: login.php');
    exit;
};
// Hämta användarens ID från sessionen
$user_id = $_SESSION['user_id'];

$list = array();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //Skapa sql fråga för att hämta användardata

    $query = "SELECT Newsletter.*
    FROM Newsletter
    JOIN Subscriptions ON Newsletter.id = Subscriptions.Newsletter_id
    WHERE Subscriptions.user_id = $user_id";

    
    //koppla upp mot databasen
    $mysqli = new mysqli('db', 'root', 'notSecureChangeMe', 'task2');
    //hämta resultaten från min fråga
    $result = $mysqli->query($query);

    var_dump($result);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $newsletter = array(
                "title" => $row['title'],
                "description" => $row['description'],
                "id" => $row['id']
            );
            $list[] = $newsletter;
        }
    } else {
        echo "<p style='color: red; text-align: center;'>Could not find any newsletters.</p>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['unsubscribe'])) {

    if (isset($_POST['newsletter_id'])) {
        $newsletter_id = $_POST['newsletter_id'];

        $mysqli = new mysqli('db', 'root', 'notSecureChangeMe', 'task2');


        $deleteQuery = $mysqli->prepare("DELETE FROM Subscriptions WHERE newsletter_id = ? AND user_id = ?");

        if ($deleteQuery === false) {
            echo "Error preparing query: " . $mysqli->error;
        } else {
            // Bind parametrar och utför frågan
            $deleteQuery->bind_param("ii", $newsletter_id, $user_id);
        }

        if ($deleteQuery->execute()) {
            echo "Subscription successfully removed.";
        } else {
            echo "Error executing query: " . $deleteQuery->error;
        }

        $deleteQuery->close();
    } else {
        echo "Fel: newsletter_id missing";
    }
}
?>
<?php
$title = "subscriber account";
include_once('includes/header.php');
?>

<h3 style="display: flex; justify-content: center; align-items: center;">Subscriptions</h3>
<?php
foreach ($list as $item) {
?>
    <div style="margin: 20px; padding: 20px; border: 1px solid #ccc;">
        <p><?php echo ($item["title"]); ?></p>
        <div>
            <?php echo ($item['description']) ?>
        </div>
        <form method="POST" style=" display: flex; flex-direction: column;">
            <input type="hidden" name="newsletter_id" value="<?php echo $item['id'] ?>">
            <button type="submit" name="unsubscribe" style="align-self: flex-end; margin-top: auto; ">Unsubscribe on this newletter</button>
        </form>
    </div>
<?php
}
?>
<?php
include_once('includes/footer.php')
?>