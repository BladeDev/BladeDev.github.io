<?php
// Function to read and parse bookings from a file
function readBookings($filename) {
    $bookings = [];
    $content = file_get_contents($filename);
    
    // Split the content by the separator
    $bookingTexts = explode("----------------------------------------", $content);
    
    foreach ($bookingTexts as $bookingText) {
        // Skip empty entries
        if (trim($bookingText) == '') {
            continue;
        }
        
        // Extract booking details using regex
        $booking = [];
        
        // Extract Booking ID
        preg_match('/Booking ID: (.+)/', $bookingText, $matches);
        if (isset($matches[1])) {
            $booking['id'] = trim($matches[1]);
        }
        
        // Extract Timestamp
        preg_match('/Timestamp: (.+)/', $bookingText, $matches);
        if (isset($matches[1])) {
            $booking['timestamp'] = trim($matches[1]);
        }
        
        // Extract Name
        preg_match('/Name: (.+)/', $bookingText, $matches);
        if (isset($matches[1])) {
            $booking['name'] = trim($matches[1]);
        }
        
        // Extract Email
        preg_match('/Email: (.+)/', $bookingText, $matches);
        if (isset($matches[1])) {
            $booking['email'] = trim($matches[1]);
        }
        
        // Extract Phone
        preg_match('/Phone: (.+)/', $bookingText, $matches);
        if (isset($matches[1])) {
            $booking['phone'] = trim($matches[1]);
        }
        
        // Extract Service
        preg_match('/Service: (.+)/', $bookingText, $matches);
        if (isset($matches[1])) {
            $booking['service'] = trim($matches[1]);
        }
        
        // Extract Requested Date
        preg_match('/Requested Date: (.+)/', $bookingText, $matches);
        if (isset($matches[1])) {
            $booking['date'] = trim($matches[1]);
        }
        
        // Extract Requested Time
        preg_match('/Requested Time: (.+)/', $bookingText, $matches);
        if (isset($matches[1])) {
            $booking['time'] = trim($matches[1]);
        }
        
        // Extract Message
        preg_match('/Message: (.+)/s', $bookingText, $matches);
        if (isset($matches[1])) {
            $booking['message'] = trim($matches[1]);
        }
        
        // Create datetime for sorting
        if (isset($booking['date']) && isset($booking['time'])) {
            $booking['datetime'] = $booking['date'] . ' ' . $booking['time'];
        }
        
        // Add the booking to the array
        if (!empty($booking)) {
            $bookings[] = $booking;
        }
    }
    
    return $bookings;
}

// Function to sort bookings by datetime in descending order
function sortBookingsByDatetimeDesc($bookings) {
    usort($bookings, function($a, $b) {
        return strtotime($b['datetime']) - strtotime($a['datetime']);
    });
    
    return $bookings;
}

// Function to display bookings
function displayBookings($bookings) {
    foreach ($bookings as $booking) {
        echo "Booking ID: " . $booking['id'] . "</br>";
        echo "Timestamp: " . $booking['timestamp'] . "</br>";
        echo "Name: " . $booking['name'] . "</br>";
        echo "Email: " . $booking['email'] . "</br>";
        echo "Phone: " . $booking['phone'] . "</br>";
        echo "Service: " . $booking['service'] . "</br>";
        echo "Requested Date: " . $booking['date'] . "</br>";
        echo "Requested Time: " . $booking['time'] . "</br>";
        echo "Message: " . $booking['message'] . "</br>";
        echo "----------------------------------------</br></br>";
    }
}

// Main execution
$filename = "bookings.txt";

// Check if file exists
if (!file_exists($filename)) {
    die("Error: File '$filename' not found.");
}

// Read bookings from file
$bookings = readBookings($filename);

// Sort bookings by datetime in descending order
$sortedBookings = sortBookingsByDatetimeDesc($bookings);

// Display sorted bookings
echo "Bookings sorted by datetime (descending):\n\n";
displayBookings($sortedBookings);
?>
