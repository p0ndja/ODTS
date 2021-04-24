<?php if (!isLogin()) header("Location: ../login/"); ?>
<div class="container">
    <div class="card mt-5">
        <div class="card-body">
            <?php 
            $mode = isset($_GET['mode']) ? $_GET['mode'] : "me";
            $title = "รายการเอกสารที่ถูกยื่นเรื่องโดยคุณ";
            if ($mode == "all")
                $title = "รายการเอกสารทั้งหมด";
            else if ($mode == "task")
                $title = "รายการเอกสารที่รอดำเนินการโดยคุณ";
            ?>
            <h3 class="font-weight-bold text-center"><?php echo $title; ?></h3>
            <div class="table-responsive">
                <table class="table table-sm table-hover w-100 d-block d-md-table text-nowrap" id="statusTable">
                    <thead>
                        <tr>
                            <th scope="col">รหัสเอกสาร</th>
                            <th scope="col">เวลา</th>
                            <th scope="col">HN</th>
                            <th scope="col">สถานะ</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $html = "";
                        if ($stmt = $conn -> prepare("SELECT * FROM `document` WHERE JSON_EXTRACT(`properties`,'$.owner') = ? ORDER BY `id` DESC")) {
                            $sessionid = $_SESSION['user']->getID();
                            $stmt->bind_param("i", $sessionid);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $id = (int) $row['id'];

                                    $properties = json_decode($row['properties'], true);
                                    $owner = array_key_exists("owner", $properties) ? $properties["owner"] : "-";

                                    $data = json_decode($row['data'], true);
                                    $upload_time = array_key_exists("upload_time", $data) ? beautiDate($data["upload_time"]) : "Undefined";
                                    $patient_hn = array_key_exists("patientHN", $data) ? $data["patientHN"] : "Undefined";
                                    $flow = array_key_exists("flow", $data) ? $data['flow'] : array();

                                    $list_flow = array();
                                    $status = 9;
                                    foreach($flow as $f) {
                                        array_push($list_flow, $f);
                                        if ((int) $properties["state"][$f]["status"] != 9) {
                                            $status = $properties["state"][$f]["status"];
                                            break;
                                        }
                                    }

                                    $html .= "
                                    <tr class='".status_color_2($status)."' onclick='window.location=\"../status/$id\"'>
                                        <th data-order=$id scope='row'>".sprintf("%06d", (float) $id)."</th>
                                        <td>$upload_time</th>
                                        <td>$patient_hn</td>
                                        <td data-order='$status'>".status($status)."</td>
                                        <td><a><i class='fas fa-external-link-alt'></i></a></td>
                                    </tr>";
                                }
                                $stmt->free_result();
                                $stmt->close();  
                            }
                            echo $html;
                        }
                    ?>
                    </tbody>
                </table>
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
                'targets': [4], // column index (start from 0)
                'orderable': false, // set orderable false for selected columns
            }]
        });
        $('.dataTables_length').addClass('bs-select');
    });
</script>