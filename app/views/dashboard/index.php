<!-- Welcome Message -->
<div class="p-4 mb-6 text-lg text-white bg-gradient-to-r from-pink-500 to-purple-600 rounded-lg shadow-lg">
    👋 ยินดีต้อนรับ, คุณ <?php echo $_SESSION['user_fullname']; ?>!
</div>

<!-- Stats Widgets -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Widget 1: เอกสารรอลงนาม -->
    <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-500">เอกสารรอพิจารณา</p>
            <!-- แก้ไข: แสดงค่าจาก Controller -->
            <p class="text-3xl font-bold text-yellow-500"><?php echo $data['pending_count']; ?></p>
        </div>
        <div class="bg-yellow-100 p-3 rounded-full">
            <i class="fa-solid fa-pen-to-square fa-2x text-yellow-500"></i>
        </div>
    </div>
    <!-- Widget 2: หนังสือเข้าวันนี้ -->
    <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-500">หนังสือเข้าวันนี้</p>
            <!-- แก้ไข: แสดงค่าจาก Controller -->
            <p class="text-3xl font-bold text-blue-500"><?php echo $data['stats']->today_in; ?></p>
        </div>
        <div class="bg-blue-100 p-3 rounded-full">
            <i class="fa-solid fa-pen-to-square fa-2x text-blue-500"></i>
        </div>
    </div>
    <!-- Widget 3: หนังสือส่งวันนี้ -->
    <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-500">หนังสือส่งวันนี้</p>
            <!-- แก้ไข: แสดงค่าจาก Controller -->
            <p class="text-3xl font-bold text-green-500"><?php echo $data['stats']->today_out; ?></p>
        </div>
        <div class="bg-green-100 p-3 rounded-full">
            <i class="fa-solid fa-pen-to-square fa-2x text-green-500"></i>
        </div>
    </div>
    <!-- Widget 4: เอกสารทั้งหมด -->
    <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-500">เอกสารทั้งหมด</p>
            <!-- แก้ไข: แสดงค่าจาก Controller -->
            <p class="text-3xl font-bold text-red-500"><?php echo $data['stats']->total_docs; ?></p>
        </div>
        <div class="bg-red-100 p-3 rounded-full">
            <i class="fa-solid fa-pen-to-square fa-2x text-red-500"></i>
        </div>
    </div>
</div>

<!-- Chart -->
<div class="mt-8 bg-white p-6 rounded-lg shadow-md">
    <h3 class="text-xl font-bold text-gray-700 mb-4">สถิติเอกสารรายเดือน</h3>
    <canvas id="documentChart"></canvas>
</div>