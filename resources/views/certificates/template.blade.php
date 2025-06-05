<!DOCTYPE html>
<html>
<head>
    <style>
        body { text-align: center; font-family: sans-serif; }
        .certificate { border: 10px solid #ccc; padding: 30px; }
        h1 { font-size: 50px; margin-bottom: 0; }
        h2 { margin-top: 0; }
    </style>
</head>
<body>
<div class="certificate">
    <h1>Certificate of Completion</h1>
    <h2>This certifies that</h2>
    <h1>{{ $name }}</h1>
    <p>has successfully completed the course</p>
    <h2>{{ $course }}</h2>
    <p>Date: {{ $date }}</p>
</div>
</body>
</html>
