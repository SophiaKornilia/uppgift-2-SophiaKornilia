<?php
session_start();
$_SESSION['isloggedin'] = true;

function get_window_title($title)
{
    return $title . ' - My awesome site';
}
//tar emot en kund eller prenumerant, $role innehåller alltså något av dessa. 
function user_has_role($role)
{
    return isset($_SESSION['role']) && $_SESSION['role'] === $role;
}

function is_signed_in()
{
    return isset($_SESSION['isloggedin']) && $_SESSION['isloggedin'] === true;
}

function is_signed_out()
{
    if (isset($_SESSION['isloggedin']) && $_SESSION['isloggedin'] === true) {
        session_unset();
        session_destroy();
        echo '<meta http-equiv="refresh" content="3;url=login.php">';
        exit;
    }
}

function require_role($role)
{
    if (!is_signed_in() || !user_has_role($role)) {
        header('Location: /no-access.php');
        exit();
    }
}

function fetchNewsletters()
{
    $list = array();
    $mysqli = new mysqli('db', 'root', 'notSecureChangeMe', 'task2');

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $query = "SELECT * FROM Newsletter";
    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $newsletter = array(
                "title" => $row['title'],
                "description" => $row['description'],
                "id" => $row['id']
            );
            $list[] = $newsletter;
        }
    }

    $mysqli->close();
    return $list;
}

function fetchSubscribedNewsletters($user_id)
{
    $list = array();

    // Anslut till databasen
    $mysqli = new mysqli('db', 'root', 'notSecureChangeMe', 'task2');

    // Kontrollera anslutningen
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Förbered SQL-frågan för att hämta prenumererade nyhetsbrev
    $query = "SELECT Newsletter.*
              FROM Newsletter
              JOIN Subscriptions ON Newsletter.id = Subscriptions.newsletter_id
              WHERE Subscriptions.user_id = ?";

    // Förbered och utför frågan
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Lägg till resultatet i $list-arrayen
    while ($row = $result->fetch_assoc()) {
        $newsletter = array(
            "title" => $row['title'],
            "description" => $row['description'],
            "id" => $row['id']
        );
        $list[] = $newsletter;
    }

    // Stäng förberedd fråga och anslutning
    $stmt->close();
    $mysqli->close();

    return $list;
}
