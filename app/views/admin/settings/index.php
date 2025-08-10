<div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
    <h3 class="text-2xl font-bold text-gray-800 mb-6">ตั้งค่าระบบ</h3>
    
    <form action="<?php echo URLROOT; ?>/admin/settings" method="post">
        <!-- Telegram Settings -->
        <div class="mb-6 p-4 border rounded-lg">
            <h4 class="text-lg font-semibold text-gray-700 mb-2 flex items-center">
                <i class="fab fa-telegram-plane mr-2 text-blue-500"></i>
                ตั้งค่าการแจ้งเตือน Telegram
            </h4>
            <div class="mb-4">
                <label for="telegram_bot_token" class="block text-gray-700 text-sm font-bold mb-2">Bot API Token:</label>
                <input type="text" name="settings[telegram_bot_token]" id="telegram_bot_token" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?php echo htmlspecialchars($data['settings']['telegram_bot_token'] ?? ''); ?>" placeholder="วาง Token ที่ได้จาก BotFather ที่นี่">
                <p class="text-xs text-gray-500 mt-1">การเปลี่ยนแปลงค่านี้อาจทำให้การแจ้งเตือนหยุดทำงานชั่วคราว</p>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-end">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline">
                <i class="fas fa-save mr-2"></i> บันทึกการตั้งค่า
            </button>
        </div>
    </form>
</div>