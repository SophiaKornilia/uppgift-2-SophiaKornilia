<?php
ob_start();
include_once('includes/functions.php');
$title = "subscriber account";
include_once('includes/header.php');

//användaren setPassword och skriver in koden och nya lösenord och då uppdateras user db  

//kolla om koden matchar användaren och i så fall gör en update query och uppdatera lösenordet. 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $code = $_POST['code'];
    $password = $_POST['password'];

    //validera data 
    if (empty($code) || empty($password)) {
        echo "Alla fält måste fyllas i.";
    }

    //koppla upp mot databasen
    $mysqli = new mysqli('db', 'root', 'notSecureChangeMe', 'task2');

    //kontrollera anslutningen
    if ($mysqli->connect_error) {
        die('Connection failed: ' . $mysqli->connect_error);
    }

    //kolla om det finns en code i db 
    $checkQuery = $mysqli->prepare("SELECT * FROM PasswordReset WHERE code = ?");
    $checkQuery->bind_param("s", $code);
    $checkQuery->execute();
    $checkResult = $checkQuery->get_result();

    if ($checkResult->num_rows > 0) {
        //hämta användarens id från passwordreset
        $row = $checkResult->fetch_assoc();
        $userId = $row['user'];

        // Förbered frågan för att uppdatera lösenordet i Users-tabellen
        $updateQuery = "UPDATE Users SET password = ? WHERE id = ?";
        $updateStmt = $mysqli->prepare($updateQuery);

        $updateStmt->bind_param("si", $hashedPassword, $userId);
        if ($updateStmt->execute()) {
            echo "Password updated successfully";
            // Omdirigera till en bekräftelsesida eller annan sida efter uppdatering
            header("Location: reset_password_confirm.php");
            exit;
        } else {
            echo "Error updating password: " . $updateStmt->error;
        }
        $updateStmt->close();

        // if ($mysqli->query($insertQuery) === TRUE) {
        //     echo "New password was created successfully";
        //     // Omdirigera till set_password.php
        //     header("Location: reset_password_confirm.php");
        // } else {
        //     echo "Error: " . $insertQuery . "<br>" . $mysqli->error;
        // };
    } else {
        echo "Invalid code or code not found.";
    }

    // Stäng anslutningen till databasen
    $mysqli->close();
}
ob_end_flush();
?>
<div class="subscriber-container" style="display: flex; flex-direction: column; align-items: center">

    <h3>Please write your code and your new password</h3>
    <form method="POST" style="display: flex; flex-direction: column; margin-top:20px;">
        <label for="code">Code</label>
        <input type="text" name="code" required>
        <label for="password">New password</label>
        <input type="password" name="password" required>
        <button type="submit" style="margin-top: 20px;">Send</button>
    </form>


</div>
<?php
include_once('includes/footer.php')
?>