<!DOCTYPE html>
<html lang="en">

<head>

    <?php include 'header-link.php' ?>

</head>

<body>

    <?php include 'header.php' ?>

    <div class="track-order-container">
        <h2>Track Your Order</h2>
        <p>Enter your Order ID or Phone Number</p>

        <form id="trackOrderForm">
            <input type="text" placeholder="Enter Order ID" required>
            <input type="text"  placeholder="Mail or Number" required>
            <button type="submit" class="btn btn-secondary" id="trackBtn">Track Order</button>
        </form>
    </div>

    <?php include 'footer.php' ?>

</body>

</html>