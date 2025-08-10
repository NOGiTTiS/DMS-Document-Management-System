<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column: PDF Viewer -->
    <div class="lg:col-span-2 bg-gray-200 p-4 rounded-lg shadow-inner">
        <?php if (!empty($data['document']->doc_file) && file_exists('uploads/' . $data['document']->doc_file)): ?>
            <iframe src="<?php echo URLROOT; ?>/uploads/<?php echo $data['document']->doc_file; ?>" class="w-full h-[80vh] border-none rounded-md"></iframe>
        <?php else: ?>
            <div class="w-full h-[80vh] flex items-center justify-center bg-gray-300 rounded-md">
                <p class="text-gray-500 font-semibold"><i class="fas fa-exclamation-triangle mr-2"></i> ไม่พบไฟล์เอกสาร</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Right Column: Details & Actions -->
    <div class="lg:col-span-1 bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-bold text-gray-800 mb-4">รายละเอียดเอกสาร</h3>
        
        <div class="space-y-3 text-sm">
            <p><strong>ที่:</strong> <?php echo htmlspecialchars($data['document']->doc_number); ?></p>
            <p><strong>ลงวันที่:</strong> <?php echo date('d F Y', strtotime($data['document']->doc_date)); ?></p>
            <p><strong>จาก:</strong> <?php echo htmlspecialchars($data['document']->doc_from); ?></p>
            <p class="break-words"><strong>เรื่อง:</strong> <?php echo htmlspecialchars($data['document']->doc_subject); ?></p>
            <hr>
            <div class="flex items-center">
                <p class="mr-2"><strong>สถานะปัจจุบัน:</strong></p>
                <span class="<?php echo getStatusBadgeClass($data['document']->status); ?> py-1 px-3 rounded-full text-xs font-semibold">
                    <?php echo htmlspecialchars($data['document']->status); ?>
                </span>
            </div>
        </div>

        <hr class="my-6">

        <!-- Action Form: ตรวจสอบสถานะและผู้รับ -->
        <?php
            $latest_history = !empty($data['history']) ? end($data['history']) : null;
            $isMyTurn = false;
            $final_statuses = ['completed', 'rejected'];

            if ($_SESSION['user_role'] == 'officer' && $data['document']->status == 'receiving') {
                $isMyTurn = true;
            }
            if ($latest_history && $latest_history->action_to == $_SESSION['user_id'] && !in_array($data['document']->status, $final_statuses)) {
                $isMyTurn = true;
            }
        ?>

        <?php if($isMyTurn): ?>
            <h4 class="text-lg font-semibold text-gray-800 mb-3">ดำเนินการ</h4>
            
            <form id="mainActionForm" class="space-y-4">
                <div>
                    <label for="comment" class="block text-gray-700 text-sm font-bold mb-2">เกษียนหนังสือ/ความเห็น:</label>
                    <textarea id="comment" name="comment" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
                </div>
            </form>

            <div class="space-y-2 mt-4">
                <!-- ฟอร์มสำหรับส่งต่อ (Forward) -->
                <form id="forwardForm" action="<?php echo URLROOT; ?>/documents/forward/<?php echo $data['document']->doc_id; ?>" method="post">
                    <div class="mb-2">
                        <label for="action_to_id" class="block text-gray-700 text-sm font-bold mb-2">ส่งต่อไปยัง:</label>
                        <select name="action_to_id" id="action_to_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">-- เลือกผู้รับ --</option>
                            <?php foreach($data['users'] as $user): ?>
                                <option value="<?php echo $user->user_id; ?>"><?php echo htmlspecialchars($user->fullname . ' (' . ucfirst($user->role) . ')'); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        <i class="fa-solid fa-share-square mr-2"></i> ส่งต่อ
                    </button>
                </form>

                <!-- ปุ่มสำหรับ อนุมัติ และ ตีกลับ (แสดงเฉพาะผู้มีสิทธิ์) -->
                <?php if ($_SESSION['user_role'] == 'director'): ?>
                    <div class="pt-2 border-t border-gray-200 space-y-2">
                        <button type="submit" form="approveForm" class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            <i class="fa-solid fa-check-circle mr-2"></i> อนุมัติ/จบเรื่อง
                        </button>
                        <button type="submit" form="rejectForm" class="w-full bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            <i class="fa-solid fa-times-circle mr-2"></i> ตีกลับ
                        </button>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- ฟอร์มซ่อนสำหรับ Action อื่นๆ -->
            <form id="approveForm" action="<?php echo URLROOT; ?>/documents/approve/<?php echo $data['document']->doc_id; ?>" method="post" class="hidden"></form>
            <form id="rejectForm" action="<?php echo URLROOT; ?>/documents/reject/<?php echo $data['document']->doc_id; ?>" method="post" class="hidden"></form>
        <?php else: ?>
            <p class="text-center text-gray-500 italic">เอกสารถูกส่งต่อแล้ว หรือไม่ได้อยู่ในระหว่างรอการพิจารณา</p>
        <?php endif; ?>
        
        <hr class="my-6">

        <!-- Document History -->
        <h4 class="text-lg font-semibold text-gray-800 mb-3">ประวัติการดำเนินการ</h4>
        <div class="space-y-4 text-xs max-h-60 overflow-y-auto pr-2">
            <?php if (!empty($data['history'])): ?>
                <?php foreach($data['history'] as $item): ?>
                    <div class="border-l-4 border-pink-500 pl-3 py-1">
                        <div class="flex justify-between items-center">
                            <p class="font-bold text-gray-800"><?php echo htmlspecialchars($item->action_by_name); ?></p>
                            <p class="text-gray-400"><?php echo date('d/m/y H:i', strtotime($item->action_at)); ?></p>
                        </div>
                        <?php if(!empty($item->action_to_name)): ?>
                            <p class="text-xs text-gray-500">
                                <i class="fas fa-long-arrow-alt-right"></i> ส่งถึง: <?php echo htmlspecialchars($item->action_to_name); ?>
                            </p>
                        <?php endif; ?>
                        <p class="text-gray-600 mt-1 pl-1 border-l-2 border-gray-200"><?php echo nl2br(htmlspecialchars($item->comment)); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center text-gray-400">ยังไม่มีประวัติการดำเนินการ</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    // Script เพื่อคัดลอก comment ไปยังฟอร์มอื่นเมื่อ submit
    function copyCommentToForms() {
        const mainComment = document.getElementById('comment').value;
        const formsToUpdate = ['forwardForm', 'approveForm', 'rejectForm'];

        formsToUpdate.forEach(formId => {
            const form = document.getElementById(formId);
            if(form){
                form.addEventListener('submit', function(e) {
                    // Remove old comment input if exists
                    let oldCommentInput = this.querySelector('input[name="comment"]');
                    if (oldCommentInput) {
                        oldCommentInput.remove();
                    }
                    // Add new comment input
                    let commentInput = document.createElement('input');
                    commentInput.type = 'hidden';
                    commentInput.name = 'comment';
                    commentInput.value = mainComment;
                    this.appendChild(commentInput);
                });
            }
        });
    }
    copyCommentToForms();
</script>