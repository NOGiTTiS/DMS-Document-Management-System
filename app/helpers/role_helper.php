<?php

// ฟังก์ชันสำหรับแปล Role ภาษาอังกฤษเป็นภาษาไทย
function translateRoleToThai($role) {
    $roleMap = [
        'admin' => 'ผู้ดูแลระบบ',
        'director' => 'ผู้อำนวยการ',
        'deputy' => 'รองผู้อำนวยการ',
        'officer' => 'เจ้าหน้าที่สารบรรณ',
        'teacher' => 'ครู/ผู้ใช้งานทั่วไป'
    ];
    return $roleMap[$role] ?? ucfirst($role);
}

// ฟังก์ชันสำหรับสร้าง Array ของ Role ทั้งหมด (สำหรับใช้ใน Dropdown)
function getAllRoles() {
    return [
        'teacher' => 'ครู',
        'officer' => 'เจ้าหน้าที่สารบรรณ',
        'deputy' => 'รองผู้อำนวยการ',
        'director' => 'ผู้อำนวยการ',
        'admin' => 'ผู้ดูแลระบบ'
    ];
}