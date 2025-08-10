<?php require APPROOT . '/app/views/inc/header.php'; ?>

<div class="relative min-h-screen md:flex">
    
    <?php require APPROOT . '/app/views/inc/sidebar.php'; ?>

    <main class="flex-1 md:ml-64">
        <header class="bg-white shadow-md p-4 flex justify-between items-center">
            <button id="open-sidebar-btn" class="md:hidden text-gray-600 hover:text-gray-900">
                <i class="fa-solid fa-bars text-2xl"></i>
            </button>
            <h2 class="text-2xl font-bold text-gray-700 hidden md:block"><?php echo $data['title'] ?? 'DMS System'; ?></h2>
            <div class="text-gray-600">
                <i class="fa-solid fa-calendar-days mr-2"></i>
                <span><?php echo date('d F Y'); ?></span>
            </div>
        </header>

        <div class="p-6">
            <?php flash('doc_message'); // เรียกใช้ Flash Message ที่นี่ที่เดียว ?>
            <?php require_once $view_path; ?>
        </div>
    </main>

    <div id="sidebar-overlay" class="fixed inset-0 bg-black opacity-50 hidden z-20"></div>

</div>

<?php require APPROOT . '/app/views/inc/footer.php'; ?>