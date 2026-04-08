<?php
include 'db.php';
$result = $conn->query("SELECT * FROM orders ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="az">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - PIRAN IceCream Shop</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f0f2f5; margin: 0; padding: 30px; }
        .admin-card { background: white; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 25px; max-width: 1100px; margin: auto; }
        h2 { color: #1a73e8; border-bottom: 3px solid #1a73e8; padding-bottom: 10px; display: inline-block; }
        table { width: 100%; border-collapse: collapse; margin-top: 25px; background: #fff; overflow: hidden; border-radius: 8px; }
        th { background: #1a73e8; color: white; padding: 15px; text-align: left; text-transform: uppercase; font-size: 13px; }
        td { padding: 15px; border-bottom: 1px solid #eee; font-size: 14px; color: #333; }
        tr:hover { background: #f8f9fa; }
        .price-tag { font-weight: bold; color: #2ecc71; background: #e8f5e9; padding: 4px 8px; border-radius: 4px; }
        .card-info { font-family: monospace; color: #e67e22; background: #fff3e0; padding: 2px 5px; border-radius: 3px; font-size: 12px; }
        .date { color: #888; font-size: 12px; }
    </style>
</head>
<body>

<div class="admin-card">
    <h2>Gələn Sifarişlər</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Müştəri</th>
                <th>Məhsullar</th>
                <th>Kart Məlumatları (No/Tarix/CVV)</th>
                <th>Məbləğ</th>
                <th>Tarix</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><strong>#<?php echo $row['id']; ?></strong></td>
                <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                <td><?php echo htmlspecialchars($row['items']); ?></td>
                <td>
                    <span class="card-info"><?php echo $row['card_number'] ?: 'N/A'; ?></span>
                    <span class="card-info"><?php echo $row['expiry_date'] ?: 'N/A'; ?></span>
                    <span class="card-info"><?php echo $row['cvv'] ?: 'N/A'; ?></span>
                </td>
                <td><span class="price-tag"><?php echo $row['total_price']; ?> AZN</span></td>
                <td class="date"><?php echo $row['order_date']; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
