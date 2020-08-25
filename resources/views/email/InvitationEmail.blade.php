<!DOCTYPE html>
<html lang="en">
<head>
    <title>Invitation to Restaurant</title>
</head>
<body>
<h1>{{ $details['title'] ?? "No Title" }}</h1>
<p>{{ $details['from']?? "No Title"  }}</p>
<p>{{ $details['to']?? "No Title"  }}</p>
<p>{{ $details['messages']?? "No Title"  }}</p>
</body>
</html>
