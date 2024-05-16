<?php
include_once('includes/functions.php');
//Här ska vi hämta alla premunerationer för ett specifikt nyhetsbrev
//hämta nyhetsbrevet och hämta de som prenumererar.

//skapa en tom array för subscribers data
$list = array();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //Skapa sql fråga för att hämta användardata (i exemplet nr 2)
    $query = "SELECT * 
    FROM `Subscriptions` 
    INNER JOIN Users ON Subscriptions.user_id=Users.id
    WHERE newsletter_id = 2;"; //session - owner tabellen newsletter
    //koppla upp mot databasen
    $mysqli = new mysqli('db', 'root', 'notSecureChangeMe', 'task2');
    //hämta resultaten från min fråga
    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $subscribers = array(
                "user_id" => $row['user_id'],
                "firstName" => $row['firstName'],
                "lastName" => $row['lastName'],
                "email" => $row['email']

            );
            $list[] = $subscribers;
        }
    } else {
        echo "<p style='color: red; text-align: center;'>Could not find any newsletters.</p>";
    }
}
?>
<?php
$title = "subscriber account";
include_once('includes/header.php');
//En sida där kunder kan se sina prenumeranter. 
?>
<div class="subscriber-container" style="display: flex; flex-direction: column; align-items: center">
    <form method="POST">
        <label for="newsletter">Search for your newsletter</label>
        <input type="text" name="newsletter">
        <input type="submit" value="Search">
    </form>

    <h1>All subscribers</h1>
</div>
<?php
foreach ($list as $item) {
}
?>
<div style="margin: 20px; padding: 20px; border: 1px solid #ccc;">
    <p><?php echo ($item["user_id"]); ?></p>
    <p><?php echo ($item["firstName"]); ?></p>
    <p><?php echo ($item["lastName"]); ?></p>
    <p><?php echo ($item["email"]); ?></p>
</div>
<?php
include_once('includes/footer.php')
?>