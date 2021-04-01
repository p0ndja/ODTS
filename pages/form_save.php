<?php
    require_once '../static/functions/connect.php';
    if (isset($_POST['form_submit']) && isLogin()) {
        $flows = array();
        foreach($_POST['form_flow'] as $flow) {
            array_push($flows, (int) $flow);
        } unset($_POST['form_flow']);
        
        $_POST['flow'] = $flows;
        $_POST['upload_time'] = time();

        $id = isset($_GET['id']) ? (int) $_GET['id'] : -1;
        $obform = new Document($id);
        $data = json_encode($_POST);
        
        $obform->setProperties("owner", $_SESSION['user']->getID());
        //No need to update post properties, except owner data.
        $properties = json_encode($obform->properties()); 

        if ($id > 0) {
            if ($stmt = $conn -> prepare("UPDATE `document` SET data = ?, properties = ? WHERE id = ?")) {
                $stmt->bind_param('ssi', $data, $properties, $id);
                if (!$stmt->execute()) {
                    $_SESSION['swal_error'] = "พบข้อผิดพลาด";
                    $_SESSION['swal_error_msg'] = ErrorMessage::DATABASE_QUERY;
                } else {
                    $_SESSION['swal_success'] = "ส่งเอกสารสำเร็จ!";
                }
            } else {
                $_SESSION['error'] = ErrorMessage::DATABASE_ERROR;
            }
        } else {
            if ($stmt = $conn -> prepare("INSERT INTO `document` (data, properties) VALUES (?,?)")) {
                $stmt->bind_param('ss', $data, $properties);
                if (!$stmt->execute()) {
                    $_SESSION['swal_error'] = "พบข้อผิดพลาด";
                    $_SESSION['swal_error_msg'] = ErrorMessage::DATABASE_QUERY;
                } else {
                    $_SESSION['swal_success'] = "ส่งเอกสารสำเร็จ!";
                }
            } else {
                $_SESSION['error'] = ErrorMessage::DATABASE_ERROR;
            }
        }

        print_r($_POST);
        header("Location: ../status/");
    }
?>