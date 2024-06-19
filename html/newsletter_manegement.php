<?php
$title = "subscriber account";
include_once('includes/header.php');
?>
<?php
echo ("My newsletter");

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Skicka till inloggningssidan om inte inloggad
    exit();
}
$customerId = $_SESSION['user_id'];

//koppla upp mot databasen
$mysqli = new mysqli('db', 'root', 'notSecureChangeMe', 'task2');

//kontrollera anslutningen
if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}
//Add a newsletter for people to subscribe on
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['createBtn'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];

        //validera data
        if (empty($text) || empty($description)) {
            $_SESSION['message'] = "Alla fält måste fyllas i.";
        }

        $query = "INSERT INTO `Newsletter`(`title`, `description`, `customer_id`) VALUES (?,?,?)";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("sss", $title, $description, $customerId);

        if ($stmt->execute()) {
            $title = $description = "";
            $_SESSION['message'] = "Created";
            echo ("Newsletter created!");
        } else {
            echo "Fel: " . $sql . "<br>" . $stmt->error;
        }

        $stmt->close();
    } elseif (isset($_POST['updateBtn'])) {

        // Uppdatera nyhetsbrev
        $new_title = $_POST['new_title'];
        $new_description = $_POST['new_description'];
        $newsletter_id = $_POST['newsletter_id'];

        // Validera data
        if (empty($new_title) || empty($new_description)) {
            $_SESSION['message'] = "Don't leave a field empty.";
        } else {

            // Förbered och utför SQL-frågan för att uppdatera nyhetsbrev
            $update_query = "UPDATE `Newsletter` SET `title`=?, `description`=? WHERE `id`=? AND `customer_id`= ?";
            $update_stmt = $mysqli->prepare($update_query);
            $update_stmt->bind_param("ssii", $new_title, $new_description, $newsletter_id, $customerId);

            if ($update_stmt->execute()) {
                $_SESSION['updatedMessage'] = "Newsletter updated!";
            } else {
                echo "Fel: " . $update_stmt->error;
            }

            $update_stmt->close();
        }
    }
}

// Hämta befintliga nyhetsbrev för användaren
$select_query = "SELECT * FROM `Newsletter` WHERE `customer_id`=?";
$select_stmt = $mysqli->prepare($select_query);
$select_stmt->bind_param("i", $customerId);
$select_stmt->execute();
$result = $select_stmt->get_result();

$list = array(); // Array för att lagra nyhetsbrev

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $newsletter = array(
            "id" => $row['id'],
            "title" => $row['title'],
            "description" => $row['description']
        );
        $list[] = $newsletter;
    }
} else {
    $_SESSION['message'] = "No newsletter found!";
}

$select_stmt->close();
$mysqli->close();

?>


<div class="main-container" style="display: flex; justify-content: space-around; padding: 20px;">
    <div class="container" style="width: 45%; padding: 20px; background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); border-radius: 5px;">
        <h1 style="text-align: center; color: #333;">Write a newsletter</h1>
        <?php
        if (isset($_SESSION['message'])) {
            echo "<p style='color: red;'>" . $_SESSION['message'] . "</p>";
            unset($_SESSION['message']);
        }
        ?>
        <form method="POST">
            <label for="title" style="display: block; margin-top: 15px; font-weight: bold;">Titel</label>
            <input type="text" id="title" name="title" required style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 5px;">

            <label for="description" style="display: block; margin-top: 15px; font-weight: bold;">Text</label>
            <textarea id="description" name="description" rows="10" required style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 5px;"></textarea>

            <button type="submit" name="createBtn" style="display: block; width: 100%; padding: 10px; margin-top: 20px; background-color: #004371; color: white; border: none; border-radius: 5px; font-size: 16px;">Create newsletter</button>
        </form>
    </div>

    <div class="container" style="width: 45%; padding: 20px; background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); border-radius: 5px;">
        <h1 style="text-align: center; color: #333;">My newsletter</h1>
        <?php
        if (isset($_SESSION['updatedMessage'])) {
            echo "<p style='color: blue;'>" . $_SESSION['updatedMessage'] . "</p>";
            unset($_SESSION['updatedMessage']);
        }
        if (!empty($list)) {
            foreach ($list as $item) {
        ?>


                <form method="POST">
                    <input type="hidden" name="newsletter_id" value="<?php echo $item['id']; ?>">
                    <label for="new_title" style="display: block; margin-top: 15px; font-weight: bold;">Ny Titel</label>
                    <input type="text" id="new_title" name="new_title" value="<?php echo $item['title']; ?>" required style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 5px;">
                    <label for="new_description" style="display: block; margin-top: 15px; font-weight: bold;">Ny Text</label>
                    <textarea id="new_description" name="new_description" rows="10" required style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 5px;"><?php echo $item['description']; ?></textarea>
                    <button type="submit" name="updateBtn" style="display: block; width: 100%; padding: 10px; margin-top: 20px; background-color: #004371; color: white; border: none; border-radius: 5px; font-size: 16px;">Update newsletter</button>
                </form>

        <?php
            }
        } else {
            echo "<p style='color: red; text-align: center;'>Inga nyhetsbrev hittades.</p>";
        }
        ?>
    </div>
</div>
<?php
include_once('includes/footer.php');
?>