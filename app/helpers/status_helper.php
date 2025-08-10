<?php
// ฟังก์ชันสำหรับแปลงชื่อสถานะเป็นสีของ TailwindCSS (ของเดิม)
function getStatusBadgeClass($status) {
    switch ($status) {
        case 'receiving':
            return 'bg-gray-200 text-gray-800';
        case 'pending_director':
            return 'bg-blue-200 text-blue-800';
        case 'pending_deputy':
            return 'bg-indigo-200 text-indigo-800';
        case 'pending_officer':
            return 'bg-purple-200 text-purple-800'; // เพิ่มสีสำหรับ officer
        case 'pending_teacher':
            return 'bg-teal-200 text-teal-800'; // เพิ่มสีสำหรับ teacher
        case 'completed':
            return 'bg-green-200 text-green-800';
        case 'rejected':
            return 'bg-red-200 text-red-800';
        default:
            return 'bg-gray-200 text-gray-800';
    }
}

// *** ฟังก์ชันใหม่สำหรับแปลสถานะเป็นภาษาไทย ***
function translateStatusToThai($status) {
    $statusMap = [
        'receiving' => 'รอเสนอเรื่อง',
        'pending_director' => 'รอ ผอ. พิจารณา',
        'pending_deputy' => 'รอ รองฯ พิจารณา',
        'pending_officer' => 'รอเจ้าหน้าที่ดำเนินการ',
        'pending_teacher' => 'รอครูรับทราบ/ดำเนินการ',
        'completed' => 'เสร็จสมบูรณ์',
        'rejected' => 'ตีกลับ/แก้ไข'
    ];

    // คืนค่าภาษาไทยถ้าเจอใน Array, ถ้าไม่เจอให้คืนค่าเดิมกลับไป
    return $statusMap[$status] ?? ucfirst($status);
}