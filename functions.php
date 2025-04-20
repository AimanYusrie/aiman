<?php
$baseDir = "Book Collection";

if (isset($_POST['create_folder'])) {
    $newFolder = $baseDir . "/" . $_POST['folder_name'];
    if (!file_exists($newFolder)) mkdir($newFolder, 0777, true);
}

if (isset($_POST['create_file'])) {
    $folder = $_POST['file_category'];
    $filename = $_POST['file_name'];
    $content = $_POST['file_content'];
    file_put_contents("$baseDir/$folder/$filename.txt", $content);
}

if (isset($_POST['append_file'])) {
    file_put_contents($_POST['append_path'], "\n" . $_POST['append_content'], FILE_APPEND);
}

if (isset($_POST['delete_file'])) {
    unlink($_POST['delete_path']);
}

if (isset($_POST['delete_folder'])) {
    $folderToDelete = $_POST['folder_to_delete'];
    array_map('unlink', glob("$folderToDelete/*.*"));
    rmdir($folderToDelete);
}

function listBooks($baseDir) {
    $books = [];
    foreach (glob("$baseDir/*") as $category) {
        if (is_dir($category)) {
            foreach (glob("$category/*.txt") as $file) {
                $books[] = [
                    'path' => $file,
                    'name' => basename($file),
                    'category' => basename($category)
                ];
            }
        }
    }
    return $books;
}
?>
