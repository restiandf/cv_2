<?php
require_once '../config/database.php';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $conn = getConnection();
    
    if ($_POST['action'] === 'upload_image') {
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $filename = $_FILES['image']['name'];
            $filetype = pathinfo($filename, PATHINFO_EXTENSION);
            
            if (in_array(strtolower($filetype), $allowed)) {
                $newname = uniqid() . '.' . $filetype;
                $uploadpath = UPLOAD_DIR . $newname;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadpath)) {
                    $message = "Image uploaded successfully!";
                    echo json_encode(['success' => true, 'filename' => $newname, 'path' => $uploadpath]);
                    exit;
                } else {
                    $error = "Failed to upload image.";
                }
            } else {
                $error = "Invalid file type. Allowed: jpg, jpeg, png, gif, webp";
            }
        }
    }
    
    $conn->close();
}

if ($error) {
    echo json_encode(['success' => false, 'error' => $error]);
    exit;
}
?>