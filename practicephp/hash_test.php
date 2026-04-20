<?php
$password = "david123";
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

if (password_verify("david123", $hashedPassword)) {
    echo "Password is correct";
} else {
    echo "Password is wrong";
}
?>