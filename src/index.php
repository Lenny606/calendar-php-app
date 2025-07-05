<?php
include __DIR__ . '/src/calendar.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar PHP App</title>
    <meta name="description" content="Calendar PHP App">
    <meta name="keys" content="">
    <link rel="stylesheet" href="./css/style.css">
    <script src="./js/script.js" defer></script>
</head>
<body>

<?php include "./templates/title.php" ?>

<section class="clock-container">
    <div class="clock" id="clock"></div>
</section>
<section class="calendar-container">
    <div class="nav-btn-container">
        <button class="nav-btn nav-btn-left"> <</button>
        <h2 class="subtitle" id="month-year"></h2>
        <button class="nav-btn nav-btn-right"> ></button>
    </div>

    <div id="calendar" class="calendar-grid">

    </div>
</section>

<!--    modal  -->
<div class="modal" id="eventModal">
    <div class="modal-overlay"></div>
    <div class="modal-content">
        <div class="modal-header">
            <h3>Event Details</h3>
            <button class="close-btn" type="button">&times;</button>
        </div>
        <div class="modal-body">
            <div class="selector" id="eventSelectorWrapper">
                <label for="eventSelector"><strong>Select Events</strong></label>
                <select id="eventSelector">
                    <option value="" disabled selected>Choose event ...</option>
                </select>
            </div>

            <!--     MAIN FORM -->
            <?php include "./templates/main-form.php" ?>

            <button class="cancel-btn submit-btn" type="button">Cancel</button>
        </div>
    </div>
</div>

<script>
//    events from DTB
    const events = <?php json_encode($dtbEvents, JSON_UNESCAPED_UNICODE) ?>;
</script>

</body>
</html>
