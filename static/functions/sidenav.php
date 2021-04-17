<div class="bg-white z-depth-2 " id="sidebar-wrapper" style="max-width: 240px;">
    <div class="sidebar-heading bg-white">
        <img src="../static/elements/logo/android-icon-192x192.png" width="192"/>
    </div>
    <div class="text-center mb-5"><h5 class="text-pharm font-weight-bold">ระบบติดตามการจัดหา<br>ยาเฉพาะรายให้ผู้ป่วย</h5>
    <small class="text-pharm">งานเภสัชกรรม โรงพยาบาลศรีนครินทร์</small></div>
    <div class="list-group list-group-flush">
        <a href="../status/" class="list-group-item list-group-item-action sidenavGreen <?php echo isCurrent("/status/"); ?>">ติดตามสถานะเอกสาร</a>
        <a href="../form/" class="list-group-item list-group-item-action sidenavGreen <?php echo isCurrent("/form/"); ?>">กรอกแบบฟอร์มขอใช้ยา</a>
        <!--?php if (isAdmin()) { ?-->
        <a href="../list/" class="list-group-item list-group-item-action sidenavGreen <?php echo isCurrent("/list/"); ?>">รายการเอกสาร</a>
        <a href="../task/" class="list-group-item list-group-item-action sidenavGreen <?php echo isCurrent("/task/"); ?>">เอกสารรอรับรอง</a>
        <!--?php } ?-->
        <br>
    </div>
</div>
<?php function isCurrent(String $url) {
    global $current_url;
    if (str_contains($current_url, $url))
        return "current";
} ?>