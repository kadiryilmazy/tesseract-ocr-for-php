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

        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 1200px;
            width: 100%;
            margin: 20px;
            gap: 20px;
            box-sizing: border-box;
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
        header('Content-Type: text/html; charset=utf-8');

        if (isset($_FILES['image'])) {
            $file_name = $_FILES['image']['name'];
            $file_tmp = $_FILES['image']['tmp_name'];

            move_uploaded_file($file_tmp, "images/" . $file_name);

            $command = '"C:\\xampp\\htdocs\\teseract-ocr-for-php\\Tesseract-OCR\\tesseract" "C:\\xampp\\htdocs\\teseract-ocr-for-php\\images\\' . $file_name . '" out';
            shell_exec($command);

            $output_file = "out.txt";
            $content = '';

            if (file_exists($output_file)) {
                $content = file_get_contents($output_file);
                $content = mb_convert_encoding($content, 'UTF-8', 'auto');
            } else {
                $content = "Çevirme İşlemi Başarısız!";
            }

            echo '<div class="image-container">';
            echo '<img src="images/' . $file_name . '" alt="Uploaded Image">';
            echo '</div>';
            echo '<div class="text-container">';
            echo '<h3>OCR Sonuçları</h3>';
            echo '<pre>' . htmlspecialchars($content) . '</pre>';
            echo '</div>';
        }
        ?>
    </div>
</body>

</html>