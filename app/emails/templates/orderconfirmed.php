<?php
function generateItemList($items) {
    $itemListHtml = '<table>
                        <thead>
                            <tr>
                                <th>Product Image</th>
                                <th>Product Name</th>
                                <th>Color</th>
                                <th>Storage</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>';

    foreach ($items as $item) {
        $productName = htmlspecialchars($item['product_name']);
        $color = htmlspecialchars($item['color']);
        $storage = htmlspecialchars($item['storage']);
        $quantity = htmlspecialchars($item['quantity']);
        $price = htmlspecialchars(number_format($item['price'], 2)); // Assuming price is a float
        $total = htmlspecialchars(number_format($item['price'] * $item['quantity'], 2));
        $imageUrl = htmlspecialchars($item['image_url']); // Extract image URL and escape HTML

        $itemListHtml .= "<tr>
                            <td><img src=\"$imageUrl\" alt=\"$productName\" style=\"width: 100px; height: auto;\" /></td>
                            <td>$productName</td>
                            <td>$color</td>
                            <td>$storage</td>
                            <td>$quantity</td>
                            <td>KES $price</td>
                            <td>KES $total</td>
                          </tr>";
    }

    $itemListHtml .= '</tbody></table>';

    return $itemListHtml;
}

function getOrderConfirmationTemplate(
    $username,
    $orderNumber,
    $items,
    $subtotal,
    $taxAmount,
    $totalAmount,
    $cardBrand,
    $cardLast4,
    $address,
    $apartment,
    $city,
    $county,
    $phoneNumber
) {
    // Generate the item list HTML
    $itemListHtml = generateItemList($items);

    // Email body template
    $template = "
    <html>
    <head>
        <style>
            table { width: 100%; border-collapse: collapse; }
            th, td { border: 1px solid #ddd; padding: 8px; }
            th { background-color: #f4f4f4; }
        </style>
    </head>
    <body>
        <h2>Thank you for your order, $username!</h2>
        <p>Your order number is <strong>$orderNumber</strong>.</p>
        <p>Payment Method: $cardBrand ending in $cardLast4</p>
        <p>Shipping Address:</p>
        <p>$address, $apartment, $city, $county</p>
        <p>Phone Number: $phoneNumber</p>
        <p>Subtotal: KES $subtotal</p>
        <p>Tax (16%): KES $taxAmount</p>
        <p>Total Amount: KES $totalAmount</p>
        <p>Order Details:</p>
        $itemListHtml
    </body>
    </html>";

    return $template;
}
