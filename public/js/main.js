// Function สำหรับควบคุม Sidebar
function initializeSidebar() {
    console.log('initializeSidebar function is running...'); // เช็คว่าฟังก์ชันถูกเรียก

    const sidebar = document.getElementById('sidebar');
    const openBtn = document.getElementById('open-sidebar-btn');
    const closeBtn = document.getElementById('close-sidebar-btn');
    const overlay = document.getElementById('sidebar-overlay');

    // เช็คว่า JavaScript หา Element ทั้งหมดเจอรึเปล่า
    console.log({
        sidebar_element: sidebar,
        openBtn_element: openBtn,
        closeBtn_element: closeBtn,
        overlay_element: overlay
    });

    if (sidebar && openBtn && closeBtn && overlay) {
        console.log('All elements found. Adding event listeners.');

        function openSidebar() {
            console.log('Open button clicked!');
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        }

        function closeSidebar() {
            console.log('Close action triggered!');
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }

        openBtn.addEventListener('click', openSidebar);
        closeBtn.addEventListener('click', closeSidebar);
        overlay.addEventListener('click', closeSidebar);
    } else {
        console.error('CRITICAL: One or more sidebar elements were not found in the DOM.');
    }
}

// Function สำหรับสร้างกราฟ (เหมือนเดิม)
function initializeDocumentChart() {
    const chartElement = document.getElementById('documentChart');
    if (chartElement) {
        const ctx = chartElement.getContext('2d');
        const documentChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.'],
                datasets: [{
                    label: 'หนังสือเข้า',
                    data: [120, 190, 300, 500, 200, 350],
                    backgroundColor: 'rgba(59, 130, 246, 0.5)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 1
                },
                {
                    label: 'หนังสือส่ง',
                    data: [80, 150, 250, 400, 180, 300],
                    backgroundColor: 'rgba(16, 185, 129, 0.5)',
                    borderColor: 'rgba(16, 185, 129, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: { y: { beginAtZero: true } },
                responsive: true,
                plugins: { legend: { position: 'top' } }
            }
        });
    }
}

// Function สำหรับการค้นหาในตาราง
function initializeTableSearch() {
    const searchInput = document.getElementById('searchInput');
    const table = document.getElementById('documentsTable');

    if (searchInput && table) {
        searchInput.addEventListener('keyup', function() {
            const filter = searchInput.value.toUpperCase();
            const rows = table.getElementsByTagName('tr');

            // วนลูปทุกแถวของข้อมูลในตาราง (เริ่มจากแถวที่ 1 เพื่อข้าม aheader)
            for (let i = 1; i < rows.length; i++) {
                let cells = rows[i].getElementsByTagName('td');
                let found = false;
                // วนลูปทุก cell ในแถวนั้นๆ
                for (let j = 0; j < cells.length; j++) {
                    let cell = cells[j];
                    if (cell) {
                        let txtValue = cell.textContent || cell.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            found = true;
                            break; // ถ้าเจอแล้ว ไม่ต้องหาใน cell อื่นของแถวนี้
                        }
                    }
                }
                if (found) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        });
    }
}

// รอให้ DOM โหลดเสร็จสมบูรณ์แล้วค่อยรันฟังก์ชันทั้งหมด
document.addEventListener('DOMContentLoaded', (event) => {
    console.log('DOM fully loaded and parsed');
    initializeSidebar();
    initializeDocumentChart();
    initializeTableSearch();
});