<?php
include 'db.php';

$result = $conn->query("SELECT * FROM users");

if ($result->num_rows > 0) {
    echo "<table><tr><th>ID</th><th>Email</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["id"]. "</td><td>" . $row["email"]. "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}
$conn->close();
?>