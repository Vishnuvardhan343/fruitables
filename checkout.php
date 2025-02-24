<?php
session_start();

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "ecommerce_db";

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $first_name = htmlspecialchars(trim($_POST['first_name'] ?? ''));
    $last_name = htmlspecialchars(trim($_POST['last_name'] ?? ''));
    $company_name = htmlspecialchars(trim($_POST['company_name'] ?? ''));
    $address = htmlspecialchars(trim($_POST['address'] ?? ''));
    $city = htmlspecialchars(trim($_POST['city'] ?? ''));
    $country = htmlspecialchars(trim($_POST['country'] ?? ''));
    $postcode = htmlspecialchars(trim($_POST['postcode'] ?? ''));
    $mobile = htmlspecialchars(trim($_POST['mobile'] ?? ''));
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $create_account = isset($_POST['create_account']) ? 1 : 0;
    $ship_different_address = isset($_POST['ship_different_address']) ? 1 : 0;

    // Check required fields
    if (!$first_name || !$last_name || !$email || !$address || !$city || !$country || !$postcode || !$mobile) {
        die("Error: All required fields must be filled.");
    }

    // Dummy subtotal and shipping (replace with actual logic if available)
    $subtotal = 414.00;
    $shipping = 0.00;
    $total = $subtotal + $shipping;

    // Insert billing details into the database (order_notes removed)
    $sql = "INSERT INTO billing_details 
        (first_name, last_name, company_name, address, city, country, postcode, mobile, email, create_account, ship_different_address, subtotal, shipping, total) 
        VALUES (:first_name, :last_name, :company_name, :address, :city, :country, :postcode, :mobile, :email, :create_account, :ship_different_address, :subtotal, :shipping, :total)";

    try {
        $stmt = $pdo->prepare($sql);

        // Bind parameters and execute
        $stmt->execute([
            ':first_name' => $first_name,
            ':last_name' => $last_name,
            ':company_name' => $company_name,
            ':address' => $address,
            ':city' => $city,
            ':country' => $country,
            ':postcode' => $postcode,
            ':mobile' => $mobile,
            ':email' => $email,
            ':create_account' => $create_account,
            ':ship_different_address' => $ship_different_address,
            ':subtotal' => $subtotal,
            ':shipping' => $shipping,
            ':total' => $total
        ]);
        echo "<script>
        alert('Order successful!');
        window.location.href = 'index.html';
    </script>";
    
    exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
