<!DOCTYPE html>
<html lang="en">
<head>
    <title>Invitation to Restaurant</title>
</head>
<body>
<h1>{{ $details['title'] ?? "No Title" }}</h1>
<p>{{ $details['number_peoples']?? "No data"  }}</p>
<p>{{ $details['booking_time']?? "No booking time"  }}</p>
</body>
</html>
