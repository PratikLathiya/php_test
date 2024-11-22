<?php


$dataFile = 'data.json';
if (!file_exists($dataFile)) {
    file_put_contents($dataFile, json_encode([]));
}

$data = json_decode(file_get_contents($dataFile), true);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $productName = $_POST['productName'] ?? '';
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;
    $price = isset($_POST['price']) ? (float)$_POST['price'] : 0.0;
    // Add new entry
    $newEntry = [
        'productName' => $productName,
        'quantity' => $quantity,
        'price' => $price,
        'datetime' => date('Y-m-d H:i:s'),
        'totalValue' => $quantity * $price,
    ];
    $data[] = $newEntry;
    
    file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT));

    // Return updated data as JSON
    echo json_encode($data);
    exit;
}
$totalSum = 0;
foreach ($data as $entry) {
    $totalSum += $entry['totalValue'];
}
echo json_encode(['data' => $data, 'totalSum' => $totalSum]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Skill Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.bundle.min.css"></script>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Product Form</h1>
        <form id="productForm" class="mb-4">
            <div class="mb-3">
                <label for="productName" class="form-label">Product Name</label>
                <input type="text" name="productName" id="productName" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="quantitz" class="form-label">Quantity in Stock</label>
                <input type="number" name="quantity" id="quantity" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price per Item</label>
                <input type="number" step="0.01" name="price" id="price" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <h2>Submitted Data</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Datetime</th>
                    <th>Total Value</th>
                </tr>
            </thead>
            <tbody id="dataTable">
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td><?= $row['productName'] ?></td>
                        <td><?= $row['quantity'] ?></td>
                        <td><?= $row['price'] ?></td>
                        <td><?= $row['datetime'] ?></td>
                        <td><?= $row['totalValue'] ?></td>
                    </tr>
                <?php endforeach ?>
                <tr>
                    <td colspan="4"><strong>Grand Total</strong></td>
                    <td><?= $totalSum ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <script src="assets/js/scripts.js"></script>
</body>
</html>