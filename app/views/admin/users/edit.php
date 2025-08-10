<div class="bg-white p-8 rounded-lg shadow-md max-w-lg mx-auto">
    <form action="<?php echo URLROOT; ?>/admin/editUser/<?php echo $data['user']->user_id; ?>" method="post">
        <!-- Full Name -->
        <div class="mb-4">
            <label for="fullname" class="block text-gray-700 text-sm font-bold mb-2">ชื่อ-นามสกุล:</label>
            <input type="text" name="fullname" class="shadow appearance-none border rounded w-full py-2 px-3" value="<?php echo htmlspecialchars($data['user']->fullname); ?>" required>
        </div>
        <!-- Username -->
        <div class="mb-4">
            <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username:</label>
            <input type="text" name="username" class="shadow appearance-none border rounded w-full py-2 px-3" value="<?php echo htmlspecialchars($data['user']->username); ?>" required>
        </div>
        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">รหัสผ่านใหม่:</label>
            <input type="password" name="password" class="shadow appearance-none border rounded w-full py-2 px-3" placeholder="เว้นว่างไว้หากไม่ต้องการเปลี่ยน">
            <p class="text-xs text-gray-500 mt-1">กรอกรหัสผ่านเฉพาะเมื่อต้องการเปลี่ยนเท่านั้น</p>
        </div>
        <!-- Role -->
        <div class="mb-6">
            <label for="role" class="block text-gray-700 text-sm font-bold mb-2">บทบาท:</label>
            <select name="role" id="role" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <?php foreach (getAllRoles() as $role_en => $role_th): ?>
                    <option value="<?php echo $role_en; ?>" <?php echo ($data['user']->role == $role_en) ? 'selected' : ''; ?>>
                        <?php echo $role_th; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Telegram Chat ID -->
        <div class="mb-6">
            <label for="telegram_chat_id" class="block text-gray-700 text-sm font-bold mb-2">Telegram Chat ID:</label>
            <input type="text" name="telegram_chat_id" class="shadow appearance-none border rounded w-full py-2 px-3" value="<?php echo htmlspecialchars($data['user']->telegram_chat_id ?? ''); ?>" placeholder="ตัวเลข Chat ID จาก @userinfobot">
            <p class="text-xs text-gray-500 mt-1">
                ใช้สำหรับส่งการแจ้งเตือนส่วนตัว (ไม่บังคับ)
                <a href="https://t.me/userinfobot" target="_blank" class="text-blue-500 hover:underline">คลิกเพื่อหา ID</a>
            </p>
        </div>
        <!-- *** จบส่วนที่เพิ่ม *** -->

        <!-- Submit Button -->
        <div class="flex items-center justify-end">
            <a href="<?php echo URLROOT; ?>/admin" class="text-gray-600 hover:text-gray-800 mr-4">ยกเลิก</a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                บันทึกการเปลี่ยนแปลง
            </button>
        </div>
    </form>
</div>