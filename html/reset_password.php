<?php
// ob_start();
$title = "subscriber account";
include_once('includes/header.php');

//användare fyller i email
//sparas i passeword reset tabellen med koden som då skapas
//skicka ut koden i mail till användaren. 
//användaren setPassword och skriver in koden och nya lösenord och då uppdateras user db    
?>
<?php

//denna sidan ska generera en slumpmässig kod och skicka ett form till mailgun med post.
$randomNumber = rand();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
    }

    //koppla upp mot databasen
    $mysqli = new mysqli('db', 'root', 'notSecureChangeMe', 'task2');

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Förbered statement för att hämta användaren
    $stmt = $mysqli->prepare("SELECT id FROM Users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id = $row['id'];

        $ch = curl_init();
        $mailgunApiKey = getenv("MAILGUN_KEY");

        curl_setopt($ch, CURLOPT_URL, "https://api.mailgun.net/v3/sandbox26ef209e49264bbca8ce50646f208f76.mailgun.org/messages");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_USERPWD, 'api:' . $mailgunApiKey);

        $postData = array(
            'from' => 'postmaster@sandbox26ef209e49264bbca8ce50646f208f76.mailgun.org',
            'to' => $email,
            'subject' => 'Hello',
            'text' => 'Your code is: ' . $randomNumber
        );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

        $result = curl_exec($ch);
        if (!$result) {
            echo 'Error' . curl_error($ch);
        } else {
            echo 'Mail sent successfully';
        }
        curl_close($ch);

        //kolla om det finns en email i db 
        $checkQuery = $mysqli->prepare("SELECT * FROM PasswordReset WHERE user = ?");
        $checkQuery->bind_param("i", $id);
        $checkQuery->execute();
        $checkResult = $checkQuery->get_result();

        $insertQuery = "INSERT INTO PasswordReset (user, code) VALUES ('$email', '$randomNumber')";
        if ($mysqli->query($insertQuery) === TRUE) {
            // Omdirigera till set_password.php
            header("Location: set_password.php");
            exit;
        } else {
            echo "Error: " . $insertQuery . "<br>" . $mysqli->error;
        };
        // }
    }
};
// ob_end_flush();

?>
<div class="subscriber-container" style="display: flex; flex-direction: column; align-items: center">
    <form method="POST">
        <label for="email">Email</label>
        <input type="email" name="email" required>
        <!-- Hidden input field to include the random number -->
        <input type="hidden" name="code" value="<?php echo $randomNumber; ?>">
        <button type="submit">Send</button>
    </form>
</div>
<?php
include_once('includes/footer.php')
?>