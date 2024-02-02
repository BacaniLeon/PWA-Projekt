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
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projekt";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $category = isset($_GET['category']) ? $_GET['category'] : '';

    // Display sport and kultura news articles with arhiva = 0 on POČETNA page or when no category is selected
    if (empty($category) || $category === 'pocetna') {
        $sportSql = "SELECT * FROM vijesti WHERE kategorija = 'sport' AND arhiva = 0";
        $sportResult = $conn->query($sportSql);

        if ($sportResult->num_rows > 0) {
            echo "<section>";
            echo "<h2>SPORT</h2>";
            echo "<div>";
            
            while ($row = $sportResult->fetch_assoc()) {
                $naslov = $row["naslov"];
                $slika = $row["slika"];
                $link = "clanak.php?id=" . $row["id"];

                echo "<article>";
                echo "<a href='$link' class='newpage'>";
                echo "<picture>";
                echo "<img src='slike/$slika' alt='slika'>";
                echo "</picture>";
                echo "<p>$naslov</p>";
                echo "</a>";
                echo "</article>";
            }
            
            echo "</div>";
            echo "</section>";
        } else {
            echo "No sport news articles found.";
        }

        $kulturaSql = "SELECT * FROM vijesti WHERE kategorija = 'kultura' AND arhiva = 0";
        $kulturaResult = $conn->query($kulturaSql);

        if ($kulturaResult->num_rows > 0) {
            echo "<section>";
            echo "<h2>KULTURA</h2>";
            echo "<div>";
            
            while ($row = $kulturaResult->fetch_assoc()) {
                $naslov = $row["naslov"];
                $slika = $row["slika"];
                $link = "clanak.php?id=" . $row["id"];

                echo "<article>";
                echo "<a href='$link' class='newpage'>";
                echo "<picture>";
                echo "<img src='slike/$slika' alt='slika'>";
                echo "</picture>";
                echo "<p>$naslov</p>";
                echo "</a>";
                echo "</article>";
            }
            
            echo "</div>";
           
	}}
	

    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projekt";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $category = isset($_GET['category']) ? $_GET['category'] : '';

    if ($category) {
        $sql = "SELECT * FROM vijesti WHERE kategorija = '$category' AND arhiva IN (0, 1)";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<section>";
            echo "<h2>" . strtoupper($category) . "</h2>";
            echo "<div>";
            
            while ($row = $result->fetch_assoc()) {
                $naslov = $row["naslov"];
                $slika = $row["slika"];
                $link = "clanak.php?id=" . $row["id"];

                echo "<article>";
                echo "<a href='$link' class='newpage'>";
                echo "<picture>";
                echo "<img src='slike/$slika' alt='slika'>";
                echo "</picture>";
                echo "<p>$naslov</p>";
                echo "</a>";
                echo "</article>";
            }
            
            echo "</div>";
            echo "</section>";
        } else {
            echo "No news articles found in the selected category.";
        }
    }

    $conn->close();
    ?>
</body>
<footer>
    <h1> @Baćani Leon IRAČ 2023 </h1>
</footer>
</html>
