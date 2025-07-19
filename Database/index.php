<!DOCTYPE html> 
<html>
<head>
    <title>Database Backup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">

<div class="container">
    <h2>Database Backup</h2>

    <!-- Backup Button -->
    <button id="backupBtn" class="btn btn-primary mb-3">Backup Now</button>

    <!-- Message -->
    <div id="message" class="mt-3"></div>

    <!-- Upload SQL File -->
    <form action="upload.php" method="post" enctype="multipart/form-data" class="mb-4">
        <div class="mb-3">
            <label for="sqlFile" class="form-label">Upload SQL File</label>
            <input type="file" name="sqlFile" id="sqlFile" class="form-control" accept=".sql" required>
        </div>
        <button type="submit" class="btn btn-warning">Upload SQL File</button>
    </form>

    <hr>
    <h4>Previous Backups</h4>
    <ul class="list-group">
        <?php
        $backupDir = __DIR__ . '/backups';
        if (!is_dir($backupDir)) {
            mkdir($backupDir, 0755, true);
        }

        $files = glob($backupDir . "/*.sql");
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
                        <a href='backups/$name' class='btn btn-sm btn-success' download>Download</a>
                        <a href='#' class='btn btn-sm btn-primary' onclick='restoreBackup(\"$name\")'>Restore</a>
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

function restoreBackup(filename) {
    if (!confirm(`Are you sure you want to restore "${filename}"? This will overwrite your current database.`)) return;

    fetch('restore.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ file: filename })
    })
    .then(res => res.json())
    .then(data => {
        let msgDiv = document.getElementById('message');
        msgDiv.innerHTML = `<div class="alert alert-${data.status === 'success' ? 'success' : 'danger'}">${data.message}</div>`;
    });
}
</script>

</body>
</html>
