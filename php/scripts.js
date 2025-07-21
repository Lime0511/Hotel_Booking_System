// Load bookings dynamically when page loads
document.addEventListener("DOMContentLoaded", function () {
    fetchBookings();
});

// Function to fetch bookings
function fetchBookings() {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "fetch_booking.php", true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            // Insert the fetched data into the table body
            document.querySelector("#booking-history tbody").innerHTML = xhr.responseText;
        } else {
            alert("Failed to load booking history.");
        }
    };
    xhr.send();
}

// Function to delete a booking
function deleteBooking(bookingId) {
    if (confirm("Are you sure you want to delete this booking?")) {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "delete_booking.php?id=" + bookingId, true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                alert("Booking deleted!");
                fetchBookings(); // Reload the bookings after deletion
            } else {
                alert("Failed to delete booking.");
            }
        };
        xhr.send();
    }
}


// Function to load feedback dynamically via AJAX from fetch_feedback.php
function loadFeedback() {
    fetch('fetch_feedback.php') // Fetch feedback data from PHP file
        .then(response => response.json()) // Parse the JSON response
        .then(data => {
            const feedbackTable = document.getElementById('feedbackTable').getElementsByTagName('tbody')[0];
            feedbackTable.innerHTML = '';  // Clear the table before adding new data

            // Check if there is feedback data
            if (data.length > 0) {
                data.forEach(feedback => {
                    const row = feedbackTable.insertRow();
                    row.innerHTML = `
                        <td>${feedback.name}</td>
                        <td>${feedback.email}</td>
                        <td>${feedback.feedback}</td>
                        <td>${feedback.created_at}</td>
                        <td><a href="javascript:void(0);" class="btn btn-danger btn-sm" onclick="deleteFeedback(${feedback.id})">Delete</a></td>
                    `;
                });
            } else {
                feedbackTable.innerHTML = '<tr><td colspan="5">No feedback available.</td></tr>';
            }
        })
        .catch(error => {
            console.error('Error loading feedback:', error);  // Log any errors
        });
}

// Function to delete feedback by ID via AJAX
function deleteFeedback(feedbackId) {
    fetch(`delete_feedback.php?id=${feedbackId}`)
        .then(response => response.text())
        .then(data => {
            alert(data); // Show the result of deletion
            loadFeedback(); // Reload the feedback list after deletion
        })
        .catch(error => {
            console.error("Error deleting feedback:", error);
        });
}

// Load feedback when the page is loaded
document.addEventListener('DOMContentLoaded', loadFeedback);

// Function to handle section switching
function showAdminSection(sectionId) {
    // Hide all sections
    document.querySelectorAll('.admin-section').forEach(sec => sec.classList.remove('active'));

    // Show the selected section
    document.getElementById(sectionId).classList.add('active');

    // Update active link in the sidebar
    document.querySelectorAll('.admin-sidebar ul li').forEach(li => li.classList.remove('active'));
    // Highlight the active menu item
    event.target.closest('li').classList.add('active');
}

// Function to logout
function logout() {
    alert("Logging out...");
    window.location.href = "index.html"; // Redirect to your login page
}

// Ensure the 'Overview' section is active on page load
document.addEventListener('DOMContentLoaded', () => {
    showAdminSection('overview'); // Default to the 'Overview' section on page load
});

// Function to add a room
document.getElementById('addRoomForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const roomNumber = document.getElementById('room_number').value;
    const roomType = document.getElementById('room_type').value;
    const price = document.getElementById('price').value;
    const vacancyStatus = document.getElementById('vacancy_status').value;

    fetch('add_room.php', {
        method: 'POST',
        body: new URLSearchParams({
            room_number: roomNumber,
            room_type: roomType,
            price: price,
            vacancy_status: vacancyStatus
        })
    })
        .then(response => response.text())
        .then(data => {
            alert(data); // Show success or error message
            loadRooms(); // Reload the rooms list
        })
        .catch(error => console.error('Error adding room:', error));
});

// Function to delete a room
function deleteRoom(roomId) {
    fetch(`delete_room.php?id=${roomId}`)
        .then(response => response.text())
        .then(data => {
            alert(data); // Show success or error message
            loadRooms(); // Reload the rooms list
        })
        .catch(error => console.error('Error deleting room:', error));
}

// Function to load rooms dynamically via AJAX from fetch_rooms.php
function loadRooms() {
    fetch('fetch_room.php')  // Make sure the path is correct
        .then(response => response.json()) // Parse the JSON response
        .then(data => {
            const roomsTable = document.getElementById('roomsTable').getElementsByTagName('tbody')[0];
            roomsTable.innerHTML = '';  // Clear the table before adding new data

            // Check if there is room data
            if (data.length > 0) {
                data.forEach(room => {
                    const row = roomsTable.insertRow();
                    row.innerHTML = `
                        <td>${room.room_number}</td>
                        <td>${room.room_type}</td>
                        <td>RM ${room.price}</td>
                        <td>
                            <select class="form-control" onchange="updateVacancyStatus(${room.id}, this.value)">
                                <option value="Available" ${room.vacancy_status === 'Available' ? 'selected' : ''}>Available</option>
                                <option value="Occupied" ${room.vacancy_status === 'Occupied' ? 'selected' : ''}>Occupied</option>
                                <option value="Under Maintenance" ${room.vacancy_status === 'Under Maintenance' ? 'selected' : ''}>Under Maintenance</option>
                            </select>
                        </td>
                        <td>
                            <button class="btn btn-danger btn-sm" onclick="deleteRoom(${room.id})">Delete</button>
                        </td>
                    `;
                });
            } else {
                roomsTable.innerHTML = '<tr><td colspan="5">No rooms available.</td></tr>';
            }
        })
        .catch(error => {
            console.error('Error loading room data:', error);  // Log any errors
        });
}

