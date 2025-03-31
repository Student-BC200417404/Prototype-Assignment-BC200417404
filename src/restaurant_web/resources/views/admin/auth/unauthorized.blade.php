<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unauthorized Access</title>
    <!-- Add your CSS here -->
</head>
<body>
    <div class="container">
        <div class="error-content">
            <h1>Unauthorized Access</h1>
            <p>You do not have permission to access the admin area.</p>
            <a href="{{ route('home') }}" class="btn">Return to Home</a>
        </div>
    </div>
</body>
</html> 