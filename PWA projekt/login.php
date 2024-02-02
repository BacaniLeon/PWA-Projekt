
<!DOCTYPE html>
<html>
<header>
    <link rel="stylesheet" type="text/css" href="style.css">
    <img src="vijesti.jpg" class="vijesti">
    <nav>
        <a href="index.php">POČETNA</a>
        <a href="index.php?category=sport">SPORT</a>
        <a href="index.php?category=udarneVijesti">UDARNE VIJESTI</a>
        <a href="index.php?category=kultura">KULTURA</a>
        <a href="index.php?category=oGradu">O GRADU</a>
        <a href="unos.html">Unos Vijesti</a>
		<a href="login.php">Login</a>
		<a href="registracija.php">Registracija</a>
        
    </nav>
</header>
<body>
    <h2>Login</h2>
    <form action="login.php" method="POST">
        <div class="form-item">
            <label for="username">Username:</label>
            <input type="text" name="username" required>
        </div>
        <div class="form-item">
            <label for="password">Password:</label>
            <input type="password" name="password" required>
        </div>
        <div class="form-item">
            <button type="submit">Login</button>
        </div>
    </form>
	
	
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projekt";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Prepare and execute the SQL query
    $stmt = $conn->prepare("SELECT lozinka FROM korisnik WHERE korisnicko_ime = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row["lozinka"];
        if (password_verify($password, $hashedPassword)) {
            // User is authenticated
            echo "<h2>Welcome, $username!</h2>";
        } else {
            // Invalid password
            echo "<h2>Invalid password.</h2>";
        }
    } else {
        // Invalid username
        echo "<h2>Invalid username.</h2>";
    }
}

$conn->close();
?>


</body>
<footer>
    <h1> @Baćani Leon IRAČ 2023 </h1>
</footer>
</html>
