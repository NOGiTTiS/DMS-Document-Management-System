<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITENAME; ?></title>
    <!-- TailwindCSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts "Prompt" -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Prompt', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-10 p-5">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-3xl font-bold text-pink-600"><?php echo $data['title']; ?></h1>
            <p class="mt-4 text-gray-700"><?php echo $data['description']; ?></p>
            <p class="mt-2 text-sm text-gray-500">URL Root: <?php echo URLROOT; ?></p>
            <p class="text-sm text-gray-500">App Root: <?php echo APPROOT; ?></p>
        </div>
    </div>
</body>
</html>