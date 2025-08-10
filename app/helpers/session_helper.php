<?php
// Flash message helper for SweetAlert2
// EXAMPLE - flash('register_success', 'You are now registered', 'success');
// DISPLAY IN VIEW - flash('register_success');
function flash($name = ''){
    if(isset($_SESSION[$name])){
        $alert_config = $_SESSION[$name];
        // สร้าง JavaScript เพื่อเรียก SweetAlert2
        echo "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    position: 'top-end',
                    icon: '{$alert_config['icon']}',
                    title: '{$alert_config['message']}',
                    showConfirmButton: false,
                    timer: 3000,
                    toast: true
                });
            });
        </script>
        ";
        // ล้าง Session ทิ้งหลังสร้าง script
        unset($_SESSION[$name]);
    }
}

// ฟังก์ชันสำหรับสร้าง Session ข้อความ (ใช้ใน Controller)
function set_flash_message($name, $message, $icon = 'success') {
    $_SESSION[$name] = [
        'message' => $message,
        'icon' => $icon // success, error, warning, info, question
    ];
}