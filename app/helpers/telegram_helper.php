<?php
// ฟังก์ชันสำหรับส่งข้อความไปยัง Telegram
function sendTelegramMessage($botToken, $chatId, $message) {
    if (empty($chatId) || empty($botToken)) {
        return false;
    }

    // --- ส่วนที่แก้ไข ---
    // สร้าง instance ของ Database และ Setting Model เพื่อดึงค่า
    $db = new Database();
    $settingModel = new Setting(); // ต้อง include หรือ autoload Model ก่อน
    $settings = $settingModel->getAllSettings();
    $botToken = $settings['telegram_bot_token'] ?? null;
    // --- จบส่วนที่แก้ไข ---

    if (empty($botToken)) {
        return false;
    }

    // สร้าง URL สำหรับยิง API ของ Telegram
    $website = "https://api.telegram.org/bot" . $botToken;
    $url = $website . "/sendMessage?chat_id=" . $chatId . "&parse_mode=HTML&text=" . urlencode($message);

    // ใช้ cURL เพื่อส่ง HTTP Request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    // อาจจะต้องเพิ่ม 2 บรรทัดนี้สำหรับบางเซิร์ฟเวอร์
    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    
    $result = curl_exec($ch);
    
    if (curl_errno($ch)) {
        // จัดการกับ Error ที่เกิดจากการยิง cURL
        // error_log('cURL error: ' . curl_error($ch));
        curl_close($ch);
        return false;
    }
    
    curl_close($ch);
    
    // ตรวจสอบผลลัพธ์จาก Telegram
    $response = json_decode($result, true);
    return $response['ok'] ?? false;
}