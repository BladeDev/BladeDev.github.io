<?php
// booking.php - Handle form submissions for massage salon bookings

// Set error reporting for debugging (remove in production)
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// Function to sanitize input data
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Initialize response array
$response = [
    'success' => false,
    'message' => ''
];

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize form data
    $name = isset($_POST["name"]) ? sanitizeInput($_POST["name"]) : "";
    $email = isset($_POST["email"]) ? sanitizeInput($_POST["email"]) : "";
    $phone = isset($_POST["phone"]) ? sanitizeInput($_POST["phone"]) : "";
    $service = isset($_POST["service"]) ? sanitizeInput($_POST["service"]) : "";
    $message = isset($_POST["message"]) ? sanitizeInput($_POST["message"]) : "";
    $date = isset($_POST["date"]) ? sanitizeInput($_POST["date"]) : "";
    $time = isset($_POST["time"]) ? sanitizeInput($_POST["time"]) : "";
    
    // Simple validation
    if (empty($name) || empty($email) || empty($phone) || empty($service) || empty($date) || empty($time)) {
        $response['message'] = "Vă rugăm să completați toate câmpurile obligatorii.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = "Vă rugăm să introduceți o adresă de e-mail validă.";
    } else {
        // Format the booking data
        $booking_id = uniqid();
        $timestamp = date("Y-m-d H:i:s");
        
        $booking_data = "Booking ID: $booking_id\n";
        $booking_data .= "Timestamp: $timestamp\n";
        $booking_data .= "Name: $name\n";
        $booking_data .= "Email: $email\n";
        $booking_data .= "Phone: $phone\n";
        $booking_data .= "Service: $service\n";
        $booking_data .= "Requested Date: $date\n";
        $booking_data .= "Requested Time: $time\n";
        $booking_data .= "Message: $message\n";
        $booking_data .= "----------------------------------------\n\n";
        
        // Define the path to the bookings file
        $bookings_file = "bookings.txt";
        
        // Try to write to the file
        $file_result = file_put_contents($bookings_file, $booking_data, FILE_APPEND | LOCK_EX);
        
        if ($file_result !== false) {
            $response['success'] = true;
            $response['message'] = "Vă mulțumim pentru cererea dvs. de rezervare! Vă vom contacta în scurt timp pentru a vă confirma programarea.";
            
            // Optional: Send email notification
            // $to = "salon@example.com";
            // $subject = "New Booking Request: $service";
            // $email_message = "A new booking request has been submitted.\n\n$booking_data";
            // $headers = "From: booking@yoursalon.com";
            // mail($to, $subject, $email_message, $headers);
        } else {
            $response['message'] = "Ne pare rău, a apărut o eroare în procesarea rezervării dvs. Vă rugăm să încercați din nou sau să ne contactați direct.";
        }
    }
}

// Return JSON response if it's an AJAX request
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// If it's not an AJAX request, redirect back to the form with a message
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $redirect = "index.html";
    
    // Add query parameter for success or error message
    if ($response['success']) {
        $redirect .= "?booking=success#contact";
    } else {
        $redirect .= "?booking=error&message=" . urlencode($response['message']) . "#contact";
    }
    
    header("Location: $redirect");
    exit;
}
?>
