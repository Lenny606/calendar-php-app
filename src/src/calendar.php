<?php

include __DIR__ . "/../db/connection.php";

$successMessage = "";
$errorMessage = "";
$dtbEvents = [];


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
        header("Location: /" . $_SERVER["PHP_SELF"] . "/error=true");
        exit;;
    }

    if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $date)) {
        $errorMessage = "Invalid date format";
        header("Location: /" . $_SERVER["PHP_SELF"] . "/error=true");
        exit;
    }

    if (!preg_match("/^([01][0-9]|2[0-3]):[0-5][0-9]$/", $startTime) ||
        !preg_match("/^([01][0-9]|2[0-3]):[0-5][0-9]$/", $endTime)) {
        $errorMessage = "Invalid time format";
        header("Location: /" . $_SERVER["PHP_SELF"] . "/error=true");
        exit;
    }

    /** @var mysqli $connection */
    $stmt = $connection->prepare("INSERT INTO events (title, date, start_time, end_time) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $event, $date, $startTime, $endTime);
    $stmt->execute();
    $stmt->close();

    header("Location: /" . $_SERVER["PHP_SELF"] . "/success=true");
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

    if (empty($eventId) ||empty($event) || empty($date) || empty($startTime) || empty($endTime)) {
        $errorMessage = "All fields are required";
        header("Location: /" . $_SERVER["PHP_SELF"] . "/error=true");
        exit;;
    }

    if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $date)) {
        $errorMessage = "Invalid date format";
        header("Location: /" . $_SERVER["PHP_SELF"] . "/error=true");
        exit;
    }

    if (!preg_match("/^([01][0-9]|2[0-3]):[0-5][0-9]$/", $startTime) ||
        !preg_match("/^([01][0-9]|2[0-3]):[0-5][0-9]$/", $endTime)) {
        $errorMessage = "Invalid time format";
        header("Location: /" . $_SERVER["PHP_SELF"] . "/error=true");
        exit;
    }

    /** @var mysqli $connection */
    $stmt = $connection->prepare("UPDATE events SET title = ?, date = ?, start_time = ?, end_time = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $event, $date, $startTime, $endTime, $eventId);
    $stmt->execute();
    $stmt->close();

    header("Location: /" . $_SERVER["PHP_SELF"] . "/success=true");
    exit;
}  //EDIT


if ($_SERVER["REQUEST_METHOD"] === "POST" &&
    isset($_POST["form-action"]) &&
    $_POST["form-action"] === "delete"
) {
    $eventId = $_POST["event-delete-id"];

    if (empty($eventId)) {
        $errorMessage = "Event ID is required";
        header("Location: /" . $_SERVER["PHP_SELF"] . "/error=true");
        exit;
    }

    /** @var mysqli $connection */
    $stmt = $connection->prepare("DELETE FROM events WHERE id = ?");
    $stmt->bind_param("i", $eventId);
    $stmt->execute();
    $stmt->close();

    header("Location: /" . $_SERVER["PHP_SELF"] . "/success=true");
    exit;
}  //DELETE
