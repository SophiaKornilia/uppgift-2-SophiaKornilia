<?php
include_once('includes/functions.php');
//kontrollera om det skickats en postförfrågan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //hämta den inmatade epost och lösenord från användaren(form)
    $password = $_POST['password'];
    $email = $_POST['email'];


    //koppla upp mot databasen
    $mysqli = new mysqli('db', 'root', 'notSecureChangeMe', 'task2');

    //kontrollera anslutningen
    if ($mysqli->connect_error) {
        die('Connection failed: ' . $mysqli->connect_error);
    }

    // Escapar epost för att förhindra SQL-injektion - som betyder vad?? 
    $email = $mysqli->real_escape_string($email);

    // Skapa SQL-fråga för att hämta användardata
    $query = "SELECT * FROM Users WHERE email = '$email'";
    $result = $mysqli->query($query);

    // Kontrollera om epostadressen finns i databasen
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        //jämför det inmatade lösenordet med det i databasen.
        if ($password === $user['password']) {
            $_SESSION['isloggedin'] = true;
            $_SESSION['role'] = $user['role'];


            // Hämta användar-ID och spara det i sessionen
            $userId = $user['id'];
            $_SESSION['user_id'] = $userId;
            header('Location:welcome.php');
            exit;
        } else {
            header("Location: " . $_SERVER['REQUEST_URI'] . "?error=Could not sign in");
            exit;
            //gör redirect till forumläret igen
        }
    } else {
        // E-postadressen finns inte, omdirigera med felmeddelande
        header("Location: " . $_SERVER['REQUEST_URI'] . "?error=Email does not exist");
    }
    exit;
};
?>
<?php
$title = "subscriber account";
include_once('includes/header.php');
?>
<div class="subscriber-container" style="display: flex; flex-direction: column; align-items: center">
    <form method="POST" style="display: flex; flex-direction: column; margin-top:20px;">
        <h3>Login</h3>
        <?php
        if (isset($_GET['error'])) {
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