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
</nav>

</header>
<body class="posebanbody">
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projekt";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_GET['id'])) {
        $articleId = $_GET['id'];

        $sql = "SELECT * FROM vijesti WHERE id = $articleId";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $category = $row["kategorija"];
            $title = $row["naslov"];
            $photo = "slike/" . $row["slika"];
            $about = $row["sazetak"];
            $content = $row["tekst"];

            // Display the selected article
            echo "<h2>$category</h2>";
            echo "<div>";
            echo "<article class='zaseban'>";
            echo "<h3>$title</h3>";
            echo "<picture><img src='$photo'></picture>";
            echo "<p class='zasebanp'>$about</p>";
            echo "<p class='zasebanp'>$content</p>";
            echo "</article>";
            echo "</div>";

            // Option to delete the article
            echo "<form method='post'>";
            echo "<input type='hidden' name='articleId' value='$articleId'>";
            echo "<button type='submit' name='deleteArticle'>Delete Article</button>";
            echo "</form>";

            // Check if the delete button is clicked
            if (isset($_POST['deleteArticle'])) {
                $articleId = $_POST['articleId'];

                // Delete the article from the database
                $deleteSql = "DELETE FROM vijesti WHERE id = $articleId";
                if ($conn->query($deleteSql) === TRUE) {
                    echo "Article deleted successfully.";

                    // Redirect to pocetna (index.php) after deletion
                    header("Location: index.php");
                    exit();
                } else {
                    echo "Error deleting the article: " . $conn->error;
                }
            }
        } else {
            echo "Article not found.";
        }
    } else {
        echo "Invalid article ID.";
    }

    $conn->close();
    ?>

    <!-- Navigation bar to go back -->
    <nav class="back-nav">
        <a href="index.php">Go back</a>
    </nav>
</body>

<footer>
    <h1> @Baćani Leon IRA
</html>