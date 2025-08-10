<?php
// ฟังก์ชันสำหรับแปลงชื่อสถานะเป็นสีของ TailwindCSS
function getStatusBadgeClass($status) {
    switch ($status) {
        case 'receiving':
            return 'bg-gray-200 text-gray-800';
        case 'pending_director':
            return 'bg-blue-200 text-blue-800';
        case 'pending_deputy':
            return 'bg-indigo-200 text-indigo-800';
        case 'completed':
            return 'bg-green-200 text-green-800';
        case 'rejected':
            return 'bg-red-200 text-red-800';
        default:
            return 'bg-gray-200 text-gray-800';
    }
}