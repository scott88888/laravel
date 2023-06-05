<!DOCTYPE html>
<html>
<head>
    <title>上傳ftp</title>
</head>
<body>
    <h1>上傳ftp</h1>

    <form method="POST"  action = "{{ asset('fileupload') }}" enctype="multipart/form-data">
    @csrf
        <input type="file" name="file" required>
        <button type="submit">上傳ftp</button>
    </form>

</body>