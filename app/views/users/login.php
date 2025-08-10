<?php require APPROOT . '/app/views/inc/header.php'; ?>

<div class="flex items-center justify-center min-h-screen bg-gradient-to-br from-pink-500 to-gray-900">
    <div class="w-full max-w-md p-8 space-y-8 glass-effect">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-white">
                เข้าสู่ระบบ
            </h2>
            <p class="mt-2 text-center text-sm text-gray-200">
                ระบบสารบรรณอิเล็กทรอนิกส์ (DMS)
            </p>
        </div>
        <form class="mt-8 space-y-6" action="<?php echo URLROOT; ?>/users/login" method="POST">
            <input type="hidden" name="remember" value="true">
            <div class="rounded-md shadow-sm">
                <div class="relative mb-2">
                     <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="fa-solid fa-user text-gray-400"></i>
                    </div>
                    <input id="username" name="username" type="text" autocomplete="username" required 
                           class="relative block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 pl-10 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-pink-500 focus:outline-none focus:ring-pink-500 sm:text-sm" 
                           placeholder="ชื่อผู้ใช้">
                </div>
                 <div class="relative">
                     <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="fa-solid fa-lock text-gray-400"></i>
                    </div>
                    <input id="password" name="password" type="password" autocomplete="current-password" required 
                           class="relative block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 pl-10 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-pink-500 focus:outline-none focus:ring-pink-500 sm:text-sm" 
                           placeholder="รหัสผ่าน">
                </div>
            </div>

            <!-- แสดงข้อความ Error หากมี -->
            <?php if(!empty($data['username_err']) || !empty($data['password_err'])): ?>
                <div class="p-3 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-md">
                    <p><?php echo !empty($data['username_err']) ? $data['username_err'] : $data['password_err']; ?></p>
                </div>
            <?php endif; ?>

            <div>
                <button type="submit" 
                        class="group relative flex w-full justify-center rounded-md border border-transparent bg-pink-600 py-2 px-4 text-sm font-medium text-white hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="fa-solid fa-right-to-bracket text-pink-500 group-hover:text-pink-400"></i>
                    </span>
                    ลงชื่อเข้าใช้
                </button>
            </div>
        </form>
    </div>
</div>

<?php require APPROOT . '/app/views/inc/footer.php'; ?>