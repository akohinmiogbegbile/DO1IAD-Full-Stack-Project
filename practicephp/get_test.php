<?php
$search = $_GET['query'];

echo "You searched for: " . $search;

if ($search == "football") {
    echo "<br>We found sports projects!";
}
?>