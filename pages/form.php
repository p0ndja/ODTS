<div class="container">
            <div class="card mt-5 mb-5 h-100">
                <div class="card-body">
                    <form method="POST" action="#SubmitForm">
                        <h4 class="font-weight-bold text-center">แบบฟอร์ม "....."</h4>
                        <div class="mb-3">
                            <h6 class="font-weight-bold">ข้อมูลแพทย์ผู้ใช้ยา</h6>
                            <div class="form-group row">
                                <label for="doctorName" class="col-md-3 col-form-label text-md-right">ชื่อ-สกุลแพทย์</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="doctorName" name="doctorName" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="doctorDivision" class="col-md-3 col-form-label text-md-right">ภาควิชา</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="doctorDivision" name="doctorDivision"
                                        required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="doctorTelephone" class="col-md-3 col-form-label text-md-right">โทรศัพท์</label>
                                <div class="col-md-9">
                                    <input type="tel" class="form-control" id="doctorTelephone" name="doctorTelephone"
                                        pattern="[0-9]{10}" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <h6 class="font-weight-bold">ข้อมูลผู้ป่วย</h6>
                            <div class="form-group row">
                                <label for="patientName"
                                    class="col-md-3 col-form-label text-md-right">ชื่อ-สกุลผู้ป่วย</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="patientName" name="patientName" required>
                                </div>
                                <label for="patientHN" class="col-md-1 col-form-label text-md-right">HN</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" id="patientHN" name="patientHN" required>
                                </div>
                            </div>
                            <div class="form-group row text-nowrap">
                                <label for="patientAge" class="col-md-3 col-form-label text-md-right">อายุ</label>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" min="0" id="patientAge" name="patientAge"
                                        required>
                                </div>
                                <label for="patientWeight" class="col-md-1 col-form-label text-md-right">น้ำหนัก</label>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" min="0" id="patientWeight"
                                        name="patientWeight" required>
                                </div>
                                <label for="patientHeight" class="col-md-1 col-form-label text-md-right">ส่วนสูง</label>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" min="0" id="patientHeight"
                                        name="patientHeight" required>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label text-md-right" for="patientECOG">ECOG Score</label>
                                <div class="col-md-9 range-field">
                                    <input type="range" value="1" min="1" max="5" id="patientECOG"
                                        name="patientECOG" />
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
                                        <input class="form-check-input" type="radio" name="patientPayer" id="patientPayerUC"
                                            value="UC" required>
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
                                        <input type="text" class="form-control ml-2" id="hiddenOtherField" name="patientPayerOther" disabled/>
                                        <script>
                                            $("input[type=radio]").change(function() {
                                                $("#hiddenOtherField").val("");
                                                if(this.value == "Oth") {
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
                                    <input type="text" class="form-control" id="medicineName" name="medicineName" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="medicineQuantity"
                                    class="col-md-3 col-form-label text-md-right">ขนาดยาที่ใช้ต่อครั้ง</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="medicineQuantity" name="medicineQuantity" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="medicineTimeUse"
                                    class="col-md-3 col-form-label text-md-right">จำนวนครั้งที่ใช้</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="medicineTimeUse" name="medicineTimeUse" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="medicineTimeUse"
                                    class="col-md-3 col-form-label text-md-right">จำนวนครั้งที่ใช้</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="medicineTimeUse" name="medicineTimeUse" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="allTimeMed"
                                    class="col-md-3 col-form-label text-md-right">ระยะเวลาทั้งหมด</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="allTimeMed" name="allTimeMed" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="medicinePay"
                                    class="col-md-3 col-form-label text-md-right">ราคายาทั้งหมด</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="medicinePay" name="medicinePay" required><br>
                                </div>
                            </div>
                        
                        
                        <div class="row">
                            <label for="medicineReason" 
                                class="col-form-label" style="margin-left: 60px; margin-bottom: 15px;">เหตุผลที่ไม่สามารถใช้ยาในบัญชีหลักแห่งชาติ</label>
                            <div class="col-md-9" style="margin-left: 100px;">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="medicineReason"
                                        id="choice1Reason" value="Direct" required>
                                    <label class="form-check-label" for="choice1Reason">เกิดอาการข้างเคียงในการใช้ยาในบัญชียาหลักแห่งชาติ(ADR) หรือแพ้ยา</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="medicineReason"
                                        id="choice2Reason" value="Direct" required>
                                    <label class="form-check-label" for="choice2Reason">ผู้ป่วยใช้ยาในบัญชียาหลักแห่งชาติแล้ว แต่ผลการรักษาไม่บรรลุเป้าหมาย</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="medicineReason"
                                        id="choice3Reason" value="Direct" required>
                                    <label class="form-check-label" for="choice3Reason">ไม่มียาในบัญชียาหลักแห่งชาติให้ใช้ แต่ผู้ป่วยมีข้อบ่งชี้การใช้ยาตามที่ อย. กำหนด</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="medicineReason"
                                        id="choice4Reason" value="Direct" required>
                                    <label class="form-check-label" for="choice4Reason">มี Contraindication หรือ Drug Interaction กับยาในบัญชียาหลักแห่งชาติ</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="medicineReason"
                                        id="choice5Reason" value="Direct" required>
                                    <label class="form-check-label" for="choice5Reason">ยาในบัญชียาหลักแห่งชาติราคาแพงกว่า</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="medicineReason"
                                        id="choice6Reason" value="Direct" required>
                                    <label class="form-check-label" for="choice6Reason">ผู้ป่วยแสดงความจำนงต้องการ (เบิกไม่ได้)</label>
                                </div>
                            </div>
                        </div>
                        <div class="text-center"><button type="submit" class="btn btn-success">Submit</button></div>
                    </form>
                </div>
            </div>
</div>