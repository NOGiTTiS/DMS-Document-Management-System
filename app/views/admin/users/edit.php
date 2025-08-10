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
            <select name="role" class="shadow appearance-none border rounded w-full py-2 px-3">
                <option value="teacher" <?php echo ($data['user']->role == 'teacher') ? 'selected' : ''; ?>>Teacher</option>
                <option value="officer" <?php echo ($data['user']->role == 'officer') ? 'selected' : ''; ?>>Officer</option>
                <option value="deputy" <?php echo ($data['user']->role == 'deputy') ? 'selected' : ''; ?>>Deputy</option>
                <option value="director" <?php echo ($data['user']->role == 'director') ? 'selected' : ''; ?>>Director</option>
                <option value="admin" <?php echo ($data['user']->role == 'admin') ? 'selected' : ''; ?>>Admin</option>
            </select>
        </div>
        <!-- Submit Button -->
        <div class="flex items-center justify-end">
            <a href="<?php echo URLROOT; ?>/admin" class="text-gray-600 hover:text-gray-800 mr-4">ยกเลิก</a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                บันทึกการเปลี่ยนแปลง
            </button>
        </div>
    </form>
</div>