<div class="bg-white p-8 rounded-lg shadow-md">
    <form action="<?php echo URLROOT; ?>/documents/create" method="post" enctype="multipart/form-data">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- ที่ -->
            <div class="mb-4">
                <label for="doc_number" class="block text-gray-700 text-sm font-bold mb-2">ที่:</label>
                <input type="text" id="doc_number" name="doc_number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <!-- ลงวันที่ -->
            <div class="mb-4">
                <label for="doc_date" class="block text-gray-700 text-sm font-bold mb-2">ลงวันที่:</label>
                <input type="date" id="doc_date" name="doc_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
        </div>

                    <!-- จาก -->
                    <div class="mb-4">
                        <label for="doc_from" class="block text-gray-700 text-sm font-bold mb-2">จาก:</label>
                        <input type="text" id="doc_from" name="doc_from" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                    
                    <!-- เรื่อง -->
                    <div class="mb-4">
                        <label for="doc_subject" class="block text-gray-700 text-sm font-bold mb-2">เรื่อง:</label>
                        <textarea id="doc_subject" name="doc_subject" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
                    </div>

                    <!-- ไฟล์แนบ -->
                    <div class="mb-6">
                        <label for="doc_file" class="block text-gray-700 text-sm font-bold mb-2">ไฟล์เอกสาร (PDF เท่านั้น):</label>
                        <input type="file" id="doc_file" name="doc_file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" accept=".pdf" required>
                    </div>

                    <!-- ปุ่ม Submit -->
        <div class="flex items-center justify-end">
            <button type="submit" class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline">
                <i class="fa-solid fa-save mr-2"></i> บันทึกข้อมูล
            </button>
        </div>
    </form>
</div>