<?php
// Include PHPMailer classes
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';
require 'vendor/phpmailer/phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception; // Make sure this line is included
use PHPMailer\PHPMailer\SMTP;

require 'vendor/autoload.php';

try {
    // Create a new PHPMailer instance
    $mail = new PHPMailer(true); // Enable exceptions
    $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output
    $mail->isSMTP(); // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
    $mail->Port = 465; // TCP port to connect to for SSL
    $mail->SMTPAuth = true; // Enable SMTP authentication
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable SSL encryption
    $mail->Username = 'tycoonmudegu1@gmail.com';
    $mail->Password = 'pxem ykun mulq rzge';

    // Set additional headers
    $mail->setFrom('tycoonmudegu1@gmail.com', 'Test'); // Set sender of the email
    $mail->addAddress('tycoonmudegu@gmail.com', 'Tycoon'); // Add a recipient
    $mail->addCustomHeader('MIME-Version', '1.0');
    $mail->addCustomHeader('Content-type', 'text/html;charset=UTF-8');

    // Set email subject and body
    $mail->Subject = 'test';
    $mail->Body = '
    <!DOCTYPE html>
    <head>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;700&family=Serif&display=swap" rel="stylesheet">
  
</head>
<body>
    <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; background-color: #e9f1ff;">
  <!-- Header -->
<!-- Email Header -->
<div style="background-color: #e9f4ff; color: #333333; padding: 30px 20px; text-align: center; border-bottom: 1px solid #007BFF; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
  <!-- Logo and Company Name -->
  <div style="margin-bottom: 15px;">
    <img src="https://iconape.com/wp-content/files/qd/17570/svg/cib-apple-logo-icon-png-svg.png" alt="Company Logo" style="height: 60px; vertical-align: middle;">
    <span style="font-size: 28px; color: #007BFF; margin-left: 10px; vertical-align: middle; font-family: Arial, sans-serif; font-weight: bold;">AppleJunction Ke</span>
  </div>



  <!-- Greeting or Introduction -->
  <div style="margin-bottom: 20px;">
    <h1 style="font-size: 26px; margin: 0; color: #333333;">Thank You for Your Order!</h1>
    <p style="font-size: 16px; margin: 10px 0;">We are excited to let you know that your order is on its way. Below you will find the details of your purchase and shipping information.</p>
  </div>

  <!-- Call-to-Action Buttons -->
  <div style="margin-top: 20px;">
    <a href="[Track Order URL]" style="display: inline-block; background-color: #007BFF; color: #ffffff; text-decoration: none; padding: 6px 12px; border-radius: 4px; font-size: 12px; margin: 0 8px;">Track Order</a>
    <a href="[Download Receipt URL]" style="display: inline-block; background-color: #007BFF; color: #ffffff; text-decoration: none; padding: 6px 12px; border-radius: 4px; font-size: 12px; margin: 0 8px;">Download Receipt</a>
  </div>
</div>




  <!-- Body -->
  <div style="padding: 20px; background-color: #ffffff;">
    <p style="font-size: 14px; color: #333333; margin: 0 0 20px 0;">Hi [Customer Name],</p>
    <p style="font-size: 14px; color: #333333; margin: 0 0 20px 0;">Thank you for your purchase! Your order <strong>#12345</strong> has been confirmed and is being processed.</p>
    
     <div style="background-color: #e9f1ff; padding: 20px; border-radius: 8px;">
     
    <!-- Order Summary and Details -->
    <div style="background-color: #ffffff; padding: 20px; border-radius: 8px;">
      <!-- Order Summary -->
      <h3 style="font-size: 16px; color: #007BFF; margin-bottom: 10px; border-bottom: 2px solid #007BFF; padding-bottom: 5px;">Order Summary</h3>
      
      <!-- Product List -->
      <div style="border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; margin-bottom: 20px;">
        <div style="display: flex; align-items: center; border-bottom: 1px solid #e0e0e0; padding: 10px;">
          <img src="[Product Image URL]" alt="Product Name" style="width: 80px; height: 80px; border-radius: 8px; object-fit: cover; margin-right: 10px;">
          <div style="flex: 1;">
            <h4 style="font-size: 14px; color: #333333; margin: 0;">Product Name</h4>
            <p style="font-size: 12px; color: #555555; margin: 5px 0;">Description: Short description of the product.</p>
            <p style="font-size: 12px; color: #555555; margin: 5px 0; text-align: right; font-weight: bold;">$99.99</p>
          </div>
        </div>
        <!-- Repeat above block for each product -->
      </div>

      <!-- Order Totals -->
      <div style="border-top: 1px solid #e0e0e0; padding-top: 10px;">
        <table style="width: 100%; border-collapse: collapse;">
          <tfoot>
            <tr>
              <td colspan="2" style="padding: 8px; text-align: right; font-size: 14px; font-weight: bold;">Subtotal</td>
              <td style="padding: 8px; text-align: right; font-size: 14px;">$99.99</td>
            </tr>
            <tr>
              <td colspan="2" style="padding: 8px; text-align: right; font-size: 14px; font-weight: bold;">Shipping</td>
              <td style="padding: 8px; text-align: right; font-size: 14px;">$5.00</td>
            </tr>
            <tr>
              <td colspan="2" style="padding: 8px; text-align: right; font-size: 14px; font-weight: bold;">Total</td>
              <td style="padding: 8px; text-align: right; font-size: 16px; color: #007BFF;"><strong>$104.99</strong></td>
            </tr>
          </tfoot>
        </table>
      </div>

      <!-- Shipping and Billing Information -->
      <div style="display: flex; margin-top: 20px;">
        <!-- Shipping Information -->
        <div style="flex: 1; background-color: #f9f9f9; padding: 15px; border-radius: 8px; margin-right: 10px;">
          <h3 style="font-size: 16px; color: #007BFF; margin-bottom: 10px; border-bottom: 2px solid #007BFF; padding-bottom: 5px;">Shipping to:</h3>
          <p style="font-size: 14px; color: #333333; margin: 0 0 10px 0;">[Customer Address]</p>
          <p style="font-size: 14px; color: #333333; margin: 0;">Estimated Delivery: [Delivery Date]</p>
        </div>
        <!-- Billing Information -->
        <div style="flex: 1; background-color: #f9f9f9; padding: 15px; border-radius: 8px;">
          <h3 style="font-size: 16px; color: #007BFF; margin-bottom: 10px; border-bottom: 2px solid #007BFF; padding-bottom: 5px;">Billing Information</h3>
          <p style="font-size: 14px; color: #333333; margin: 0 0 10px 0;">Payment Method: [Payment Method] (ending in [XXXX])</p>
        </div>
      </div>
    </div>
  </div>

<!-- Recommendations Section -->
<div style="background-color: #f0f0f0; padding: 20px; border-radius: 8px; margin-top: 20px;">
  <h3 style="font-size: 18px; color: #007BFF; text-align: center; margin-bottom: 20px;">You Might Also Like</h3>
  <table width="100%" cellspacing="0" cellpadding="10" border="0" style="border-collapse: collapse; text-align: center;">
    <!-- First Row -->
    <tr>
      <!-- Product Card 1 -->
      <td style="width: 50%; vertical-align: top;">
        <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;">
          <tr>
            <td style="border-radius: 8px; overflow: hidden; background-color: #ffffff; border: 1px solid #e0e0e0;">
              <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ4aRsWxqmUwJz1uroUB9DbY69hdAqX6gWyTQ&s" alt="Apple Airpods Pro 2" style="width: 100%; height: 150px; object-fit: contain;">
              <div style="padding: 15px;">
                <h4 style="font-size: 14px; color: #333333; margin: 0 0 10px 0;">Apple Airpods Pro 2</h4>
                <a href="[Product URL]" style="background-color: #007BFF; color: #ffffff; text-decoration: none; padding: 10px 20px; border-radius: 4px; font-size: 14px; display: inline-block; width: calc(100% - 20px); margin-top: 10px;">Shop Now</a>
              </div>
            </td>
          </tr>
        </table>
      </td>
      <!-- Product Card 2 -->
      <td style="width: 50%; vertical-align: top;">
        <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;">
          <tr>
            <td style="border-radius: 8px; overflow: hidden; background-color: #ffffff; border: 1px solid #e0e0e0;">
              <img src="https://cdn.askul.co.jp/img/product/3L1/EJ40217_3L1.jpg" alt="iPad Mini" style="width: 100%; height: 150px; object-fit: contain;">
              <div style="padding: 15px;">
                <h4 style="font-size: 14px; color: #333333; margin: 0 0 10px 0;">iPad Mini</h4>
                <a href="[Product URL]" style="background-color: #007BFF; color: #ffffff; text-decoration: none; padding: 10px 20px; border-radius: 4px; font-size: 14px; display: inline-block; width: calc(100% - 20px); margin-top: 10px;">Shop Now</a>
              </div>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <!-- Second Row -->
    <tr>
      <!-- Product Card 3 -->
      <td style="width: 50%; vertical-align: top;">
        <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;">
          <tr>
            <td style="border-radius: 8px; overflow: hidden; background-color: #ffffff; border: 1px solid #e0e0e0;">
              <img src="https://images-na.ssl-images-amazon.com/images/I/61ROV484TkL._AC_UL210_SR210,210_.jpg" alt="Silicone Case" style="width: 100%; height: 150px; object-fit: contain;">
              <div style="padding: 15px;">
                <h4 style="font-size: 14px; color: #333333; margin: 0 0 10px 0;">Silicone Case</h4>
                <a href="[Product URL]" style="background-color: #007BFF; color: #ffffff; text-decoration: none; padding: 10px 20px; border-radius: 4px; font-size: 14px; display: inline-block; width: calc(100% - 20px); margin-top: 10px;">Shop Now</a>
              </div>
            </td>
          </tr>
        </table>
      </td>
      <!-- Product Card 4 -->
      <td style="width: 50%; vertical-align: top;">
        <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;">
          <tr>
            <td style="border-radius: 8px; overflow: hidden; background-color: #ffffff; border: 1px solid #e0e0e0;">
              <img src="https://www.thehypercart.com/wp-content/uploads/2023/08/25W-IPHONE-CHARGER-HEAD-KOFshop.com-1-300x300.jpg" alt="24W USB-C Charging Brick" style="width: 100%; height: 150px; object-fit: contain;">
              <div style="padding: 15px;">
                <h4 style="font-size: 14px; color: #333333; margin: 0 0 10px 0;">24W USB-C Charging Brick</h4>
                <a href="[Product URL]" style="background-color: #007BFF; color: #ffffff; text-decoration: none; padding: 10px 20px; border-radius: 4px; font-size: 14px; display: inline-block; width: calc(100% - 20px); margin-top: 10px;">Shop Now</a>
              </div>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</div>


    <!-- Contact Information -->
    <p style="font-size: 14px; color: #333333; margin: 20px 0;">If you have any questions or concerns, feel free to <a href="[Support URL]" style="color: #007BFF; text-decoration: none;">contact us</a>.</p>
    <p style="font-size: 14px; color: #333333; margin: 0;">Thank you for shopping with us!</p>
  </div>

  <!-- Footer -->
<!-- Email Footer -->
<div style="background-color: #333333; color: #ffffff; padding: 20px; text-align: center; border-top: 2px solid #007BFF;">
  <!-- Logo and Company Name -->
  <div style="margin-bottom: 15px;">
    <img src="[Logo URL]" alt="Company Logo" style="height: 40px; vertical-align: middle;">
    <span style="font-size: 20px; color: #ffffff; margin-left: 10px; vertical-align: middle;">Your Company Name</span>
  </div>

  <!-- Overall Rating -->
  <div style="margin-bottom: 15px;">
    <p style="font-size: 16px; margin: 0;">How was your experience?</p>
    <div style="font-size: 24px; color: #FFD700;">
      <span>&#128578;</span> <!-- Smiley face -->
      <span>&#128578;</span>
      <span>&#128578;</span>
      <span>&#128577;</span>
      <span>&#128577;</span>
    </div>
  </div>

  <!-- Social Media Icons -->
  <div>
    <a href="[Facebook URL]" style="display: inline-block; margin: 0 10px;">
      <img src="https://uxwing.com/wp-content/themes/uxwing/download/brands-and-social-media/facebook-app-round-white-icon.png" alt="Facebook" style="width: 24px; height: 24px;">
    </a>
    <a href="[Twitter URL]" style="display: inline-block; margin: 0 10px;">
      <img src="https://upload.wikimedia.org/wikipedia/commons/5/57/X_logo_2023_%28white%29.png" alt="Twitter" style="width: 24px; height: 24px;">
    </a>
    <a href="[Instagram URL]" style="display: inline-block; margin: 0 10px;">
      <img src="https://www.kortegaard.co.uk/wp-content/uploads/2020/06/best-solutions-of-instagram-png-transparent-png-images-unique-white-instagram-logo-outline-of-white-instagram-logo-outline-copy.png" alt="Instagram" style="width: 24px; height: 24px;">
    </a>
    <a href="[LinkedIn URL]" style="display: inline-block; margin: 0 10px;">
      <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT6H_rpJyIJIUWaHEjQB5jt_EqjMmKTZalG3g&s" alt="Whatsapp" style="width: 24px; height: 24px;">
    </a>
  </div>

  <!-- Unsubscribe Link -->
  <div style="margin-top: 15px; font-size: 12px;">
    <p style="margin: 0;">If you no longer wish to receive our amaizing emails, you can <a href="[Unsubscribe URL]" style="color: #007BFF; text-decoration: none;">unsubscribe here</a>.</p>
  </div>
</div>

</div>

</body>
</html>';
    


    // Send the email
    $mail->send();
    echo 'Message sent successfully!';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
