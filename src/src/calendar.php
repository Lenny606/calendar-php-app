<?php

include __DIR__ . "/../db/connection.php";

//Define variables
$successMessage = "";
$errorMessage = "";
$dtbEvents = [
    [
        'id' => 1,
        'title' => 'Team Meeting',
        'date' => '2025-07-05',
        'startTime' => '09:00',
        'endTime' => '10:00'
    ],
    [
        'id' => 2,
        'title' => 'Project Review',
        'date' => '2025-07-06',
        'startTime' => '14:00',
        'endTime' => '15:30'
    ],
    [
        'id' => 3,
        'title' => 'Client Call',
        'date' => '2025-07-07',
        'startTime' => '11:00',
        'endTime' => '12:00'
    ]
];


//CREATE
if ($_SERVER["REQUEST_METHOD"] === "POST" &&
    isset($_POST["form-action"]) &&
    $_POST["form-action"] === "create"
) {
    $event = trim($_POST["event-title"]);
    $date = trim($_POST["event-date"]);
    $startTime = trim($_POST["event-start-time"]);
    $endTime = trim($_POST["event-end-time"]);

    if (empty($event) || empty($date) || empty($startTime) || empty($endTime)) {
        $errorMessage = "All fields are required";
        header("Location: /" . $_SERVER["PHP_SELF"] . "/error=1");
        exit;
    }

    if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $date)) {
        $errorMessage = "Invalid date format";
        header("Location: /" . $_SERVER["PHP_SELF"] . "/error=1");
        exit;
    }

    if (!preg_match("/^([01][0-9]|2[0-3]):[0-5][0-9]$/", $startTime) ||
        !preg_match("/^([01][0-9]|2[0-3]):[0-5][0-9]$/", $endTime)) {
        $errorMessage = "Invalid time format";
        header("Location: /" . $_SERVER["PHP_SELF"] . "/error=1");
        exit;
    }

    /** @var mysqli $connection */
    $stmt = $connection->prepare("INSERT INTO events (title, date, start_time, end_time) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $event, $date, $startTime, $endTime);
    $stmt->execute();
    $stmt->close();

    header("Location: /" . $_SERVER["PHP_SELF"] . "/success=1");
    exit;

}//CREATE


if ($_SERVER["REQUEST_METHOD"] === "POST" &&
    isset($_POST["form-action"]) &&
    $_POST["form-action"] === "edit"
) {
    $eventId = $_POST["event-edit-id"];
    $event = trim($_POST["event-title"]);
    $date = trim($_POST["event-date"]);
    $startTime = trim($_POST["event-start-time"]);
    $endTime = trim($_POST["event-end-time"]);

    if (empty($eventId) || empty($event) || empty($date) || empty($startTime) || empty($endTime)) {
        $errorMessage = "All fields are required";
        header("Location: /" . $_SERVER["PHP_SELF"] . "/error=1");
        exit;
    }

    if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $date)) {
        $errorMessage = "Invalid date format";
        header("Location: /" . $_SERVER["PHP_SELF"] . "/error=1");
        exit;
    }

    if (!preg_match("/^([01][0-9]|2[0-3]):[0-5][0-9]$/", $startTime) ||
        !preg_match("/^([01][0-9]|2[0-3]):[0-5][0-9]$/", $endTime)) {
        $errorMessage = "Invalid time format";
        header("Location: /" . $_SERVER["PHP_SELF"] . "/error=1");
        exit;
    }

    /** @var mysqli $connection */
    $stmt = $connection->prepare("UPDATE events SET title = ?, date = ?, start_time = ?, end_time = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $event, $date, $startTime, $endTime, $eventId);
    $stmt->execute();
    $stmt->close();

    header("Location: /" . $_SERVER["PHP_SELF"] . "/success=2");
    exit;
}  //EDIT


if ($_SERVER["REQUEST_METHOD"] === "POST" &&
    isset($_POST["form-action"]) &&
    $_POST["form-action"] === "delete"
) {
    $eventId = $_POST["event-delete-id"];

    if (empty($eventId)) {
        $errorMessage = "Event ID is required";
        header("Location: /" . $_SERVER["PHP_SELF"] . "/error=1");
        exit;
    }

    /** @var mysqli $connection */
    $stmt = $connection->prepare("DELETE FROM events WHERE id = ?");
    $stmt->bind_param("i", $eventId);
    $stmt->execute();
    $stmt->close();

    header("Location: /" . $_SERVER["PHP_SELF"] . "/success=3");
    exit;
}  //DELETE


// Clear any previous events array
$dtbEvents = [];

// MESSAGES AFTER SUBMIT ------------------------
if ($_SERVER['GET']) {
    if (isset($_GET["success"])) {
        $successType = $_GET["success"];
        $successMessage = match ($successType) {
            "1" => "Event created successfully",
            "2" => "Event edited successfully",
            "3" => "Event deleted successfully",
        };
    }

    if (isset($_GET["error"])) {
        $errorMessage = "Error while submitting event";
    }
}

//GET DATA
/** @var mysqli $connection */
$query= $connection->query("SELECT * FROM events");
if ($query && $query->num_rows > 0) {
    while ($row = $query->fetch_assoc()) {

        $day = (new DateTime($row["date"]));
        $startTime = (new DateTime($row["start_time"]))->format('H:i');
        $endTime = (new DateTime($row["end_time"]))->format('H:i');

        while ($startTime <= $endTime) {
            $dtbEvents[] = [
                'id' => $row["id"],
                'title' => $row["title"],
                'date' => $day->format('Y-m-d'),
                'startTime' => $startTime,
                'endTime' => $endTime
            ];

            //every time add 1 day
            $day->modify('+1 day');
        }

    }
}

$connection->close();