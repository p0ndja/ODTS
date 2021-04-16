<?php
    if (!isLogin()) header("Location: ../login/"); 
    if (!isset($_GET['id'])) header("Location: ../status/");
?>
<div class="container">
    <div class="card mt-5">
        <div class="card-body">
            <?php
                $id = (int) $_GET['id'];
                $sessionid = $_SESSION['user']->getID();
                if ($stmt = $conn -> prepare("SELECT * FROM `document` WHERE JSON_EXTRACT(`properties`,'$.owner') = ? AND `id` = ? ORDER BY `id` LIMIT 1")) {
                    $stmt->bind_param('ii',$sessionid,$id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $properties = json_decode($row['properties'], true);
                            $owner = array_key_exists("owner", $properties) ? $properties["owner"] : "-";
                            $state = array_key_exists("state", $properties) ? $properties["state"] : 0;

                            $data = json_decode($row['data'], true);
                            $upload_time = array_key_exists("upload_time", $data) ? beautiDate($data["upload_time"]) : "Undefined";
                            $patient_hn = array_key_exists("patientHN", $data) ? $data["patientHN"] : "Undefined";
                            $doctor_name = array_key_exists("doctorName", $data) ? $data["doctorName"] : "Undefined";
                            $flow = array_key_exists("flow", $data) ? $data['flow'] : array();
                        }
                    } 
                }
                $last_state = 5;
                $list_flow = array();
                foreach($flow as $f) {
                    array_push($list_flow, $f);
                    if ((int) $properties["state"][$f]["status"] != 9) {
                        $last_state = (int) $properties["state"][$f]["status"];
                        break;
                    }
                }
            ?>
            <h3 class="font-weight-bold text-center">สถานะเอกสาร <span class="badge badge-pharm">#<?php echo sprintf("%06d", (float) ($id)); ?></span></h3>
            <div class="container mt-3">
                <div class="d-md-flex justify-content-center align-items-center d-none d-md-block mb-md-3">
                    <?php
                        $i = 0;
                        foreach($flow as $f) {
                            $i++;
                            echo "<div class='row text-center'><div class='col-12'><img src='" . state_status_image($f, (int) $properties["state"][$f]["status"]) . "' width=50% class='ml-2 mr-2'></div><div class='col-12'><small>" .state($f). "</small></div></div>";
                            if ($i != count($flow)) echo "<img src='../static/elements/status/arrow.svg' width=16>";
                        }
                    ?>
                </div>
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="card">
                            <div class="card-body card-text">
                                <b>เวลา:</b> <?php echo $upload_time; ?><br>
                                <b>หมายเลข HN:</b> <?php echo $patient_hn; ?><br>
                                <b>ผู้สั่งยา:</b> <?php echo $doctor_name; ?><br>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-8">
                        <!-- timeline item 1 -->
                        <?php
                        $i = 0;
                        foreach(array_reverse($list_flow) as $f) { $i++?>
                        <div class="row">
                            <!-- timeline item 1 left dot -->
                            <div class="col-auto text-center flex-column d-none d-sm-flex">
                                <div class="row h-50">
                                    <div class="col <?php if ($i != 1) echo ' border-right'; ?>">&nbsp;</div>
                                    <div class="col">&nbsp;</div>
                                </div>
                                <h5 class="m-2">
                                    <span class="badge badge-pill bg-<?php echo status_color((int) $properties["state"][$f]["status"]); ?>">&nbsp;</span>
                                </h5>
                                <div class="row h-50">
                                    <div class="col <?php if ($i != count($list_flow)) echo ' border-right'; ?>">&nbsp;</div>
                                    <div class="col">&nbsp;</div>
                                </div>
                            </div>
                            <!-- timeline item 1 event content -->
                            <div class="col py-2">
                                <div class="card <?php if ($i != 1) echo "border-"; else echo "bg-"?><?php echo status_color((int) $properties["state"][$f]["status"]); ?>">
                                    <div class="card-body">
                                    <div class="float-right"><?php if ((int) $properties["state"][$f]["status"] != 9) echo status((int) $properties["state"][$f]["status"]); else echo beautiDate($properties["state"][$f]["update"]); ?></div>
                                        <h4 class="card-title"><?php echo state($f); ?></h4>
                                        <?php if (!empty($properties["state"][$f]["comment"])) echo '<p>'.$properties["state"][$f]["comment"].'</p>'; ?>
                                        <!--button class="btn btn-sm btn-outline-success" type="button"
                                            data-target="#t2_details" data-toggle="collapse">Show Details
                                            ▼</button>
                                        <div class="collapse border" id="t2_details">
                                            <div class="p-2 text-monospace">
                                                <div>08:30 - 09:00 Breakfast in CR 2A</div>
                                                <div>09:00 - 10:30 Live sessions in CR 3</div>
                                                <div>10:30 - 10:45 Break</div>
                                                <div>10:45 - 12:00 Live sessions in CR 3</div>
                                                <div>08:30 - 09:00 Breakfast in CR 2A</div>
                                                <div>09:00 - 10:30 Live sessions in CR 3</div>
                                                <div>10:30 - 10:45 Break</div>
                                                <div>10:45 - 12:00 Live sessions in CR 3</div>
                                                <div>08:30 - 09:00 Breakfast in CR 2A</div>
                                                <div>09:00 - 10:30 Live sessions in CR 3</div>
                                                <div>10:30 - 10:45 Break</div>
                                                <div>10:45 - 12:00 Live sessions in CR 3</div>
                                                <div>08:30 - 09:00 Breakfast in CR 2A</div>
                                                <div>09:00 - 10:30 Live sessions in CR 3</div>
                                                <div>10:30 - 10:45 Break</div>
                                                <div>10:45 - 12:00 Live sessions in CR 3</div>
                                                <div>08:30 - 09:00 Breakfast in CR 2A</div>
                                                <div>09:00 - 10:30 Live sessions in CR 3</div>
                                                <div>10:30 - 10:45 Break</div>
                                                <div>10:45 - 12:00 Live sessions in CR 3</div>
                                                <div>08:30 - 09:00 Breakfast in CR 2A</div>
                                                <div>09:00 - 10:30 Live sessions in CR 3</div>
                                                <div>10:30 - 10:45 Break</div>
                                                <div>10:45 - 12:00 Live sessions in CR 3</div>
                                            </div>
                                        </div-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#statusTable').DataTable({
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "ทั้งหมด"]
            ],
            'columnDefs': [{
                'targets': [1, 3], // column index (start from 0)
                'orderable': false, // set orderable false for selected columns
            }]
        });
        $('.dataTables_length').addClass('bs-select');
    });
</script>