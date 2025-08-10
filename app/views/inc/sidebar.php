<aside id="sidebar" class="w-64 min-h-screen bg-gray-800 text-gray-200 flex flex-col fixed inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition-transform duration-200 ease-in-out z-30">
    
    <div class="h-16 flex items-center justify-between px-4 bg-gray-900 shadow-md">
        <div class="flex items-center">
            <i class="fa-solid fa-book-open text-pink-500 text-2xl mr-3"></i>
            <h1 class="text-lg font-bold">DMS System</h1>
        </div>
        <button id="close-sidebar-btn" class="md:hidden text-gray-400 hover:text-white">
            <i class="fa-solid fa-times text-2xl"></i>
        </button>
    </div>

    <nav class="flex-1 px-4 py-4 space-y-2">
        <a href="<?php echo URLROOT; ?>/dashboard" class="flex items-center px-4 py-2 rounded-lg bg-pink-600 text-white">
            <i class="fa-solid fa-tachometer-alt fa-fw mr-3"></i>
            <span>ภาพรวมระบบ</span>
        </a>

        <a href="<?php echo URLROOT; ?>/documents/pending" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors duration-200">
            <i class="fa-solid fa-hourglass-half fa-fw mr-3"></i>
            <span>เอกสารรอพิจารณา</span>
        </a>

        <p class="px-4 pt-4 pb-2 text-xs text-gray-400 uppercase">เมนูหลัก</p>
        
        <!-- ... เมนูลงรับ ... -->
        <a href="<?php echo URLROOT; ?>/documents/create" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors duration-200">
            <i class="fa-solid fa-plus-circle fa-fw mr-3"></i>
            <span>ลงรับหนังสือใหม่</span>
        </a>
        <!-- *** เพิ่มเมนูใหม่นี้ *** -->
        <a href="<?php echo URLROOT; ?>/documents" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors duration-200">
            <i class="fa-solid fa-inbox fa-fw mr-3"></i>
            <span>รายการหนังสือเข้า</span>
        </a>
         <a href="#" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors duration-200">
            <i class="fa-solid fa-arrow-up-from-bracket fa-fw mr-3"></i>
            <span>หนังสือภายนอก (ส่ง)</span>
        </a>
         <a href="#" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors duration-200">
            <i class="fa-solid fa-file-lines fa-fw mr-3"></i>
            <span>หนังสือภายใน</span>
        </a>

        <?php if($_SESSION['user_role'] == 'admin'): ?>
        <p class="px-4 pt-4 pb-2 text-xs text-gray-400 uppercase">ตั้งค่าระบบ</p>
        <!-- แก้ไข href -->
        <a href="<?php echo URLROOT; ?>/admin" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors duration-200">
            <i class="fa-solid fa-users-cog fa-fw mr-3"></i>
            <span>จัดการผู้ใช้งาน</span>
        </a>
        <a href="<?php echo URLROOT; ?>/admin/settings" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors duration-200">
            <i class="fa-solid fa-cog fa-fw mr-3"></i>
            <span>ตั้งค่าระบบ</span>
        </a>
        <?php endif; ?>
    </nav>
    
    <div class="px-4 py-4 border-t border-gray-700">
        <div class="flex items-center">
            <i class="fa-solid fa-user-circle text-3xl text-pink-500"></i>
            <div class="ml-3">
                <p class="text-sm font-semibold"><?php echo $_SESSION['user_fullname']; ?></p>
                <p class="text-xs text-gray-400">บทบาท: <?php echo ucfirst($_SESSION['user_role']); ?></p>
            </div>
        </div>
        <a href="<?php echo URLROOT; ?>/users/logout" class="mt-4 w-full flex items-center justify-center bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg">
            <i class="fa-solid fa-right-from-bracket mr-2"></i>
            <span>ออกจากระบบ</span>
        </a>
    </div>
</aside>