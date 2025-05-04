<!DOCTYPE html>
<html>
<head>
    <title>Database Backup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">

<div class="container">
    <h2>Database Backup</h2>

    <button id="backupBtn" class="btn btn-primary">Backup Now</button>

    <div id="message" class="mt-3"></div>

    <hr>
    <h4>Previous Backups</h4>
    <ul class="list-group">
        <?php
        $files = glob("backups/*.sql");
        rsort($files); // Latest first
        foreach ($files as $file) {
            $name = basename($file);
            $size = filesize($file);
            $sizeFormatted = number_format($size / 1024, 2) . ' KB';
            echo "<li class='list-group-item d-flex justify-content-between align-items-center'>
                    <div>
                        <strong>$name</strong><br>
                        <small class='text-muted'>Size: $sizeFormatted</small>
                    </div>
                    <span>
                        <a href='$file' class='btn btn-sm btn-success' download>Download</a>
                        <a href='delete.php?file=$name' class='btn btn-sm btn-danger' onclick='return confirm(\"Delete this backup?\")'>Delete</a>
                    </span>
                  </li>";
        }
        ?>
    </ul>
</div>

<script>
document.getElementById('backupBtn').addEventListener('click', function() {
    fetch('backup.php')
        .then(res => res.json())
        .then(data => {
            let msgDiv = document.getElementById('message');
            msgDiv.innerHTML = `<div class="alert alert-${data.status === 'success' ? 'success' : 'danger'}">${data.message}</div>`;
            setTimeout(() => location.reload(), 1500);
        });
});
</script>

</body>
</html>
