// Show all events
async function showEvents() {
  const res = await fetch('/api/api_events.php');
  const data = await res.json();
  const list = document.getElementById('eventList');
  list.innerHTML = '';
  data.forEach(e => {
    const item = document.createElement('li');
    item.textContent = `${e.name} - ${e.event_date} - $${e.price}`;
    list.appendChild(item);
  });
}
// Sign up
async function signup() {
  const username = document.getElementById('regUser').value;
  const email = document.getElementById('regEmail').value;
  const password = document.getElementById('regPass').value;

  const res = await fetch('/api/api_users.php?action=register', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ username, email, password })
  });
  const data = await res.json();
  if (data.success) {
    alert(data.message || 'Signed up!');
  } else {
    alert(data.error || 'Sign up failed.');
  }
}
// Log in
async function login() {
  const username = document.getElementById('logUser').value;
  const password = document.getElementById('logPass').value;

  const res = await fetch('/api/api_users.php?action=login', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ username, password })
  });
  const data = await res.json();
  if (data.success) {
    localStorage.setItem('userId', data.user.id);
    alert('Login success!');
  } else {
    alert('Login failed');
  }
}
// Book an event
async function bookEvent() {
  const userId = localStorage.getItem('userId');
  const eventId = document.getElementById('eventId').value;
  const qty = document.getElementById('qty').value;
  if (!userId) {
    alert('Log in first!');
    return;
  }
  const quantity = parseInt(qty, 10); 
  if (isNaN(quantity) || quantity <= 0) {
    alert('Please enter a valid quantity (1 or more).');
    return;
  }
  const res = await fetch('/api/api_bookings.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ user_id: parseInt(userId, 10), event_id: parseInt(eventId, 10), quantity: quantity })
  });
  const data = await res.json();
if (data.success) {
    alert(data.message || 'Booked!');
  } else {
    alert(data.error || 'Booking failed.');
  }
}
// Run when page loads
document.addEventListener('DOMContentLoaded', showEvents);
