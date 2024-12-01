<?php
include('../../connection/connection.php');

// Assuming you are fetching the bicycle details using a brandCode
$brandCode = $_GET['brandCode'] ?? '';
$query = "SELECT bicycles.brandCode, bicycles.brandName, bicycles.quantity, suppliers.name AS supplierName, bicycles.image_url, bicycles.description 
          FROM bicycles 
          JOIN suppliers ON bicycles.supplierId = suppliers.id 
          WHERE bicycles.brandCode = '$brandCode'";

$result = mysqli_query($connection, $query);
$bicycle = mysqli_fetch_assoc($result);

if (!$bicycle) {
    echo 'Bicycle not found.';
    exit;
}

// Fetch the first customer from the 'customers' table
$customerQuery = "SELECT id FROM customers ORDER BY id ASC LIMIT 1";
$customerResult = mysqli_query($connection, $customerQuery);
$customer = mysqli_fetch_assoc($customerResult);

if (!$customer) {
    echo 'No customer found.';
    exit;
}

$customerId = $customer['id']; // First customer's ID

// Handle add to cart action
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the quantity from the POST request
    $quantity = (int)$_POST['quantity'];  // Ensure it's an integer

    // Check if the requested quantity is available
    if ($quantity <= $bicycle['quantity']) {
        $bc = $bicycle['brandCode'];

        // Insert item into the cart for the first customer
        $cartQuery = "INSERT INTO cart (user_id, product_code, quantity) VALUES ('$customerId', '$bc', $quantity)";
        mysqli_query($connection, $cartQuery);

        // Update the bicycle quantity in the database
        $newQuantity = $bicycle['quantity'] - $quantity;
        $updateQuery = "UPDATE bicycles SET quantity = $newQuantity WHERE brandCode = '$bc'";
        mysqli_query($connection, $updateQuery);

        echo "<script>alert('Product added to cart!');</script>";
    } else {
        echo "<script>alert('Requested quantity exceeds available stock.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title><?php echo htmlspecialchars($bicycle['brandName']); ?> - Details</title>
    <link rel='stylesheet' href='../css/styles.css?v=<?php echo time(); ?>'>
    <link rel='stylesheet' href='../../style.css?v=<?php echo time(); ?>'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css' 
    integrity='sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==' 
    crossorigin='anonymous' referrerpolicy='no-referrer' />
</head>
<body>
<main>
    <!-- HEADER SECTION -->
    <section class='header'>
        <i class='fa-solid fa-bicycle'></i>
        <nav>
            <a href='../../index/php/index.php'>
                <p>HOME</p>
            </a>
            <a href=''>
                <p style='color: black !important;'>BICYCLE</p>
            </a>
            <a href='../../about_us/html/index.html'>
                <p>ABOUT US</p>
            </a>
            <a href='../../contact_us/html/index.html'>
                <p>CONTACT US</p>
            </a>
        </nav>
<a href = '../../cart/php/index.php'>
        <i class='fa-solid fa-cart-shopping'></i>
</a>
    </section>

    <!-- BICYCLE DETAILS SECTION -->
    <section class='detail-section'>
        <div>
        <div class='left-detail'>
                <img src="<?php echo htmlspecialchars($bicycle['image_url']); ?>" alt="<?php echo htmlspecialchars($bicycle['brandName']); ?> Image" class='bicycle-image'>
            </div>
            <div class='right-detail'>
                <header>
                    <h1><?php echo htmlspecialchars($bicycle['brandName']); ?></h1>
                    <h3>Brand Code: <?php echo htmlspecialchars($bicycle['brandCode']); ?></h3>
                    <p><?php echo htmlspecialchars($bicycle['supplierName']); ?></p>
                    <p><?php echo htmlspecialchars($bicycle['description']); ?></p>
                </header>
                <form method='POST' action=''>
                    <label for='quantity'>Quantity:</label>
                    <input type='number' id='quantity' name='quantity' min='1' value='1' required>
                    <button type='submit' class='add-to-cart-button'>Add to Cart</button>
                </form>
                <button class='back-button' onclick='window.history.back()'>Go Back</button>
            </div>
        </div>
    </section>

    <!-- FOOTER SECTION -->
    <section class='footer'>
        <div class='left-footer'>
            <div class='navigaional-links'>
                <dl>
                    <dt><a href='../../index/php/index.php'>HOME</a></dt>
                    <dt><a href='' style='color: red !important;'>BICYCLE</a></dt>
                    <dt><a href='../../about_us/html/index.html'>ABOUT US</a></dt>
                    <dt><a href='../../contact_us/html/index.html'>CONTACT US</a></dt>
                </dl>
            </div>
        </div>
        <div class='right-footer'>
            <p>&copy; 2024 Cycle City. All rights reserved.</p>
        </div>
    </section>
</main>
</body>
</html>
