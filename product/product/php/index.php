<?php
include( '../../connection/connection.php' );

// Fetching bicycles from the database
$query = "SELECT bicycles.brandCode, bicycles.brandName, bicycles.quantity, suppliers.name AS supplierName, bicycles.image_url 
          FROM bicycles 
          JOIN suppliers ON bicycles.supplierId = suppliers.id";

$result = mysqli_query( $connection, $query );

if ( !$result ) {
    echo 'Error fetching bicycles: ' . mysqli_error( $connection );
    exit;
}
?>

<!DOCTYPE html>
<html lang = 'en'>

<head>
<meta charset = 'UTF-8'>
<meta name = 'viewport' content = 'width=device-width, initial-scale=1.0'>
<title>Product - Cycle City</title>
<link rel = 'stylesheet' href = '../css/styles.css?v=<?php echo time(); ?>'>
<link rel = 'stylesheet' href = '../../style.css?v=<?php echo time(); ?>'>
<link rel = 'stylesheet' href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css'
integrity = 'sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=='
crossorigin = 'anonymous' referrerpolicy = 'no-referrer' />
</head>

<body>
<main>
<!-- HEADER - SECTION -->
<section class = 'header'>
<i class = 'fa-solid fa-bicycle'></i>
<nav>
<a href = '../../index/php/index.php'>
<p>HOME</p>
</a>
<a href = ''>
<p style = 'color: black !important;'>BICYCLE</p>
</a>
<a href = '../../about_us/html/index.html'>
<p>ABOUT US</p>
</a>
<a href = '../../contact_us/html/index.html'>
<p>CONTACT US</p>
</a>
</nav>
<a href="../../cart/php/index.php">
    <i class = 'fa-solid fa-cart-shopping'></i>
</a>
</section>

<!-- PRODUCT LIST - SECTION -->
<section class = 'product-list'>
<h1>BICYCLES</h1>
<div class = 'new-arrival-content'>

<?php
while ( $row = mysqli_fetch_assoc( $result ) ) {
    $detailPageUrl = '../../detail/php/index.php?brandCode=' . urlencode( $row[ 'brandCode' ] );
    ?>
    <article>
    <a href = "<?php echo $detailPageUrl; ?>" style = 'text-decoration: none; color: inherit;'>
    <img src = "<?php echo $row['image_url']; ?>" alt = "<?php echo $row['brandName']; ?> Image">
    <h3><?php echo $row[ 'brandName' ];
    ?></h3>
    <h4>Brand Code: <?php echo $row[ 'brandCode' ];
    ?></h4>
    <p>Quantity: <?php echo $row[ 'quantity' ];
    ?></p>
    <p>Supplier: <?php echo $row[ 'supplierName' ];
    ?></p>
    </a>
    </article>
    <?php
}

?>
</div>

</section>

<!-- FOOTER - SECTION -->
<section class = 'footer'>
<div class = 'left-footer'>
<div class = 'navigaional-links'>
<dl>
<dt><a href = '../../index/php/index.php'>HOME</a></dt>
<dt><a href = '' style = 'color: red !important;'>BICYCLE</a></dt>
<dt><a href = '../../about_us/html/index.html'>ABOUT US</a></dt>
<dt><a href = '../../contact_us/html/index.html'>CONTACT US</a></dt>
</dl>
</div>
</div>
<div class = 'right-footer'>
<p>&copy;
2024 Cycle City. All rights reserved.</p>
</div>
</section>
</main>
</body>

</html>
