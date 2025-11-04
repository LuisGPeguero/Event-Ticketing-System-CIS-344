# Event-Ticketing-System-CIS-344

## Events
`GET /api/api_events.php`
No body needed

## Users
`POST /api/api_users.php?action=register`
<br/>
`{
  "username": "username",
  "email": "user@example.com",
  "password": "password"
}`
<br/>
`POST /api/api_users.php?action=login`
<br/>
`{
  "username": "susername",
  "password": "password"
}`
<br/>
## Bookings
`GET /api/api_bookings.php?user_id={id}`
<br/>
No body needed
<br/>
`POST /api/api_bookings.php`
<br/>
`{
  "user_id": 1,
  "event_id": 2,
  "quantity": 3
}`
<br/>
