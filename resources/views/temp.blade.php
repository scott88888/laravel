<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/dropzone@5.9.2/dist/dropzone.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dropzone@5.9.2/dist/dropzone.js"></script>
</head>

<body>
    <div id="app">
        <form action="{{ route('file.upload') }}" class="dropzone" id="myDropzone" enctype="multipart/form-data">
            @csrf
            <div class="fallback">
                <input type="file" name="file" id="fileInput">
            </div>
        </form>
    </div>
    <script>
        new Vue({
            el: '#app',
            mounted() {
                Dropzone.options.myDropzone = {
                    paramName: "file",
                    maxFiles: 1, // 只允許上傳一個檔案
                    maxFilesize: 10000,
                    acceptedFiles: '.zip', // 只接受 .zip 檔案
                    init: function() {
                        this.on("success", function(file, response) {
                            console.log(response);
                        });
                        this.on("error", function(file, response) {
                            console.log(response);
                        });
                    }
                };
            }
        });
    </script>
</body>

</html>