// Function to update the room vacancy status directly from the dropdown
function updateVacancyStatus(roomId, newStatus) {
    fetch('update_vacancy.php', {
        method: 'POST',
        body: new URLSearchParams({
            id: roomId,
            vacancy_status: newStatus
        })
    })
        .then(response => response.text())
        .then(data => {
            alert(data); // Show success or error message
            loadRooms(); // Reload the rooms list after updating status
        })
        .catch(error => {
            console.error("Error updating vacancy status:", error);
        });
}

// Function to delete a room by ID via AJAX
function deleteRoom(roomId) {
    fetch(`delete_room.php?id=${roomId}`)
        .then(response => response.text())
        .then(data => {
            alert(data); // Show success or error message
            loadRooms(); // Reload the rooms list after deletion
        })
        .catch(error => {
            console.error('Error deleting room:', error);
        });
}

// Load rooms when the page is loaded
document.addEventListener('DOMContentLoaded', loadRooms);

// Function to load guests dynamically via AJAX from fetch_guests.php
function loadGuests() {
    fetch('fetch_guests.php')  // Make sure the path is correct
        .then(response => response.json()) // Parse the JSON response
        .then(data => {
            const guestsTable = document.getElementById('guestsTable').getElementsByTagName('tbody')[0];
            guestsTable.innerHTML = '';  // Clear the table before adding new data

            // Check if there are guest records
            if (data.length > 0) {
                data.forEach(guest => {
                    const row = guestsTable.insertRow();
                    row.innerHTML = `
                        <td>${guest.first_name}</td>
                        <td>${guest.last_name}</td>
                        <td>${guest.email}</td>
                        <td>${guest.phone}</td>
                        <td>${guest.check_in_date}</td>
                        <td>${guest.check_out_date}</td>
                        <td>
                            <select class="form-control" onchange="updateGuestStatus(${guest.id}, this.value)">
                                <option value="Checked In" ${guest.status === 'Checked In' ? 'selected' : ''}>Checked In</option>
                                <option value="Checked Out" ${guest.status === 'Checked Out' ? 'selected' : ''}>Checked Out</option>
                            </select>
                        </td>
                        <td>
                            <button class="btn btn-danger btn-sm" onclick="deleteGuest(${guest.id})">Delete</button>
                        </td>
                    `;
                });
            } else {
                guestsTable.innerHTML = '<tr><td colspan="8">No guests available.</td></tr>';
            }
        })
        .catch(error => {
            console.error('Error loading guest data:', error);
        });
}

// Function to update guest status via AJAX
function updateGuestStatus(guestId, newStatus) {
    fetch('update_guest_status.php', {
        method: 'POST',
        body: new URLSearchParams({
            id: guestId,
            status: newStatus
        })
    })
        .then(response => response.text())
        .then(data => {
            alert(data); // Show success or error message
            loadGuests(); // Reload the guests list after updating status
        })
        .catch(error => {
            console.error("Error updating guest status:", error);
        });
}

// Function to delete a guest by ID via AJAX
function deleteGuest(guestId) {
    fetch(`delete_guest.php?id=${guestId}`)
        .then(response => response.text())
        .then(data => {
            alert(data); // Show success or error message
            loadGuests(); // Reload the guests list after deletion
        })
        .catch(error => {
            console.error('Error deleting guest:', error);
        });
}

// Load guests when the page is loaded
document.addEventListener('DOMContentLoaded', loadGuests);

// Handle adding a new guest
document.getElementById('addGuestForm').addEventListener('submit', function (e) {
    e.preventDefault();  // Prevent the default form submission

    const firstName = document.getElementById('first_name').value;
    const lastName = document.getElementById('last_name').value;
    const email = document.getElementById('email').value;
    const phone = document.getElementById('phone').value;
    const checkInDate = document.getElementById('check_in_date').value;
    const checkOutDate = document.getElementById('check_out_date').value;

    fetch('add_guest.php', {
        method: 'POST',
        body: new URLSearchParams({
            first_name: firstName,
            last_name: lastName,
            email: email,
            phone: phone,
            check_in_date: checkInDate,
            check_out_date: checkOutDate
        })
    })
        .then(response => response.text())
        .then(data => {
            alert(data); // Show success or error message
            loadGuests(); // Reload the guests list after adding the guest
        })
        .catch(error => {
            console.error('Error adding guest:', error);
        });
});


