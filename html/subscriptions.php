<?php
include_once('includes/functions.php');

if (is_signed_in()) {
    var_dump($_SESSION);
    $userId = $_SESSION['user_id'];
    var_dump("User ID: " . $userId);
} else {
    echo "You are not signed in!";
};
//hämta subscriptions som har samma user id


$list = array();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //Skapa sql fråga för att hämta användardata

    $query = "SELECT Newsletter.*
    FROM Newsletter
    JOIN Subscriptions ON Newsletter.id = Subscriptions.Newsletter_id
    WHERE Subscriptions.user_id = $userId";
    //koppla upp mot databasen
    $mysqli = new mysqli('db', 'root', 'notSecureChangeMe', 'task2');
    //hämta resultaten från min fråga
    $result = $mysqli->query($query);

    var_dump($result);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $newsletter = array(
                "title" => $row['title'],
                "description" => $row['description']
            );
            $list[] = $newsletter;
        }
    } else {
        echo "<p style='color: red; text-align: center;'>Could not find any newsletters.</p>";
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
    // if (isset($_GET['title']) && $item['title'] === $_GET['title']) {
?>
    <div style="margin: 20px; padding: 20px; border: 1px solid #ccc;">
        <p><?php echo ($item["title"]); ?></p>
        <div>
            <?php echo ($item['description']) ?>
        </div>
    </div>
<?php
    // }
}
?>
<?php
include_once('includes/footer.php')
?>