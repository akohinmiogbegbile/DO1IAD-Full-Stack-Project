<form method="POST" action="post_test.php">
  <input type="text" name="username">
  <button type="submit">Submit</button>
</form>

<?php
$username = $_POST['username'];

echo "Username: " . $username;
?>