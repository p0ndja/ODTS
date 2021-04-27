<?php
    require_once '../static/functions/connect.php';
    if (isset($_POST) && isLogin()) {
        $doc_id = (int) $_POST['doc_id'];
        $doc = new Document((int) $_POST['doc_id']);

        $new_status = (int) $_POST['status'];

        $current = (int) $_POST['current'];

        $all_state = $doc->getProperties("state");
        $all_state[$current]["status"] = $new_status;
        $all_state[$current]["update"] = time();
        $all_state[$current]["comment"] = empty($_POST['comment']) ? null : $_POST['comment'];
        if ($new_status == 9)
            $all_state["current"] = ++$current;
        $doc->setProperties("state", $all_state);
        $properties = json_encode($doc->properties());
        print_r($properties);

        if ($stmt = $conn -> prepare("UPDATE `document` SET properties = ? WHERE id = ?")) {
            $stmt->bind_param('si', $properties, $doc_id);
            if (!$stmt->execute()) {
                $_SESSION['swal_error'] = "พบข้อผิดพลาด";
                $_SESSION['swal_error_msg'] = ErrorMessage::DATABASE_QUERY;
            } else {
                $_SESSION['swal_success'] = "อัพเดทสถานะเอกสารสำเร็จ!";
            }
        } else {
            $_SESSION['error'] = ErrorMessage::DATABASE_ERROR;
        }
    }
?>