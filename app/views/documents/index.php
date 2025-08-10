<div class="bg-white p-6 rounded-lg shadow-md">
    <!-- Header & Search -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-4">
        <h3 class="text-xl font-bold text-gray-700 mb-2 md:mb-0">รายการหนังสือทั้งหมด</h3>
        <div class="relative">
            <input type="text" id="searchInput" class="border rounded-full py-2 px-4 pl-10" placeholder="ค้นหา...">
            <div class="absolute top-0 left-0 inline-flex items-center p-2 mt-1 ml-2 text-gray-400">
                <i class="fas fa-search"></i>
            </div>
        </div>
    </div>

    <!-- Documents Table -->
    <div class="overflow-x-auto">
        <table id="documentsTable" class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">เลขที่</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">เรื่อง</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">จาก</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">ลงวันที่</th>
                    <th class="text-center py-3 px-4 uppercase font-semibold text-sm">สถานะ</th>
                    <th class="text-center py-3 px-4 uppercase font-semibold text-sm">ไฟล์แนบ</th>
                    <th class="text-center py-3 px-4 uppercase font-semibold text-sm">ดำเนินการ</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                <?php if (!empty($data['documents'])): ?>
                    <?php foreach($data['documents'] as $doc): ?>
                        <tr class="border-b hover:bg-gray-100">
                            <td class="py-3 px-4"><?php echo htmlspecialchars($doc->doc_number); ?></td>
                            <td class="py-3 px-4"><?php echo htmlspecialchars($doc->doc_subject); ?></td>
                            <td class="py-3 px-4"><?php echo htmlspecialchars($doc->doc_from); ?></td>
                            <td class="py-3 px-4"><?php echo date('d/m/Y', strtotime($doc->doc_date)); ?></td>
                            <td class="text-center py-3 px-4">
                                <span class="<?php echo getStatusBadgeClass($doc->status); ?> py-1 px-3 rounded-full text-xs font-semibold">
                                    <?php echo translateStatusToThai($doc->status); ?>
                                </span>
                            </td>
                            <td class="text-center py-3 px-4">
                                <a href="<?php echo URLROOT; ?>/uploads/<?php echo $doc->doc_file; ?>" target="_blank" class="text-blue-500 hover:text-blue-700">
                                    <i class="fa-solid fa-file-pdf fa-lg"></i>
                                </a>
                            </td>
                            <td class="text-center py-3 px-4">
                                <a href="<?php echo URLROOT; ?>/documents/show/<?php echo $doc->doc_id; ?>" class="text-green-500 hover:text-green-700" title="ดูรายละเอียด/ดำเนินการ">
                                    <i class="fa-solid fa-share-square fa-lg"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center py-4">ไม่พบข้อมูลเอกสาร</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>