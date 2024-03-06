window.onload = function() {
    var today = new Date();
    var currentMonth = today.getMonth();
    var currentYear = today.getFullYear();
    var firstDay = new Date(currentYear, currentMonth, 1);
    var daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

    var calendarHeader = document.getElementById('calendar-header');
    calendarHeader.innerHTML = currentYear + ' ' + today.toLocaleString('default', { month: 'long' });

    var calendar = document.getElementById('calendar');
    calendar.innerHTML = '';


        for (let i = 0; i < firstDay.getDay(); i++) {
            var cell = document.createElement('div');
            cell.classList.add('calendar-day');
            calendar.appendChild(cell);
        }

        for (let i = 1; i <= daysInMonth; i++) {
            var cell = document.createElement('div');
            cell.classList.add('calendar-day');
            cell.innerText = i;
            if (i === today.getDate() && currentMonth === today.getMonth() && currentYear === today.getFullYear()) {
                cell.classList.add('current-day'); 
            }
            calendar.appendChild(cell);
        }

        var clearDiv = document.createElement('div');
        clearDiv.classList.add('clear');
        calendar.appendChild(clearDiv);
    }


    function confirmDelete() {
        return confirm("Are you sure you want to delete this venue?");
    }


    function toggleSection(tableId) {
        var formsContainer = document.getElementById(tableId + '-forms');
        if (formsContainer.style.display === "block") {
            formsContainer.style.display = "none";
        } else {
            formsContainer.style.display = "block";
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        var hiddenUsername = document.getElementById('hiddenUsername').textContent;
        var typedUsername = document.getElementById('typedUsername');
        var i = 0;

        function typeCharacter() {
            if (i < hiddenUsername.length) {
                typedUsername.textContent += hiddenUsername.charAt(i);
                i++;
                setTimeout(typeCharacter, 100); 
            }
        }

        typeCharacter();
    });

function updateDateTime() {
    var now = new Date();
    var dateTimeString = now.toLocaleDateString() + " " + now.toLocaleTimeString();
    var dateTimeElement = document.getElementById('datetime');

    if (dateTimeElement) {
        dateTimeElement.innerText = dateTimeString;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    setInterval(updateDateTime, 1000);
    updateDateTime(); 
});

document.addEventListener('DOMContentLoaded', function() {
    const eventDays = document.querySelectorAll('.event-day');

    eventDays.forEach(function(day) {
        day.addEventListener('mouseenter', function() {
            const eventDate = day.getAttribute('rel');
            alert('Event on ' + eventDate); 
        });
    });
});


