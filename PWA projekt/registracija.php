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


<!DOCTYPE html>
<html>
<head>
  <title>User Registration Form</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      // Check if username is already taken
      $('#username').on('blur', function() {
        var username = $(this).val();
        $.ajax({
          type: 'POST',
          url: 'check_username.php', // Path to PHP script for checking username availability
          data: { username: username },
          success: function(response) {
            if (response === 'taken') {
              $('#username').addClass('invalid');
              $('#username-error').text('Username is already taken. Please choose a different one.');
            } else {
              $('#username').removeClass('invalid');
              $('#username-error').text('');
            }
          }
        });
      });
    });
  </script>
  <style>
    .invalid {
      border: 2px solid red;
    }
  </style>
</head>
<body>
  <?php
  // Database configuration
  $host = 'localhost';
  $username = 'root';
  $password = '';
  $database = 'projekt';

  // Establish a database connection
  $conn = mysqli_connect($host, $username, $password, $database);

  // Check if the connection was successful
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // Check if the form is submitted
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $username = $_POST['username'];
    $name = $_POST['name'];
    $lastName = $_POST['last_name'];
    $password = $_POST['password'];
    $authorityLevel = isset($_POST['authority_level']) ? $_POST['authority_level'] : 1;

    // Hash the password with Blowfish
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Check if username is already taken
    $query = "SELECT korisnicko_ime FROM korisnik WHERE korisnicko_ime = '$username'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
      echo "<script>alert('Username is already taken. Please choose a different one.');</script>";
    } else {
      // Insert user data into the database
      $sql = "INSERT INTO korisnik (ime, prezime, korisnicko_ime, lozinka, razina) VALUES ('$name', '$lastName', '$username', '$hashedPassword', $authorityLevel)";
      if (mysqli_query($conn, $sql)) {
        echo "User registered successfully!";
      } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }
    }

    // Close the database connection
    mysqli_close($conn);
  }
  ?>

 <h2>User Registration</h2>
  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
    <label for="username">Username:</label>
    <input type="text" name="username" required>

    <label for="name">Name:</label>
    <input type="text" name="name" required>

    <label for="last_name">Last Name:</label>
    <input type="text" name="last_name" required>

    <label for="password">Password:</label>
    <input type="password" name="password" required>

    <label for="authority_level">Authority Level:</label>
    <select name="authority_level" required>
      <option value="1">Level 1</option>
      <option value="2">Level 2</option>
      <option value="3">Level 3</option>
    </select>

    <button type="submit">Register</button>
  </form>
</body>
</html>