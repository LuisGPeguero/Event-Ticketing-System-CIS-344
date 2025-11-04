# Event-Ticketing-System-CIS-344

## Events
GET /api/api_events.php
No body needed

## Users
`POST /api/api_users.php?action=register`
`{
  "username": "username",
  "email": "user@example.com",
  "password": "password"
}`
`POST /api/api_users.php?action=login`
`{
  "username": "susername",
  "password": "password"
}`
## Bookings
`GET /api/api_bookings.php?user_id={id}`
No body needed
`POST /api/api_bookings.php`
`{
  "user_id": 1,
  "event_id": 2,
  "quantity": 3
}`
