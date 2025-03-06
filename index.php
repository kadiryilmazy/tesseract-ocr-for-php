<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("input[type='submit']").click(function(e) {
                if (!$('input[name="image"]').val()) {
                    e.preventDefault();
                    alert('Lütfen bir dosya yükleyin.');
                }
            });

            $(document).on("paste", function(e) {
                const items = e.originalEvent.clipboardData.items;
                for (const item of items) {
                    if (item.type.startsWith('image/')) {
                        const file = item.getAsFile();
                        const input = $('#imageUploadFile')[0];

                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        input.files = dataTransfer.files;

                        const reader = new FileReader();
                        reader.onload = function(event) {
                            $("#previewImage").attr("src", event.target.result).show();
                            $("#pasteMessage").text("Görsel başarıyla yapıştırıldı.");
                        };
                        reader.readAsDataURL(file);
                        break;
                    }
                }
            });

            $("#imageUploadFile").change(function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        $("#previewImage").attr("src", event.target.result).show();
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f9;
        }

        form {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        input[type="file"] {
            margin-bottom: 15px;
            border: 2px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        img {
            max-width: 100%;
            height: auto;
            display: none;
            margin-top: 10px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }

        #pasteMessage {
            margin-top: 10px;
            color: green;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="image" id="imageUploadFile">
        <input type="submit" value="Upload">
        <p id="pasteMessage"></p>
        <img id="previewImage" alt="Önizleme">
    </form>
</body>

</html>