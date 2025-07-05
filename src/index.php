<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar PHP App</title>
    <meta name="description" content="Calendar PHP App">
    <meta name="keys" content="">
    <link rel="stylesheet" href="./css/style.css">
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

    <!--    modal  -->
    <div class="selector modal " id="eventSelectorWrapper">
        <label for="eventSelector"><strong>Select Events</strong></label>
        <select id="eventSelector">
            <option value="" disabled selected>Choose event ...</option>
        </select>
    </div>

    <!--     MAIN FORM -->
    <?php include "./templates/main-form.php" ?>

</section>
</body>
</html>