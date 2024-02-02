<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projekt";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$datum = date("Y-m-d");
$naslov = $_POST['title'];
$sazetak = $_POST['about'];
$tekst = $_POST['content'];
$kategorija = $_POST['category'];
$arhiva = isset($_POST['archive']) ? 1 : 0;

// Check if file was uploaded successfully
if (isset($_FILES['pphoto']) && $_FILES['pphoto']['error'] === UPLOAD_ERR_OK) {
    $slika = $_FILES['pphoto']['name'];
    $slika_tmp = $_FILES['pphoto']['tmp_name'];
    $target_path = "slike/" . $slika;

    // Move the uploaded file to the desired location
    move_uploaded_file($slika_tmp, $target_path);
} else {
    // Handle file upload error or no file uploaded
    $slika = "default_image.jpg";
}

$stmt = $conn->prepare("INSERT INTO vijesti (datum, naslov, sazetak, tekst, slika, kategorija, arhiva) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssi", $datum, $naslov, $sazetak, $tekst, $slika, $kategorija, $arhiva);

if ($stmt->execute()) {
    echo "News article has been successfully submitted.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

// Process form submission and perform necessary operations

// Redirect to index.php
header("Location: index.php");
exit;
?>
