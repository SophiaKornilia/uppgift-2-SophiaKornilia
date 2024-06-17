<?php
$title = "customer account";
include_once('includes/header.php');
?>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //hämta den inmatade informationen från användaren
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    //validera data
    if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
        echo "Alla fält måste fyllas i.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Ogiltig e-postadress.";
    } else {
        //hasha lösenordet
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    }

    //koppla upp mot databasen
    $mysql = new mysqli('db', 'root', 'notSecureChangeMe', 'task2');

    //kontrollera anslutningen
    if ($mysql->connect_error) {
        die('Connection failed: ' . $mysql->connect_error);
    }

    $sql = "INSERT INTO Users (firstname, lastName, email, password, role) VALUES(?,?,?,?,?)";
    $stmt = $mysql->prepare($sql);
    $stmt->bind_param("sssss", $firstName, $lastName, $email, $hashedPassword, $role);

    if ($stmt->execute()) {
        echo "Användare registrerad!";
        $firstName = $lastName = $email = $password = "";
    } else {
        echo "Fel: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
    $mysql->close();
}
?>
<div class="customer-container" style="display: flex; flex-direction: column; align-items: center">
    <form method="POST" style="display: flex; flex-direction: column; margin-top:20px;">
        <h3>Subscibe on our newsletter</h3>
        <label for="firstName">Firstname</label>
        <input type="text" name="firstName" id="firstName">
        <label for="lastName">Lastname</label>
        <input type="text" name="lastName" id="lastName">
        <label for="email">Email</label>
        <input type="email" name="email" id="email">
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
        <label for="role">Role</label>
        <select name="role" id="role">
            <option value="subscriber">Subscriber</option>
            <option value="customer">Customer</option>
        </select>
        <input type="submit" style="margin-top: 20px;">
    </form>
</div>

<?php
include_once('includes/footer.php')
?>