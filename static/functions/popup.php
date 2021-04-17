<!-- Popup Modal -->
<div class="modal animated fade" id="modalPopup" name="modalPopup" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-notify modal-pharm modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalBodyBody">
                <div id="modalBody"></div>
                <div id="modalBodyCode"></div>
            </div>
        </div>
    </div>
</div>
<!-- Full Height Modal -->
<div class="modal fade left" id="sidenav" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-full-height modal-left modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="bg-white">
                <div class="sidebar-heading bg-white w-100 text-center">
                    <img src="../static/elements/logo/android-icon-192x192.png" width="192" />
                </div>
                <div class="text-center mb-5 w-100">
                    <h5 class="text-pharm font-weight-bold">ระบบติดตามการจัดหา<br>ยาเฉพาะรายให้ผู้ป่วย</h5>
                    <small class="text-pharm">งานเภสัชกรรม โรงพยาบาลศรีนครินทร์</small>
                </div>
                <div class="list-group list-group-flush w-100">
                    <a href="../status/"
                        class="list-group-item list-group-item-action sidenavGreen <?php echo isCurrent("/status/"); ?>">ติดตามสถานะเอกสาร</a>
                    <a href="../form/"
                        class="list-group-item list-group-item-action sidenavGreen <?php echo isCurrent("/form/"); ?>">กรอกแบบฟอร์มขอใช้ยา</a>
                    <!--?php if (isAdmin()) { ?-->
                    <a href="../list/"
                        class="list-group-item list-group-item-action sidenavGreen <?php echo isCurrent("/list/"); ?>">รายการเอกสาร</a>
                    <a href="../task/"
                        class="list-group-item list-group-item-action sidenavGreen <?php echo isCurrent("/task/"); ?>">เอกสารรอรับรอง</a>
                    <!--?php } ?-->
                    <br>
                </div>
            </div>
            <?php function isCurrent(String $url) {
                global $current_url;
                if (str_contains($current_url, $url))
                    return "current";
            } ?>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $('#sidenav').on('show.bs.modal', function (e) {
        jQuery('html, body').animate({
            scrollTop: jQuery('body').offset().top
        }, 0);   
        $("body").css('overflow-y', 'hidden');
        $("body").css('height', '100vh');
    });
    $('#sidenav').on('hide.bs.modal', function (e) {
        $("body").css('overflow-y', '');
        $("body").css('height', '');
    });
});
</script>
<!-- Full Height Modal -->
<!-- Popup Modal -->
<?php 
    if (isset($_SESSION['swal_error']) && isset($_SESSION['swal_error_msg'])) { 
        errorSwal($_SESSION['swal_error'],$_SESSION['swal_error_msg']);
        $_SESSION['swal_error'] = null;
        $_SESSION['swal_error_msg'] = null;
    }
?>
<?php 
    if (isset($_SESSION['swal_warning']) && isset($_SESSION['swal_warning_msg'])) { 
        warningSwal($_SESSION['swal_warning'],$_SESSION['swal_warning_msg']);
        $_SESSION['swal_warning'] = null;
        $_SESSION['swal_warning_msg'] = null;
    }
?>
<?php 
    if (isset($_SESSION['swal_success'])) { 
        successSwal($_SESSION['swal_success'],$_SESSION['swal_success_msg']);
        $_SESSION['swal_success'] = null;
        $_SESSION['swal_success_msg'] = null;
    }
?>
<script>
    $("#logoutBtn").click(function () {
        swal({
            title: "ออกจากระบบ ?",
            text: "คุณต้องการออกจากระบบหรือไม่?",
            icon: "warning",
            buttons: true,
            dangerMode: true
        }).then((willDelete) => {
            if (willDelete) {
                window.location = "../logout/";
            }
        });
    });
</script>