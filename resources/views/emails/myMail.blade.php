<!DOCTYPE html>
<html>
<head>
    <title>Email</title>
</head>
<body>
    <h1>{{ $details['title'] }}</h1>
    <p>{{ $details['body'] }}</p>

    <p>Thank you</p>
    <p>Regards,</p>
    <p>{{ config('app.name', 'Laravel') }}</p>
</body>
</html>
