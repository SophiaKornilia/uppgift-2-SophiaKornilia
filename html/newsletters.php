<?php
$title = "subscriber account";
include_once('includes/header.php');
?>

<?php
//Här ska vi lista innehållet från databasen(newsletters)
$list = array(
    array("type" => "annanas", "url" => "index.php?type=annanas", "description" => "...1"),
    array("type" => "banan", "url" => "index.php?type=banan", "description" => "...2"),
    array("type" => "citron", "url" => "index.php?type=citron", "description" => "...3")
);
?>
<h3 style="display: flex; justify-content: center; align-items: center;">Newsletters</h3>
<?php
foreach ($list as $item) {
    // if (isset($_GET['type']) && $item['type'] === $_GET['type']) {
?>
    <div style="margin: 20px; padding: 20px; border: 1px solid #ccc;">
        <p><?php echo ($item["type"]); ?></p>
        <div>
            <?php echo ($item['description']) ?>
        </div>
    </div>
<?php
    // }
}
?>

<?php
include_once('includes/footer.php')
?>