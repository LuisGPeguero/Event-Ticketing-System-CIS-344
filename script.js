// ----------------- Login/Register Logic -----------------
const forms = document.querySelector(".forms");
const links = document.querySelectorAll(".link");
const signinBtn = document.querySelector(".signin-btn");
const registerBtn = document.querySelector(".register-btn");
const signinUsername = document.querySelector(".signin-username");
const signinPassword = document.querySelector(".signin-password");
const registerUsername = document.querySelector(".register-username");
const registerPassword = document.querySelector(".register-password");
const registerConfirm = document.querySelector(".register-confirm");
const homePage = document.querySelector(".home-page");
const backToSignin = document.querySelector(".back-to-signin");

// Switch between Sign In and Register
links.forEach(link => {
  link.addEventListener("click", e => {
    e.preventDefault();
    forms.classList.toggle("show-register");
  });
});

// Sign In Button → go to Home Page if credentials correct
signinBtn.addEventListener("click", e => {
  e.preventDefault();
  if (signinUsername.value === "123" && signinPassword.value === "12345") {
    forms.classList.add("hidden");
    homePage.classList.remove("hidden");
  } else {
    alert("Invalid credentials. Try Username: 123 and Password: 12345");
  }
});

// Register Button → go to Home Page if credentials match
registerBtn.addEventListener("click", e => {
  e.preventDefault();
  if (
    registerUsername.value === "123" &&
    registerPassword.value === "12345" &&
    registerConfirm.value === "12345"
  ) {
    forms.classList.add("hidden");
    homePage.classList.remove("hidden");
  } else {
    alert("Enter Username: 123 and Password: 12345 to register.");
  }
});

// Back to Sign In/Register
backToSignin.addEventListener("click", () => {
  homePage.classList.add("hidden");
  forms.classList.remove("hidden");
});

// ----------------- Event Ticketing Logic -----------------
const eventsList = document.getElementById("events-list");
const bookingsSelect = document.getElementById("bookings");
let myBookings = [];

// Load all events
function loadEvents() {
  eventsList.innerHTML = "";
  events.forEach(event => {
    const card = document.createElement("div");
    card.classList.add("event-card");
    card.innerHTML = `
      <h3>${event.name}</h3>
      <p><strong>Date:</strong> ${event.date}</p>
      <p><strong>Location:</strong> ${event.location}</p>
      <div class="buttons">
        <button class="add-btn" data-id="${event.id}">Add Event</button>
        <button class="remove-btn" data-id="${event.id}">Remove Event</button>
      </div>
    `;
    eventsList.appendChild(card);
  });

  document.querySelectorAll(".add-btn").forEach(btn => {
    btn.addEventListener("click", () => addEventToBookings(btn.dataset.id));
  });

  document.querySelectorAll(".remove-btn").forEach(btn => {
    btn.addEventListener("click", () => removeEventFromBookings(btn.dataset.id));
  });
}

// Add event to My Bookings
function addEventToBookings(id) {
  const event = events.find(e => e.id == id);
  if (!myBookings.some(b => b.id == id)) {
    myBookings.push(event);
    updateBookingsDropdown();
  } else {
    alert("Event already added to My Bookings.");
  }
}

// Remove event from My Bookings
function removeEventFromBookings(id) {
  myBookings = myBookings.filter(e => e.id != id);
  updateBookingsDropdown();
}

// Update My Bookings dropdown
function updateBookingsDropdown() {
  bookingsSelect.innerHTML = '<option value="" disabled selected>-- Select an event --</option>';
  myBookings.forEach(e => {
    const opt = document.createElement("option");
    opt.textContent = e.name;
    opt.value = e.id;
    bookingsSelect.appendChild(opt);
  });
}

// Initialize
document.addEventListener("DOMContentLoaded", loadEvents);
