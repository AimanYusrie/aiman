<?php include 'functions.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Library System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include "header.php";?>
<div class="card">
    <h2>Create New Folder</h2>
    <form method="POST">
        <input type="text" name="folder_name" placeholder="Folder Name (e.g., Fiction)" required>
        <button type="submit" name="create_folder">Create Folder</button>
    </form>
</div>

<div class="card">
    <h2>Create New Book File</h2>
    <form method="POST">
        <select name="file_category" required>
            <?php foreach (glob("$baseDir/*", GLOB_ONLYDIR) as $dir): ?>
                <option value="<?= basename($dir) ?>"><?= basename($dir) ?></option>
            <?php endforeach; ?>
        </select>
        <input type="text" name="file_name" placeholder="Book Title" required>
        <textarea name="file_content" placeholder="Book details: title, author, ISBN, publication date" rows="4" required></textarea>
        <button type="submit" name="create_file">Create File</button>
    </form>
</div>

<div class="card">
    <h2>Delete Folder</h2>
    <form method="POST">
        <select name="folder_to_delete" required>
            <?php foreach (glob("$baseDir/*", GLOB_ONLYDIR) as $dir): ?>
                <option value="<?= $dir ?>"><?= basename($dir) ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" name="delete_folder" class="danger">Delete Folder</button>
    </form>
</div>

<div class="card">
    <h2>Book List</h2>
    <table>
        <tr>
            <th>File Name</th>
            <th>Category</th>
            <th>Content</th>
            <th>Append Info</th>
            <th>Delete</th>
        </tr>
        <?php foreach (listBooks($baseDir) as $book): ?>
            <tr>
                <td><?= $book['name'] ?></td>
                <td><?= $book['category'] ?></td>
                <td>
                    <button class="toggle-btn" onclick="toggleContent(this)">Show Content</button>
                    <div class="book-content" style="display: none;">
                        <pre><?= htmlspecialchars(file_get_contents($book['path'])) ?></pre>
                    </div>
                </td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="append_path" value="<?= $book['path'] ?>">
                        <input type="text" name="append_content" placeholder="Add info">
                        <button type="submit" name="append_file">Append</button>
                    </form>
                </td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="delete_path" value="<?= $book['path'] ?>">
                        <button type="submit" name="delete_file" class="danger">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<script>
    function toggleContent(button) {
        const contentDiv = button.nextElementSibling;
        const isVisible = contentDiv.style.display === 'block';
        contentDiv.style.display = isVisible ? 'none' : 'block';
        button.textContent = isVisible ? 'Show Content' : 'Hide Content';
    }
</script>

</body>
</html>