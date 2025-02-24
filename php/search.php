<?php
// search.php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = $_POST['query'];
    
    // Escape user input to prevent SQL injection
    $query = $conn->real_escape_string($query);
    
    // SQL query to search items
    $sql = "SELECT * FROM items WHERE name LIKE '%$query%' OR description LIKE '%$query%'";
    $result = $conn->query($sql);

    // Check if results are found
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<p><strong>" . $row['name'] . "</strong>: " . $row['description'] . "</p>";
        }
    } else {
        echo "No results found.";
    }
}
?>
