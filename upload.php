<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OCR Sonuçları</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #e9ecef;
        }



        .image-container {
            position: relative;
            flex: 1;
            max-width: 100%;
            box-sizing: border-box;
            margin-top: 50px;

        }

        .image-container .header {
            position: absolute;
            top: -60px;
            left: 50%;
            transform: translateX(-50%);
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 18px;
            color: #007bff;
            font-weight: bold;
            text-align: center;
            z-index: 1;
            width: calc(100% - 20px);
        }

        .image-container img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .text-container {
            background: #f8f9fa;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            white-space: pre-wrap;
            text-align: left;
            max-width: 100%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            min-width: 300px;
            box-sizing: border-box;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .text-container h3 {
            margin-top: 0;
        }

        .text-container pre {
            margin: 0;
            font-family: 'Courier New', Courier, monospace;
            color: #333;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        @media (min-width: 768px) {
            .container {
                flex-direction: row;
                align-items: flex-start;
            }

            .image-container {
                text-align: left;
            }

            .image-container .header {
                position: absolute;
                top: -30px;
                left: 50%;
                transform: translateX(-50%);
                z-index: 1;
                width: calc(100% - 20px);
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <?php
        if (isset($_FILES['image'])) {
            $file_name = $_FILES['image']['name'];
            $file_tmp = $_FILES['image']['tmp_name'];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');

            if (in_array($file_ext, $allowed_extensions)) {
                move_uploaded_file($file_tmp, "images/" . $file_name);
                echo '<img src="images/' . $file_name . '" style="width:100%;padding-bottom:10px">' . PHP_EOL;

                $image_path = realpath("images/" . $file_name);

                $command = '"C:\\xampp\\htdocs\\tesseract-ocr-for-php-main\\Tesseract-OCR\\tesseract" "' . $image_path . '" "out"';
                $output = shell_exec($command);


                if (file_exists("out.txt") && filesize("out.txt") > 0) {
                    $myfile = fopen("out.txt", "r") or die("Unable to open file!");
                    echo "<div class='text-container'><h3>OCR Text Output:</h3>";
                    echo fread($myfile, filesize("out.txt"));
                    fclose($myfile);
                    echo "</div>";
                } else {
                    echo "<div class='text-container'><h3>OCR işlemi başarısız oldu veya çıktı boş.</h3></div>";
                }
            } else {
                echo "<div class='text-container'><h3>Invalid file type. Only jpg, jpeg, png, and gif are allowed.</h3></div>";
            }
        }
        ?>
    </div>
</body>

</html>