<?php
include_once('includes/functions.php');
//Här ska vi lista innehållet från databasen(newsletters)
//skapa en tom array för nyhetsbrevens data
$list = array();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //Skapa sql fråga för att hämta användardata
    $query = "SELECT * FROM Newsletter";
    //koppla upp mot databasen
    $mysqli = new mysqli('db', 'root', 'notSecureChangeMe', 'task2');
    //hämta resultaten från min fråga
    $result = $mysqli->query($query);

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
<h3 style="display: flex; justify-content: center; align-items: center;">Newsletters</h3>
<?php
foreach ($list as $item) {
    // if (isset($_GET['title']) && $item['title'] === $_GET['title']) {
?>
    <div style="margin: 20px; padding: 20px; border: 1px solid #ccc; display:flex; flex-direction: column;">
        <p><?php echo ($item["title"]); ?></p>
        <div>
            <?php echo ($item['description']) ?>
        </div>
        <button style="align-self: flex-end; margin-top: auto; ">Subscribe on this newletter</button>
    </div>
<?php
    // }
}
?>

<?php
include_once('includes/footer.php')
?>