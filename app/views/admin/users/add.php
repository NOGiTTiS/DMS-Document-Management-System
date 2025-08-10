<div class="bg-white p-8 rounded-lg shadow-md max-w-lg mx-auto">
    <form action="<?php echo URLROOT; ?>/admin/addUser" method="post">
        <!-- Full Name -->
        <div class="mb-4">
            <label for="fullname" class="block text-gray-700 text-sm font-bold mb-2">ชื่อ-นามสกุล:</label>
            <input type="text" name="fullname" class="shadow appearance-none border rounded w-full py-2 px-3" required>
        </div>
        <!-- Username -->
        <div class="mb-4">
            <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username:</label>
            <input type="text" name="username" class="shadow appearance-none border rounded w-full py-2 px-3" required>
        </div>
        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">รหัสผ่าน:</label>
            <input type="password" name="password" class="shadow appearance-none border rounded w-full py-2 px-3" required>
        </div>
        <!-- Role -->
        <div class="mb-6">
            <label for="role" class="block text-gray-700 text-sm font-bold mb-2">บทบาท:</label>
            <select name="role" class="shadow appearance-none border rounded w-full py-2 px-3">
                <option value="teacher">Teacher</option>
                <option value="officer">Officer</option>
                <option value="deputy">Deputy</option>
                <option value="director">Director</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <!-- Submit Button -->
        <div class="flex items-center justify-end">
            <a href="<?php echo URLROOT; ?>/admin" class="text-gray-600 hover:text-gray-800 mr-4">ยกเลิก</a>
            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                บันทึกผู้ใช้
            </button>
        </div>
    </form>
</div>