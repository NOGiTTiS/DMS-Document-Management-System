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

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Prompt', sans-serif;
        }
        /* สไตล์สำหรับ Glassmorphism */
        .glass-effect {
            background: rgba(255, 255, 255, 0.2); /* สีขาวโปร่งแสง */
            backdrop-filter: blur(10px); /* เอฟเฟกต์เบลอพื้นหลัง */
            -webkit-backdrop-filter: blur(10px); /* สำหรับ Safari */
            border-radius: 1rem; /* ทำให้ขอบมน */
            border: 1px solid rgba(255, 255, 255, 0.3); /* เส้นขอบบางๆ */
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1); /* เงาเล็กน้อย */
        }
    </style>
</head>
<body class="bg-gray-200">