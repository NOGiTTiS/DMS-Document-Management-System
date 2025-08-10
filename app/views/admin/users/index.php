<div class="bg-white p-6 rounded-lg shadow-md">
    <!-- Header & Add User Button -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-4">
        <h3 class="text-xl font-bold text-gray-700 mb-2 md:mb-0">รายชื่อผู้ใช้งานในระบบ</h3>
        <a href="<?php echo URLROOT; ?>/admin/addUser" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-user-plus mr-2"></i> เพิ่มผู้ใช้ใหม่
        </a>
    </div>

    <!-- Users Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="w-1/4 text-left py-3 px-4 uppercase font-semibold text-sm">ชื่อ-นามสกุล</th>
                    <th class="w-1/4 text-left py-3 px-4 uppercase font-semibold text-sm">Username</th>
                    <th class="w-1/4 text-left py-3 px-4 uppercase font-semibold text-sm">Telegram ID</th>
                    <th class="w-1/4 text-left py-3 px-4 uppercase font-semibold text-sm">บทบาท</th>
                    <th class="text-center py-3 px-4 uppercase font-semibold text-sm">ดำเนินการ</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                <?php foreach($data['users'] as $user): ?>
                    <tr class="border-b hover:bg-gray-100">
                        <td class="py-3 px-4"><?php echo htmlspecialchars($user->fullname); ?></td>
                        <!-- แก้ไขบรรทัดนี้ -->
                        <td class="py-3 px-4"><?php echo htmlspecialchars($user->username); ?></td>
                        <td class="py-3 px-4"><?php echo htmlspecialchars($user->telegram_chat_id ?? '-'); ?></td>
                        <td class="py-3 px-4"><?php echo ucfirst(htmlspecialchars($user->role)); ?></td>
                        <td class="text-center py-3 px-4">
                            <!-- เพิ่ม class ของ flexbox ที่นี่ -->
                            <div class="flex items-center justify-center space-x-4">
                                <!-- ปุ่มแก้ไข -->
                                <a href="<?php echo URLROOT; ?>/admin/editUser/<?php echo $user->user_id; ?>" class="text-blue-500 hover:text-blue-700" title="แก้ไข">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <!-- ปุ่มลบ (ฟอร์ม) -->
                                <?php if($user->user_id != $_SESSION['user_id']): ?>
                                    <form action="<?php echo URLROOT; ?>/admin/deleteUser/<?php echo $user->user_id; ?>" method="post" onsubmit="return confirm('คุณแน่ใจหรือไม่ที่จะลบผู้ใช้นี้?');">
                                        <button type="submit" class="text-red-500 hover:text-red-700 bg-transparent border-none cursor-pointer p-0" title="ลบ">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>