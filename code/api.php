<?php
header("Content-Type: application/json");
$method = $_SERVER['REQUEST_METHOD'];

// Database connection
$servername = "localhost";
$username = "your_username"; // replace with your MySQL username
$password = "your_password"; // replace with your MySQL password
$dbname = "your_database"; // replace with your MySQL database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

switch ($method) {
    case 'GET':
        if (isset($_GET['endpoint']) && $_GET['endpoint'] == 'events') {
            $result = $conn->query('SELECT * FROM event');
            $events = [];
            while ($row = $result->fetch_assoc()) {
                $events[] = $row;
            }
            echo json_encode($events);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['endpoint']) && $data['endpoint'] == 'reservations') {
            $organization_name = $conn->real_escape_string($data['organization_name']);
            $event_name = $conn->real_escape_string($data['event_name']);
            $description = $conn->real_escape_string($data['description']);
            $date = $conn->real_escape_string($data['date']);
            $time_start = $conn->real_escape_string($data['time_start']);
            $time_end = $conn->real_escape_string($data['time_end']);

            // Insert organization
            $conn->query("INSERT INTO organization (name) VALUES ('$organization_name')");
            $organization_id = $conn->insert_id;

            // Insert event
            $conn->query("INSERT INTO event (organization_id, name, description) VALUES ($organization_id, '$event_name', '$description')");
            $event_id = $conn->insert_id;

            // Insert schedule
            $conn->query("INSERT INTO schedule (schedule_id, date, time_start, time_end, organization_id) VALUES ('$event_id', '$date', '$time_start', '$time_end', '$organization_id')");

            echo json_encode(['status' => 'success', 'event_id' => $event_id]);
        } elseif (isset($data['endpoint']) && $data['endpoint'] == 'attendees') {
            $event_id = $conn->real_escape_string($data['event_id']);
            $first_name = $conn->real_escape_string($data['first_name']);
            $last_name = $conn->real_escape_string($data['last_name']);
            $contact_no = $conn->real_escape_string($data['contact_no']);
            $course = $conn->real_escape_string($data['course']);
            $section = $conn->real_escape_string($data['section']);
            $gender = $conn->real_escape_string($data['gender']);
            $attendees_no = $conn->real_escape_string($data['attendees_no']);

            $conn->query("INSERT INTO attendees (attendees_id, first_name, last_name, contact_no, course, section, gender, attendees_no, organization_id) VALUES ('$event_id', '$first_name', '$last_name', '$contact_no', '$course', '$section', '$gender', '$attendees_no', '$event_id')");

            echo json_encode(['status' => 'success', 'attendee_id' => $conn->insert_id]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method Not Allowed']);
        break;
}

$conn->close();
?>
