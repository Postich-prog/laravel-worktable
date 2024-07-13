<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload CSV</title>
</head>
<body>
<h1>Upload CSV File</h1>
<form action="{{ route('csv.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="csv_file" accept=".csv, text/csv">
    <button type="submit">Upload CSV</button>
</form>
</body>
</html>
