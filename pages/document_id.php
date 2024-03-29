<?php
    if (!isLogin()) header('Location: ../login/');
    if (!isset($_GET['id'])) header("Location: ../document/");
?>
<div class="container">
    <div class="row justify-content-center align-items-center">
        <div class="col">
            <div class="card mt-5 mb-5">
                <div class="card-body">
                    <?php
                        $id = (int) $_GET['id'];
                        $sessionid = $_SESSION['user']->getID();

                        $doc = new Document($id);
                        if ($doc->getID() == -1) header("Location: ../document/"); //Invalid Document ID

                        $owner = $doc->getProperties("owner");
                        $state = $doc->getProperties("state");

                        $upload_time = beautiDate($doc->getData("upload_time"));
                        $patient_hn = $doc->getData("patientHN");
                        $doctor_name = $doc->getData("doctorName");
                        $flow = $doc->getData("flow");

                        $last_state = 5;
                        $last_state_status = 0;
                        $list_flow = array();
                        foreach($flow as $f) {
                            array_push($list_flow, $f);
                            if ((int) $state[$f]["status"] != 9) {
                                $last_state = $f;
                                $last_state_status = $state[$f]["status"];
                                break;
                            }
                        }
                    ?>
                        <a onclick="javascript:window.history.back();" class="float-left"><i class="fas fa-arrow-left"></i> ย้อนกลับ</a>
                        <h3 class="font-weight-bold text-center">ข้อมูลเอกสาร <span class="badge badge-pharm">#<?php echo sprintf("%06d", (float) ($id)); ?></span></h3>
                        <hr>
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <div class="card mb-3">
                                    <div class="card-body card-text">
                                        <b>เวลา:</b> <?php echo $upload_time; ?><br>
                                        <b>หมายเลข HN:</b> <?php echo $patient_hn; ?><br>
                                        <b>ผู้สั่งยา:</b> <?php echo $doctor_name; ?><br>
                                    </div>    
                                </div>
                                <?php if ((int) $last_state_status >= 0 && isMyTask($last_state)) { ?>
                                <div class="card border-danger mb-3">
                                    <div class="card-body">
                                        <form method="POST" action="../pages/document_status_save.php" id="form">
                                            <input type="hidden" name="doc_id" value="<?php echo $id; ?>">
                                            <input type="hidden" id="status" name="status" value="">
                                            <input type="hidden" id="current" name="current" value="<?php echo $last_state ?>">
                                            <label for="comment">ลงความเห็น <small class="text-info">สามารถเว้นว่างได้</small></label>    
                                            <textarea id="comment" name="comment" class="form-control mb-3" rows="5"></textarea>
                                            <a id="approve" class="btn btn-success btn-block text-dark">ยอมรับคำร้อง (Approve)</a>
                                            <a id="recheck" class="btn btn-warning btn-block text-dark">ร้องขอการแก้ไข (Recheck)</a>
                                            <a id="reject" class="btn btn-danger btn-block">ปฏิเสธคำร้อง (Reject)</a>
                                        </form>
                                        <script>
                                            $("#approve").click(function () {
                                                $("#status").val("9");
                                                swal({
                                                    title: "ท่านกำลัง \"ยอมรับ\" คำร้องนี้",
                                                    text: "การดำเนินการดังกล่าวไม่สามารถย้อนกลับได้",
                                                    icon: "warning",
                                                    buttons: true,
                                                    dangerMode: true
                                                }).then((willDelete) => {
                                                    if (willDelete) {
                                                        $("#form").submit();
                                                    }
                                                });
                                            });
                                            $("#recheck").click(function () {
                                                $("#status").val("-1");
                                                swal({
                                                    title: "ท่านกำลัง \"ร้องขอการแก้ไข\" คำร้องนี้",
                                                    text: "การดำเนินการดังกล่าวไม่สามารถย้อนกลับได้",
                                                    icon: "warning",
                                                    buttons: true,
                                                    dangerMode: true
                                                }).then((willDelete) => {
                                                    if (willDelete) {
                                                        $("#form").submit();
                                                    }
                                                });
                                            });
                                            $("#reject").click(function () {
                                                $("#status").val("-9");
                                                swal({
                                                    title: "ท่านกำลัง \"ปฏิเสธ\" คำร้องนี้",
                                                    text: "การดำเนินการดังกล่าวไม่สามารถย้อนกลับได้",
                                                    icon: "warning",
                                                    buttons: true,
                                                    dangerMode: true
                                                }).then((willDelete) => {
                                                    if (willDelete) {
                                                        $("#form").submit();
                                                    }
                                                });
                                            });
                                        </script>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="col-12 col-md-8 grey lighten-4">
                            <form class="disabled" disabled>
                                <h5 class="font-weight-bold text-center mt-3 mb-3">แบบฟอร์มการขอใช้ยาเฉพาะรายที่ไม่มีในเภสัชตำหรับโรงพยาบาล</h5>
                                <hr>
                                <div class="mb-3 mt-3">
                                    <h6 class="font-weight-bold">ข้อมูลแพทย์ผู้ใช้ยา</h6>
                                    <div class="form-group row">
                                        <label for="doctorName"
                                            class="col-md-3 col-form-label text-md-right">ชื่อ-สกุลแพทย์</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="doctorName" name="doctorName" required value="<?php echo $doc->getData("doctorName"); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="doctorDivision"
                                            class="col-md-3 col-form-label text-md-right">ภาควิชา</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="doctorDivision" name="doctorDivision" required  value="<?php echo $doc->getData("doctorDivision"); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="doctorTelephone"
                                            class="col-md-3 col-form-label text-md-right">โทรศัพท์</label>
                                        <div class="col-md-9">
                                            <input type="tel" class="form-control" id="doctorTelephone" name="doctorTelephone" pattern="[0-9]{10}" required value="<?php echo $doc->getData("doctorTelephone");?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <h6 class="font-weight-bold">ข้อมูลผู้ป่วย</h6>
                                    <div class="form-group row">
                                        <label for="patientName"
                                            class="col-md-3 col-form-label text-md-right">ชื่อ-สกุลผู้ป่วย</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="patientName" name="patientName" required value="<?php echo $doc->getData('patientName'); ?>">
                                        </div>
                                        <label for="patientHN" class="col-md-1 col-form-label text-md-right">HN</label>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control" id="patientHN" name="patientHN" required value="<?php echo $doc->getData('patientHN'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row text-nowrap">
                                        <label for="patientAge" class="col-md-3 col-form-label text-md-right">อายุ</label>
                                        <div class="col-md-2">
                                            <input type="number" class="form-control" min="0" id="patientAge" name="patientAge" required value="<?php echo $doc->getData('patientAge'); ?>">
                                        </div>
                                        <label for="patientWeight" class="col-md-1 col-form-label text-md-right">น้ำหนัก</label>
                                        <div class="col-md-2">
                                            <input type="number" class="form-control" min="0" id="patientWeight" name="patientWeight" required value="<?php echo $doc->getData('patientWeight'); ?>">
                                        </div>
                                        <label for="patientHeight" class="col-md-1 col-form-label text-md-right">ส่วนสูง</label>
                                        <div class="col-md-2">
                                            <input type="number" class="form-control" min="0" id="patientHeight" name="patientHeight" required value="<?php echo $doc->getData('patientHeight'); ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-3 col-form-label text-md-right" for="patientECOG">ECOG
                                            Score</label>
                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="d-none">
                                                    <input type="range" class="custom-range" min="0" max="5" step="1" id="patientECOG" name="patientECOG" value="<?php echo $doc->getData('patientECOG'); ?>">
                                                </div>
                                                <div class="col-12">
                                                    <span class="font-weight-bold text-primary ml-2 valueSpan2"></span>
                                                </div>
                                            </div>
                                            <script>
                                                function msg(x) {
                                                    if (x == 0) {
                                                        return "0 - ปกติ";
                                                    } else if (x == 1) {
                                                        return "1 - ทำงานเบา ๆ ได้";
                                                    } else if (x == 2) {
                                                        return "2 - ทำงานไม่ได้เลย";
                                                    } else if (x == 3) {
                                                        return "3 - ช่วยเหลือตัวเองได้จำกัด"; 
                                                    } else if (x == 4) {
                                                        return "4 - พิการ";
                                                        color = "text-warning";
                                                    } else if (x == 5) {
                                                        return "5 - ตาย";
                                                    }
                                                }
                                                function color(x) {
                                                    if (x == 0) {
                                                        return "text-success";
                                                    } else if (x == 1) {
                                                        return "text-info";
                                                    } else if (x == 2) {
                                                        return "text-primary";
                                                    } else if (x == 3) {
                                                        return "text-secondary";
                                                    } else if (x == 4) {
                                                        return "text-warning";
                                                    } else if (x == 5) {
                                                        return "text-danger";
                                                    }
                                                }
                                                $(document).ready(function () {
                                                    const $valueSpan = $('.valueSpan2');
                                                    const $value = $('#patientECOG');
                                                    $value.on('input change', () => {
                                                        $valueSpan.attr('class', function(i, c){
                                                            return c.replace(/(^|\s)text-\S+/g, '');
                                                        });
                                                        $valueSpan.addClass(color($value.val()));
                                                        $valueSpan.html(msg($value.val()));
                                                    });
                                                    $valueSpan.html(msg(<?php echo $doc->getData('patientECOG'); ?>))
                                                    $valueSpan.addClass(color(<?php echo $doc->getData('patientECOG'); ?>));
                                                });
                                            </script>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-3 col-form-label text-md-right" for="patientPayer">สิทธิ</label>
                                        <div class="col-md-9">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="patientPayer"
                                                    id="patientPayerDirect" value="Direct" required>
                                                <label class="form-check-label" for="patientPayerDirect">จ่ายตรง</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="patientPayer"
                                                    id="patientPayerLocal" value="Local" required>
                                                <label class="form-check-label" for="patientPayerLocal">อปท.</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="patientPayer"
                                                    id="patientPayerSOF" value="SOF" required>
                                                <label class="form-check-label" for="patientPayerSOF">รัฐวิสาหกิจ</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="patientPayer"
                                                    id="patientPayerUC" value="UC" required>
                                                <label class="form-check-label" for="patientPayerUC">บัตรทอง</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="patientPayer"
                                                    id="patientPayerSSS" value="SSS" required>
                                                <label class="form-check-label" for="patientPayerSSS">ประกันสังคม</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="patientPayer"
                                                    id="patientPayerSelfPay" value="SelfPay" required>
                                                <label class="form-check-label" for="patientPayerSelfPay">Self-Pay</label>
                                            </div>
                                            <div class="form-inline">
                                                <input class="form-check-input" type="radio" name="patientPayer"
                                                    id="patientPayerOth" value="Oth" required>
                                                <label class="form-check-label" for="patientPayerOth">อื่น ๆ</label>
                                                <input type="text" class="form-control ml-2" id="hiddenOtherField"
                                                    name="patientPayerOther" disabled />
                                                <script>
                                                    $("#patientPayer<?php echo $doc->getData('patientPayer'); ?>").attr('checked','checked');
                                                    if ("<?php echo $doc->getData('patientPayerOther');?>" != null) {
                                                        $("#hiddenOtherField").removeAttr("disabled");
                                                        $("#hiddenOtherField").val("<?php echo $doc->getData('patientPayerOther'); ?>");
                                                    }
                                                </script>
                                                <script>
                                                    $("input[type=radio]").change(function () {
                                                        $("#hiddenOtherField").val("");
                                                        if (this.value == "Oth") {
                                                            $("#hiddenOtherField").removeAttr("disabled");
                                                        } else {
                                                            $("#hiddenOtherField").prop('disabled', 'disabled');
                                                        }
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <h6 class="font-weight-bold">ข้อมูลยา</h6>
                                    <div class="form-group row">
                                        <label for="medicineName"
                                            class="col-md-3 col-form-label text-md-right">ชื่อยาและความแรง</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="medicineName" name="medicineName" required value="<?php echo $doc->getData("medicineName"); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="medicineQuantity"
                                            class="col-md-3 col-form-label text-md-right">ขนาดยาที่ใช้ต่อครั้ง</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="medicineQuantity"
                                                name="medicineQuantity" required value="<?php echo $doc->getData("medicineQuantity"); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="medicineTimeUse"
                                            class="col-md-3 col-form-label text-md-right">จำนวนครั้งที่ใช้</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="medicineTimeUse" name="medicineTimeUse" required value="<?php echo $doc->getData('medicineTimeUse'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="allTimeMed"
                                            class="col-md-3 col-form-label text-md-right">ระยะเวลาทั้งหมด</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="allTimeMed" name="allTimeMed" required value="<?php echo $doc->getData('allTimeMed'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="medicinePay"
                                            class="col-md-3 col-form-label text-md-right">ราคายาทั้งหมด</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="medicinePay" name="medicinePay" required value="<?php echo $doc->getData('medicinePay'); ?>"><br>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <label for="medicineReason" class="col-form-label"
                                            style="margin-left: 60px; margin-bottom: 15px;">เหตุผลที่ไม่สามารถใช้ยาในบัญชีหลักแห่งชาติ</label>
                                        <div class="col-md-9" style="margin-left: 100px;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="medicineReason"
                                                    id="choice1Reason" value="1" required>
                                                <label class="form-check-label"
                                                    for="choice1Reason">เกิดอาการข้างเคียงในการใช้ยาในบัญชียาหลักแห่งชาติ(ADR)
                                                    หรือแพ้ยา</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="medicineReason"
                                                    id="choice2Reason" value="2" required>
                                                <label class="form-check-label"
                                                    for="choice2Reason">ผู้ป่วยใช้ยาในบัญชียาหลักแห่งชาติแล้ว
                                                    แต่ผลการรักษาไม่บรรลุเป้าหมาย</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="medicineReason"
                                                    id="choice3Reason" value="3" required>
                                                <label class="form-check-label"
                                                    for="choice3Reason">ไม่มียาในบัญชียาหลักแห่งชาติให้ใช้
                                                    แต่ผู้ป่วยมีข้อบ่งชี้การใช้ยาตามที่ อย. กำหนด</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="medicineReason"
                                                    id="choice4Reason" value="4" required>
                                                <label class="form-check-label" for="choice4Reason">มี Contraindication หรือ
                                                    Drug Interaction กับยาในบัญชียาหลักแห่งชาติ</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="medicineReason"
                                                    id="choice5Reason" value="5" required>
                                                <label class="form-check-label"
                                                    for="choice5Reason">ยาในบัญชียาหลักแห่งชาติราคาแพงกว่า</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="medicineReason"
                                                    id="choice6Reason" value="6" required>
                                                <label class="form-check-label" for="choice6Reason">ผู้ป่วยแสดงความจำนงต้องการ
                                                    (เบิกไม่ได้)</label>
                                            </div>
                                            <script>
                                                $("#choice<?php echo $doc->getData('medicineReason'); ?>Reason").attr('checked','checked');
                                            </script>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                </script>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>