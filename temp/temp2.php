<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3 by 3 Card View</title>
    <style>
        /* body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
            margin: 0;
        } */

        .card-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            padding: 16px;
        }

        .card {
            display: block;
            text-decoration: none;
            color: inherit;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            overflow: hidden;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .card-content {
            padding: 16px;
        }

        .card-content h2 {
            margin: 0;
            font-size: 1.5em;
        }

        .card-content p {
            color: #666;
            margin-top: 8px;
        }
    </style>
</head>

<body>
    <div class="card-container">
        <a href="../admin/temp.php?id=1" class="card">
            <img src="path_to_image1.jpg" alt="Card Image" class="card-img">
            <div class="card-content">
                <h2>Card Title 1</h2>
                <p>Some brief description about the content of the card.</p>
            </div>
        </a>
        <a href="https://example.com?id=2" class="card">
            <img src="path_to_image2.jpg" alt="Card Image" class="card-img">
            <div class="card-content">
                <h2>Card Title 2</h2>
                <p>Some brief description about the content of the card.</p>
            </div>
        </a>
        <a href="https://example.com?id=3" class="card">
            <img src="path_to_image3.jpg" alt="Card Image" class="card-img">
            <div class="card-content">
                <h2>Card Title 3</h2>
                <p>Some brief description about the content of the card.</p>
            </div>
        </a>
        <a href="https://example.com?id=4" class="card">
            <img src="path_to_image4.jpg" alt="Card Image" class="card-img">
            <div class="card-content">
                <h2>Card Title 4</h2>
                <p>Some brief description about the content of the card.</p>
            </div>
        </a>
        <a href="https://example.com?id=5" class="card">
            <img src="path_to_image5.jpg" alt="Card Image" class="card-img">
            <div class="card-content">
                <h2>Card Title 5</h2>
                <p>Some brief description about the content of the card.</p>
            </div>
        </a>
        <a href="https://example.com?id=6" class="card">
            <img src="path_to_image6.jpg" alt="Card Image" class="card-img">
            <div class="card-content">
                <h2>Card Title 6</h2>
                <p>Some brief description about the content of the card.</p>
            </div>
        </a>
        <a href="https://example.com?id=7" class="card">
            <img src="path_to_image7.jpg" alt="Card Image" class="card-img">
            <div class="card-content">
                <h2>Card Title 7</h2>
                <p>Some brief description about the content of the card.</p>
            </div>
        </a>
        <a href="https://example.com?id=8" class="card">
            <img src="path_to_image8.jpg" alt="Card Image" class="card-img">
            <div class="card-content">
                <h2>Card Title 8</h2>
                <p>Some brief description about the content of the card.</p>
            </div>
        </a>
        <a href="https://example.com?id=9" class="card">
            <img src="path_to_image9.jpg" alt="Card Image" class="card-img">
            <div class="card-content">
                <h2>Card Title 9</h2>
                <p>Some brief description about the content of the card.</p>
            </div>
        </a>
    </div>
</body>
   
  <script>

  </script>
</html>