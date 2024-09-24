<?php

$OrderDeclined = '
<!DOCTYPE html>
<head>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;700&family=Serif&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: \'Nunito Sans\', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f0f0f0;
            font-size: 14px;
        }
        .container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            max-width: 180px;
        }
        h1, h2, .product-name {
            font-family: \'Serif\', serif;
            color: #0066cc;
        }
        h1 {
            font-size: 24px;
        }
        h2 {
            font-size: 20px;
        }
        h3 {
            font-size: 18px;
        }
        .order-details {
            background-color: #e6f2ff;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        .button {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            background-color: #0066cc;
            color: white;
            text-decoration: none;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #004080;
        }
        .button svg {
            margin-right: 8px;
        }
        .button.secondary {
            background-color: #f0f0f0;
            color: #0066cc;
            border: 1px solid #0066cc;
        }
        .button.secondary:hover {
            background-color: #e0e0e0;
        }
        .action-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .action-buttons .button {
            flex: 1;
            margin: 0 5px;
        }
        .products {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-top: 30px;
        }
        .product {
            width: 48%;
            margin-bottom: 20px;
            text-align: center;
        }
        .product img {
            max-width: 100%;
            border-radius: 8px;
        }
        .social-section {
            margin-top: 30px;
            padding: 20px 0;
            background-color: #f0f0f0;
            border-radius: 8px;
        }
        .social-links {
            text-align: center;
        }
        .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: black;
            text-decoration: none;
        }
        .social-links svg {
            width: 16px;
            height: 16px;
            transition: color 0.3s ease;
        }
        .social-links a:hover svg {
            color: #004080;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .footer a {
            color: #0066cc;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
        .subscribe {
            margin-top: 20px;
            padding: 20px;
            background-color: #e6f2ff;
            border-radius: 8px;
        }
        .subscribe input[type="email"] {
            padding: 10px;
            width: 60%;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }
        .subscribe input[type="submit"] {
            padding: 10px 20px;
            background-color: #0066cc;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        .table-responsive {
            overflow-x: auto;
        }
        .order-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .order-table th, .order-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            font-size: 14px;
        }
        .order-table th {
            background-color: #f2f2f2;
        }
        .product-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
            vertical-align: middle;
            margin-right: 10px;
        }
        .product-name {
            vertical-align: middle;
            font-size: 16px;
        }
        .order-summary {
            margin-top: 20px;
            border-top: 2px solid #ddd;
            padding-top: 20px;
        }
        .separator {
            height: 2px;
            background-color: #e0e0e0;
            margin: 30px 0;
        }
        .light-bg {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
        }
        .medium-bg {
            background-color: #f0f0f0;
            padding: 20px;
            border-radius: 8px;
        }
        @media screen and (max-width: 600px) {
            .order-table thead {
                display: none;
            }
            .order-table, .order-table tbody, .order-table tr, .order-table td {
                display: block;
            }
            .order-table tr {
                margin-bottom: 20px;
                border: 1px solid #ddd;
            }
            .order-table td {
                border: none;
                position: relative;
                padding-left: 50%;
            }
            .order-table td:before {
                content: attr(data-label);
                position: absolute;
                left: 6px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                font-weight: bold;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="[APPLE_JUNCTION_LOGO_URL]" alt="Apple Junction Logo" class="logo">
        </div>

        <h1>Your Apple Junction Order is Complete!</h1>

        <p>Hey {{username}},</p>

        <p>Fantastic news! Your order from Apple Junction has been successfully processed and is on its way to you.</p>

        <div class="order-details">
            <h2>Order Details:</h2>
            <div class="table-responsive">
                <table class="order-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td data-label="Product">
                                <img src="[PRODUCT_1_IMAGE_URL]" alt="Product 1" class="product-image">
                                <span class="product-name">[PRODUCT_1_NAME]</span>
                            </td>
                            <td data-label="Price">[PRODUCT_1_PRICE]</td>
                            <td data-label="Quantity">[PRODUCT_1_QUANTITY]</td>
                            <td data-label="Total">[PRODUCT_1_TOTAL]</td>
                        </tr>
                        <tr>
                            <td data-label="Product">
                                <img src="[PRODUCT_2_IMAGE_URL]" alt="Product 2" class="product-image">
                                <span class="product-name">[PRODUCT_2_NAME]</span>
                            </td>
                            <td data-label="Price">[PRODUCT_2_PRICE]</td>
                            <td data-label="Quantity">[PRODUCT_2_QUANTITY]</td>
                            <td data-label="Total">[PRODUCT_2_TOTAL]</td>
                        </tr>
                        <!-- Add more product rows as needed -->
                    </tbody>
                </table>
            </div>
            <div class="order-summary">
                <p><strong>Subtotal:</strong> [ORDER_SUBTOTAL]</p>
                <p><strong>Shipping:</strong> [SHIPPING_COST]</p>
                <p><strong>Tax:</strong> [TAX_AMOUNT]</p>
                <p><strong>Total:</strong> [ORDER_TOTAL]</p>
                <p><strong>Payment Method:</strong> [PAYMENT_METHOD]</p>
            </div>
        </div>

        <div class="action-buttons">
            <a href="[ORDER_TRACKING_LINK]" class="button">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
                Track Your Order
            </a>
            <a href="[INVOICE_PDF_LINK]" class="button secondary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="7 10 12 15 17 10"></polyline>
                    <line x1="12" y1="15" x2="12" y2="3"></line>
                </svg>
                Download Invoice
            </a>
        </div>

        <div class="separator"></div>

        <h2>Check out our latest products:</h2>

        <div class="products">
            <div class="product">
                <img src="[IPHONE_IMAGE_URL]" alt="Latest iPhone">
                <h3 class="product-name">iPhone 15 Pro</h3>
                <p>Experience the future of smartphones!</p>
                <a href="[IPHONE_LINK]" class="button">Shop Now</a>
            </div>
            <div class="product">
                <img src="[IPAD_IMAGE_URL]" alt="New iPad">
                <h3 class="product-name">iPad Air</h3>
                <p>Powerful. Colorful. Wonderful.</p>
                <a href="[IPAD_LINK]" class="button">Shop Now</a>
            </div>
        </div>

        <p>Thank you for choosing Apple Junction. We hope you love your new Apple products!</p>

        <p>Got questions? Our friendly <a href="">team</a> is here to help!</p>

        <p>Stay connected,<br>The Apple Junction Team</p>

        <div class="separator"></div>

        <div class="subscribe light-bg">
            <h3>Get Awesome Deals!</h3>
            <p>Subscribe to our promotional emails:</p>
            <form action="[SUBSCRIBE_FORM_ACTION]" method="POST">
                <input type="email" name="email" placeholder="Enter your email" required>
                <input type="submit" value="Subscribe">
            </form>
        </div>
        
        <div class="separator"></div>

        <div class="social-section">
            <div class="social-links">
                <a href="[FACEBOOK_LINK]" aria-label="Facebook">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18.77 7.46H14.5v-1.9c0-.9.6-1.1 1-1.1h3V.5h-4.33C10.24.5 9.5 3.44 9.5 5.32v2.15h-3v4h3v12h5v-12h3.85l.42-4z"/>
                    </svg>
                </a>
                <a href="[INSTAGRAM_LINK]" aria-label="Instagram">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                </a>
                <a href="[X_LINK]" aria-label="X (Twitter)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                    </svg>
                </a>
                <a href="[WHATSAPP_LINK]" aria-label="WhatsApp">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                </a>
            </div>
        </div>

        <div class="separator"></div>

        <div class="footer medium-bg">
            <p>
                <a href="[PRIVACY_POLICY_LINK]">Privacy Policy</a> |
                <a href="[RETURN_POLICY_LINK]">Return & Refund Policy</a> |
                <a href="[SUPPORT_LINK]">Support</a>
            </p>
            <p>&copy; 2024 Apple Junction. All rights reserved.</p>
        </div>
    </div>
</body>
</html>';