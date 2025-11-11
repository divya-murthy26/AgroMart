<?php
include("../Includes/db.php");

/**
 * This script acts as a webhook for an SMS gateway.
 * It expects to receive POST data from the gateway, typically including:
 * - 'from': The sender's phone number.
 * - 'body': The content of the SMS message.
 *
 * Example SMS formats:
 * INSERT: *#*,insert,password,product title,category,type,stock,price,keywords,description,delivery
 * UPDATE: *#*,update,password,product title,category,type,stock,price,keywords,description,delivery
 * DELETE: *#*,delete,password,product title
 */

// --- Helper function to send SMS response (placeholder) ---
// In a real application, you would use your SMS gateway's API here.
function send_sms_response($to, $message) {
    // Placeholder: In a real scenario, you would integrate with an SMS API.
    // For now, we can log it to a file for testing.
    $log_message = "SMS to " . $to . ": " . $message . "\n";
    file_put_contents("sms_log.txt", $log_message, FILE_APPEND);
}

// --- Main Logic ---

// Use test data if not receiving a real POST request from a gateway
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Example for testing: uncomment one of these to test
    // $_POST['from'] = '9876543210'; // A registered farmer's phone number
    // $_POST['body'] = '*#*,insert,password123,Fresh Carrots,Vegetables,Carrot,50,40,fresh organic,From our farm,yes';
    // $_POST['body'] = '*#*,update,password123,Fresh Carrots,Vegetables,Carrot,75,38,fresh organic tasty,From our farm,yes';
    // $_POST['body'] = '*#*,delete,password123,Fresh Carrots';

    // If no test data, exit.
    if (!isset($_POST['body'])) {
        exit("No SMS data received.");
    }
}

$from_number = $_POST['from'];
$sms_body = trim($_POST['body']);

$parts = explode(',', $sms_body);

// 1. Basic validation of the SMS format
if (count($parts) < 3 || trim($parts[0]) !== '*#*') {
    send_sms_response($from_number, "Error: Invalid SMS format. Please check the syntax and try again.");
    exit;
}

$action = trim(strtolower($parts[1]));
$password = trim($parts[2]);

// 2. Authenticate the farmer
$phone_number_safe = mysqli_real_escape_string($con, $from_number);

// Encrypt the provided password to match the one in the database
$ciphering = "AES-128-CTR";
$encryption_iv = '2345678910111211';
$encryption_key = "DE";
$encrypted_password = openssl_encrypt($password, $ciphering, $encryption_key, 0, $encryption_iv);

$farmer_query = "SELECT farmer_id FROM farmerregistration WHERE farmer_phone = '$phone_number_safe' AND farmer_password = '$encrypted_password'";
$result = mysqli_query($con, $farmer_query);

if (mysqli_num_rows($result) == 0) {
    send_sms_response($from_number, "Error: Authentication failed. Please check your phone number and password.");
    exit;
}

$farmer_row = mysqli_fetch_assoc($result);
$farmer_id = $farmer_row['farmer_id'];

// 3. Perform the requested action
switch ($action) {
    case 'insert':
        // Expected format: *#*,insert,password,title,category,type,stock,price,keywords,desc,delivery
        if (count($parts) < 11) {
            send_sms_response($from_number, "Error: INSERT command has missing fields. Please check the format.");
            break;
        }
        
        $product_title = mysqli_real_escape_string($con, trim($parts[3]));
        $product_cat_name = mysqli_real_escape_string($con, trim($parts[4]));
        // For simplicity, we'll assume category name is unique. In a real app, you might use ID.
        $cat_query = mysqli_query($con, "SELECT cat_id FROM categories WHERE cat_title LIKE '%$product_cat_name%' LIMIT 1");
        $cat_id = mysqli_fetch_assoc($cat_query)['cat_id'] ?? 1; // Default to 1 if not found

        $product_type = mysqli_real_escape_string($con, trim($parts[5]));
        $product_stock = (int)trim($parts[6]);
        $product_price = (float)trim($parts[7]);
        $product_keywords = mysqli_real_escape_string($con, trim($parts[8]));
        $product_desc = mysqli_real_escape_string($con, trim($parts[9]));
        $product_delivery = strtolower(trim($parts[10])) === 'yes' ? 'yes' : 'no';

        $insert_sql = "INSERT INTO products (farmer_fk, product_title, product_cat, product_type, product_stock, product_price, product_desc, product_keywords, product_delivery) 
                       VALUES ('$farmer_id', '$product_title', '$cat_id', '$product_type', '$product_stock', '$product_price', '$product_desc', '$product_keywords', '$product_delivery')";

        if (mysqli_query($con, $insert_sql)) {
            send_sms_response($from_number, "Success: Product '$product_title' has been added.");
        } else {
            send_sms_response($from_number, "Error: Could not add product. Database error.");
        }
        break;

    case 'update':
        // Expected format: *#*,update,password,title,category,type,stock,price,keywords,desc,delivery
        if (count($parts) < 11) {
            send_sms_response($from_number, "Error: UPDATE command has missing fields. Please check the format.");
            break;
        }

        $product_title = mysqli_real_escape_string($con, trim($parts[3]));
        $product_cat_name = mysqli_real_escape_string($con, trim($parts[4]));
        $cat_query = mysqli_query($con, "SELECT cat_id FROM categories WHERE cat_title LIKE '%$product_cat_name%' LIMIT 1");
        $cat_id = mysqli_fetch_assoc($cat_query)['cat_id'] ?? 1;

        $product_type = mysqli_real_escape_string($con, trim($parts[5]));
        $product_stock = (int)trim($parts[6]);
        $product_price = (float)trim($parts[7]);
        $product_keywords = mysqli_real_escape_string($con, trim($parts[8]));
        $product_desc = mysqli_real_escape_string($con, trim($parts[9]));
        $product_delivery = strtolower(trim($parts[10])) === 'yes' ? 'yes' : 'no';

        $update_sql = "UPDATE products SET product_cat='$cat_id', product_type='$product_type', product_stock='$product_stock', product_price='$product_price', product_desc='$product_desc', product_keywords='$product_keywords', product_delivery='$product_delivery' 
                       WHERE farmer_fk = '$farmer_id' AND product_title = '$product_title'";

        if (mysqli_query($con, $update_sql)) {
            send_sms_response($from_number, "Success: Product '$product_title' has been updated.");
        } else {
            send_sms_response($from_number, "Error: Could not update product. Make sure the product title is correct.");
        }
        break;

    case 'delete':
        // Expected format: *#*,delete,password,product title
        if (count($parts) < 4) {
            send_sms_response($from_number, "Error: DELETE command has missing fields.");
            break;
        }
        $product_title = mysqli_real_escape_string($con, trim($parts[3]));

        $delete_sql = "DELETE FROM products WHERE farmer_fk = '$farmer_id' AND product_title = '$product_title'";
        
        if (mysqli_query($con, $delete_sql)) {
            if (mysqli_affected_rows($con) > 0) {
                send_sms_response($from_number, "Success: Product '$product_title' has been deleted.");
            } else {
                send_sms_response($from_number, "Warning: Product '$product_title' not found or already deleted.");
            }
        } else {
            send_sms_response($from_number, "Error: Could not delete product. Database error.");
        }
        break;

    default:
        send_sms_response($from_number, "Error: Unknown command '$action'. Please use 'insert', 'update', or 'delete'.");
        break;
}

mysqli_close($con);
?>