<?php
include_once('includes/functions.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //hämtar postdatan från formuläret.
    $password = $_POST['password'];

    //hämta lösenord från databasen
    //hämta email från POST varaiabel
    $email = $_POST['email'];
    //Skapa sql fråga för att hämta användardata
    $query = "SELECT * FROM Users WHERE email = '$email'";
    //koppla upp mot databasen
    $mysqli = new mysqli('db', 'root', 'notSecureChangeMe', 'task2');
    //hämta resultaten från min fråga
    $result = $mysqli->query($query)->fetch_assoc();

    if ($password === $result['password']) {
        $_SESSION['isloggedin'] = true;
        $_SESSION['role'] = $result['role'];

        // if ($email == "example@email.com" && $password == "123456") {
        //     $_SESSION['isloggedin'] = true;
        //     $_SESSION['email'] = $email;
        //     $_SESSION['role'] = 'subscriber';

        //sätta sesstion data
        //starta session
        //är inloggad
        //roll

        header('Location:welcome.php');
    } else {
        header("Location: " . $_SERVER['REQUEST_URI'] . "?error=Could not sign in");
        //gör redirect till forumläret igen
        
    }
    exit;
}
?>
<?php
$title = "subscriber account";
include_once('includes/header.php');
?>
<div class="subscriber-container" style="display: flex; flex-direction: column; align-items: center">
    <form method="POST" style="display: flex; flex-direction: column; margin-top:20px;">
        <h3>Login</h3>
        <?php 
        if(isset($_GET['error'])){
            echo "<p style='color: red;'>Felaktiga uppgifter, vänligen försök igen.</p>";
        };
        ?>
        <label for="email">Email</label>
        <input type="email" name="email" id="email">
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
        <input type="submit" style="margin-top: 20px;">
    </form>
</div>
<?php
include_once('includes/footer.php')
?>