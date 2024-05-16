<?php
//denna sidan ska generera en slumpmässig kod och skicka ett form till mailgun med post.
$randomNumber = rand();

?>
<form method="POST" action="mailgun.php">
    <label for="email">Email</label>
    <input type="email" name="email" required>
    <!-- Hidden input field to include the random number -->
    <input type="hidden" name="code" value="<?php echo $randomNumber; ?>">
    <button type="submit">Send</button>
</form>