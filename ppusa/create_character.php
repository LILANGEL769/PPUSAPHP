<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Character</title>
</head>
<body>
  <h2>Create Your Character</h2>
  <form action="" method="post">
    <label for="username">Username:</label><br>
    <input type="text" id="username" name="username"><br>
    
    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password"><br>

    <label for="name">Name:</label><br>
    <input type="text" id="name" name="name"><br>

    <label for="age">Age:</label><br>
    <input type="number" id="age" name="age" min="18" max="100"><br>

    <label for="party">Political Party:</label><br>
    <select id="party" name="party">
      <option value="democrat">Democrat</option>
      <option value="republican">Republican</option>
    </select><br>

    <label for="social_stance">Social Stance:</label><br>
    <select id="social_stance" name="social_stance">
      <option value="far_right">Far Right</option>
      <option value="right">Right</option>
      <option value="moderate_right">Moderate Right</option>
      <option value="center">Center</option>
      <option value="moderate_left">Moderate Left</option>
      <option value="left">Left</option>
      <option value="far_left">Far Left</option>
    </select><br>

    <label for="economic_stance">Economic Stance:</label><br>
    <select id="economic_stance" name="economic_stance">
      <option value="far_right">Far Right</option>
      <option value="right">Right</option>
      <option value="moderate_right">Moderate Right</option>
      <option value="center">Center</option>
      <option value="moderate_left">Moderate Left</option>
      <option value="left">Left</option>
      <option value="far_left">Far Left</option>
    </select><br>

    <label for="state">State:</label><br>
    <input type="text" id="state" name="state"><br>

    <input type="submit" value="Create">
  </form>

  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Retrieve form data
      $username = $_POST['username'];
      $password = $_POST['password'];
      $name = $_POST['name'];
      $age = $_POST['age'];
      $party = $_POST['party'];
      $social_stance = $_POST['social_stance'];
      $economic_stance = $_POST['economic_stance'];
      $state = $_POST['state'];

      // Hash the password
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);

      // Connect to the MySQL database using mysqli
      $conn = new mysqli("localhost", "root", "", "ppusa database");

      // Check connection
      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      }

      // SQL query to insert user and character data into the database
      $sql = "INSERT INTO users (username, password, name, age, party, social_stance, economic_stance, state) 
              VALUES ('$username', '$hashed_password', '$name', '$age', '$party', '$social_stance', '$economic_stance', '$state')";
      
      if ($conn->query($sql) === TRUE) {
          echo "User and character created successfully!";
      } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
      }

      $conn->close();
  }
  ?>
</body>
</html>
