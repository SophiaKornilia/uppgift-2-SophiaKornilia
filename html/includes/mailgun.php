<?php
include_once('htmlform.php');
//tar emot postdata från formuläret i htmlform
//extrahera epostadressen
//extrahera den slumpmässiga koden. 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email']) && isset($_POST['code'])) {
        $email = $_POST['email'];
        $randomNumber = $_POST['code'];
    } else {
        echo "E-postadressen saknas i POST-data";
        exit;
    }
} else {
    echo "Ingen POST-förfrågan mottogs";
    exit;
};

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = "SELECT * 
    FROM `Users` 
    WHERE email = '$email'";

    //koppla upp mot databasen
    $mysqli = new mysqli('db', 'root', 'notSecureChangeMe', 'task2');
    //hämta resultaten från min fråga
    $result = $mysqli->query($query);

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
            'text' => 'Your numbers are: ' . $randomNumber
        );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

        $result = curl_exec($ch);
        if (!$result) {
            echo 'Error' . curl_error($ch);
        } else {
            echo 'Mail sent successfully';
        }
        curl_close($ch);

        $insertQuery = "INSERT INTO PasswordReset (id,user, code) VALUES ('$id','$email', '$randomNumber')";
        if ($mysqli->query($insertQuery) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $insertQuery . "<br>" . $mysqli->error;
        };
    } else {
        echo "Email doesn´t exist, try another one!";
    }
};
