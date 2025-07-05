//define
const calendarElement = document.getElementById('calendar');
const monthYearElement = document.getElementById('month-year');
const modalElement = document.getElementById('modal');
const currentDate = new Date();
const weekDays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

function renderCalendar(date = new Date()) {
    calendarElement.innerHTML = '';

    const year = date.getFullYear();
    const month = date.getMonth();
    const today = currentDate

    const totalDays = new Date(year, month + 1, 0).getDate();
    const firstDay = new Date(year, month, 1).getDay();

    monthYearElement.textContent = date.toLocaleString('default', {month: 'long', year: 'numeric'});
    monthYearElement.textContent = date.toLocaleString('default', {month: 'long', year: 'numeric'});

    weekDays.forEach(day => {
        const dayElement = document.createElement('div');
        dayElement.className = "day-name";
        dayElement.textContent = day;
        calendarElement.appendChild(dayElement);
    })

    for (let i = 0; i < firstDay; i++) {
        calendarElement.appendChild(document.createElement('div'));
    }

    for (let day = 1; day <= totalDays; day++) {
        const dayString = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, "0")}`;

        const dayCell = document.createElement('div')
        dayCell.className = "day";

        if (today.getDate() === day && today.getMonth() === month && today.getFullYear() === year) {
            dayCell.classList.add('today');
        }

        const dateElement = document.createElement('div')
        dateElement.className = "day-number";
        dateElement.textContent = String(day);
        dayCell.appendChild(dateElement);

        const eventToday = events.filter(e => e.date === dayString)
        const eventBox = document.createElement('div');
        eventBox.className = "events"

        eventToday.forEach(e => {
            const event = document.createElement('div');
            event.className = "event";

            const eventTitle = document.createElement('div');
            eventTitle.className = "event-title";
            eventTitle.textContent = e.title;

            const evenTime = document.createElement('div');
            evenTime.className = "event-time";
            evenTime.textContent = e.startTime + "-" + e.endTime;

            event.appendChild(eventTitle);
            event.appendChild(evenTime);

            eventBox.appendChild(event);
        })


        //overlay
        const overlay = document.createElement('div');
        overlay.className = "day-overlay";

        const addButton = document.createElement('button');
        addButton.className = "btn-overlay";
        addButton.textContent = "Add Event";

        addButton.onclick = (e) => {
            e.stopPropagation();
            openModalCreate(dayString)
        };

        overlay.appendChild(addButton);

        if (eventToday.length > 0) {
            const editButton = document.createElement('button');
            editButton.className = "btn-overlay";
            editButton.textContent = "Edit Event";

            editButton.onclick = (e) => {
                e.stopPropagation();
                openModalEdit(eventToday)
            }

            // Iterate through each event in eventToday and create/append an element
            eventToday.forEach(event => {
                const eventElement = document.createElement('div'); // Or whatever element type is appropriate
                eventElement.textContent = event.title; // Assuming event has a title property
                overlay.appendChild(eventElement);
            });
        }

        dayCell.appendChild(overlay);
        dayCell.appendChild(eventBox);
        calendarElement.appendChild(dayCell);
    }
}

function openModalCreate(date) {
    document.getElementById("form-action").value = "add";
    document.getElementById("event-create-id").value = "";
    document.getElementById("event-edit-id").value = "";
    document.getElementById("event-delete-id-id").value = "";
    document.getElementById("event-title").value = "";
    document.getElementById("event-date").value = date;
    document.getElementById("event-start-time").value = "09:00";
    document.getElementById("event-end-time").value = "10:00";

    const selector = document.getElementById("eventSelector");
    const selectorWrapper = document.getElementById("eventSelectorWrapper");

    if (selector && selectorWrapper) {
        selector.innerHTML = "";
        selectorWrapper.style.display = "none";
    }

    modalElement.style.display = "flex";
}

function openModalEdit(events) {
    document.getElementById("form-action").value = "edit";
    modalElement.style.display = "flex";

    const selector = document.getElementById("eventSelector");
    const selectorWrapper = document.getElementById("eventSelectorWrapper");

    selector.innerHTML = "<option value='' disabled>Select Event</option>";
    events.forEach(e => {
        selector.innerHTML += `<option value='${e.id}'>${e.title}</option>`;
    })
    if (events.length > 0) {
        selectorWrapper.style.display = "block";
    } else {
        selectorWrapper.style.display = "none";
    }

    handleEventSelection(JSON.stringify(events[0]))

}

function handleEventSelection(eventJson) {
    const event = JSON.parse(eventJson);

    document.getElementById("event-edit-id").value = event.id || "";
    document.getElementById("event-delete-id").value = event.id || "";
    document.getElementById("event-title").value = event.title || "";
    document.getElementById("event-date").value = event.date || "";
    document.getElementById("event-start-time").value = event.startTime || "";
    document.getElementById("event-end-time").value = event.endTime || "";
}

function closeModal() {
    modalElement.style.display = "none";
}

//MONTH NAVIGATION
function changeMonth(offset) {
    currentDate.setMonth(currentDate.getMonth() + offset);
    renderCalendar(currentDate);
}

function clock() {
    const now = new Date();
    const clock = document.getElementById("clock");
    clock.textContent = [
        now.getHours().toString().padStart(2, "0"),
        now.getMinutes().toString().padStart(2, "0"),
        now.getSeconds().toString().padStart(2, "0")
    ].join(":")
}

//INITIALIZE APP
clock();
setInterval(clock, 1000);
renderCalendar(currentDate)