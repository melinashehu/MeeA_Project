<?php
function uploadFile($file) {
    $uploadDir = '../../uploads/posts/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    $fileName = basename($file['name']);
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'avi', 'mkv'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (!in_array($fileExtension, $allowedExtensions)) {
        throw new Exception('Unsupported file type. Allowed types are: ' . implode(', ', $allowedExtensions));
    }

    if ($fileError !== UPLOAD_ERR_OK) {
        throw new Exception('An error occurred during file upload.');
    }

    if ($fileSize > 10 * 1024 * 1024) { 
        throw new Exception('File size exceeds the 10 MB limit.');
    }

    $uniqueFileName = uniqid('post_', true) . '.' . $fileExtension;

    $filePath = $uploadDir.$uniqueFileName;

    if (!move_uploaded_file($fileTmpName, $filePath)) {
        throw new Exception('Failed to move uploaded file.');
    }

    return $filePath;
}

?>