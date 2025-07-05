<form action="" method="POST" class="event-form" id="event-form">
    <div class="form-group">
        <label for="event-title">Event Title:</label>
        <input type="text" id="event-title" name="event-title" required>
    </div>

    <div class="form-group">
        <label for="event-date">Date:</label>
        <input type="date" id="event-date" name="event-date" required>
    </div>

    <div class="form-group">
        <label for="event-time">Time:</label>
        <input type="time" id="event-time" name="event-time" required>
    </div>

    <div class="form-group">
        <label for="event-description">Description:</label>
        <textarea id="event-description" name="event-description" rows="4"></textarea>
    </div>

<!--     ACTIONs    -->
    <input type="hidden" id="form-action" name="form-action" value="create">
    <input type="hidden" id="event-id" name="event-id" value>

    <div class="form-group">
        <button type="submit" class="submit-btn">Create Event</button>
    </div>
</form>
