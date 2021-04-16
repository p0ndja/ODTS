<?php declare(strict_types=1);

    require_once 'connect.php';
    require_once 'init.php';

    function latestIncrement($dbdatabase, $db) {
        global $conn;
        return mysqli_fetch_array(mysqli_query($conn,"SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$dbdatabase' AND TABLE_NAME = '$db'"), MYSQLI_ASSOC)["AUTO_INCREMENT"];
    }
    
    function make_directory($path) {
        $path = explode("/", $path);
        $stackPath = "";
        for ($i = 0; $i < count($path); $i++) {
            $stackPath .= $path[$i] . "/";
            if (file_exists($stackPath . $path[$i] . "/"))
                continue;
            mkdir($stackPath . $path[$i] . "/");
        }
        return file_exists($stackPath);
    }

    function login(String $username, String $password) {
        global $conn;
        if ($stmt = $conn->prepare("SELECT `id` FROM `user` WHERE username = ? AND password = ? LIMIT 1")) {
            $stmt->bind_param('ss', $username, $password);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    return new User((int) $row['id']);
                }
            }
        }
        return null;
    }

    function isLogin() {
        return isset($_SESSION['user']);
    }

    function beautiDate(int $time) {
        return ((int) date("d ", $time)) . " " . Event::MONTH[(int) date("m", $time) - 1] . " " . ((int) date(" Y ", $time) + 543) . date(" H:i", $time);
    }

    function isAdmin() {
        if (!isLogin()) return false;
        return $_SESSION['user']->isAdmin();
    }

    function getUserData(int $id) {
        global $conn;
        if ($stmt = $conn->prepare('SELECT * FROM `user` WHERE id = ?')) {
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    return $row;
                }
            }
        }
        return null;
    }

    function getDocumentData(int $id) {
        global $conn;
        if ($stmt = $conn->prepare('SELECT * FROM `document` WHERE id = ?')) {
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    return $row;
                }
            }
        }
        return null;
    }

    function isDarkmode() {
        if (isset($_SESSION['dark_mode']) && $_SESSION['dark_mode'] == true)
            return true;
        if (!isset($_SESSION['dark_mode']))
            $_SESSION['dark_mode'] = false;
        return false;
    }

    function isValidUserID($id) {
        global $conn;
        $query = "SELECT `id` FROM `user` WHERE id = '$id'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) return true;
        return false;
    }

    function isValidDocumentID($id) {
        global $conn;
        $query = "SELECT `id` FROM `document` WHERE id = '$id'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) return true;
        return false;
    }

    function state($state) {
        switch($state) {
            case 0:
                return Event::STATE_GET_REQUEST;
            case 1:
                return Event::STATE_HEAD_UNIT;
            case 2:
                return Event::STATE_HEAD_DEPARTMENT;
            case 3:
                return Event::STATE_HEAD_PHARMACY_DEPARTMENT;
            case 4:
                return Event::STATE_HEAD_HOSPITAL;
            case 5:
                return Event::STATE_FINAL;
            default:
                return "-";
        }
    }

    function state_status_image(int $state, int $status) {
        $s = "../static/elements/status/";
        //State 0
        if ($state == 0)
            return $s . $state . ".png";
        
        //State 1-5
        if ($status == -1 || $status == 1)
            return $s . $state . "_1.png";
        if ($status == 0)
            return $s . $state . ".png";
        return $s . $state . "_$status.png";
    }

    function status($status) {
        switch($status) {
            case -9:
                return Event::STATE_REJECT;
            case -1:
                return Event::STATE_RECHECK;
            case 0:
                return Event::STATE_WAIT;
            case 1:
                return Event::STATE_WORKING;
            case 9:
                return Event::STATE_DONE;
        }
    }

    function status_color(int $status) {
        switch($status) {
            case -9:
                return "danger";
            case 9:
                return "success";
            case -1:
                return "warning";
            case 0:
                return "warning";
            case 1:
                return "warning";
            default:
                return "light";
        }
    }

    function status_color_2(int $status) {
        if ($status == 9)
            return "green accent-1";
        if ($status == -1)
            return "orange lighten-4";
        if ($status == -9)
            return "red lighten-4";
        return "";
    }
?>
<?php
    function getClientIP() {
        if(!empty($_SERVER['HTTP_CLIENT_IP'])) return $_SERVER['HTTP_CLIENT_IP'];
        else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) return $_SERVER['HTTP_X_FORWARDED_FOR'];
        return $_SERVER['REMOTE_ADDR'];
    }

    function randomErrorMessage() {
        $message = array(
            "(╯°□°）╯︵ ┻━┻",
            "┬─┬ ノ( ゜-゜ノ)",
            "ლ(ಠ益ಠლ)",
            "¯\_(ツ)_/¯",
            "‎(ﾉಥ益ಥ）ﾉ ┻━┻",
            "┬┴┬┴┤(･_├┬┴┬┴",
            "ᕙ(⇀‸↼‶)ᕗ",
            "(づ｡◕‿‿◕｡)づ",
            "(ノ^_^)ノ┻━┻ ┬─┬ ノ( ^_^ノ)",
            "(⌐■_■)","─=≡Σ(([ ⊐•̀⌂•́]⊐",
            "(　-_･)σ - - - - - - - - ･",
            "┌( ಠ_ಠ)┘",
            "♪ (｡´＿●`)ﾉ┌iiii┐ヾ(´○＿`*) ♪",
            "ᕙ( ͡° ͜ʖ ͡°)ᕗ",
            "(ÒДÓױ)"
        );
        return $message[rand(0,count($message)-1)];
    }

    function path_curTime() {
        date_default_timezone_set('Asia/Bangkok'); return date('Y/m/d', time());
    }

    function unformat_curTime() {
        date_default_timezone_set('Asia/Bangkok'); return date('YmdHis', time());
    }

    function curDate() {
        date_default_timezone_set('Asia/Bangkok'); return date('Y-m-d', time());
    }

    function curTime() {
        date_default_timezone_set('Asia/Bangkok'); return date('H:i:s', time());
    }

    function curFullTime() {
        date_default_timezone_set('Asia/Bangkok'); return date('Y-m-d H:i:s', time());
    }

    function sendFileToIMGHost($file) {
        $data = array(
            'img' => new CURLFile($file['tmp_name'],$file['type'], $file['name']),
        ); 
        
        //**Note :CURLFile class will work if you have PHP version >= 5**
        
         $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, 'https://img.p0nd.ga/upload.php');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_TIMEOUT, 86400); // 1 Day Timeout
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60000);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_HOST']);
        
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            $msg = FALSE;
        } else {
            $msg = $response;
        }
        
        curl_close($ch);
        return $msg;
    }

    function generateRandom($length = 16) {
        $characters = md5((string) time());
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
?>

<?php
    function needLogin() {
    if (!isLogin()) {?>
<script>
    swal({
        title: "ACCESS DENIED",
        text: "You need to logged-in!",
        icon: "error"
    }).then(function () {
        <?php $_SESSION['error'] = "กรุณาเข้าสู่ระบบก่อนดำเนินการต่อ"; ?>
        window.location = "../login/";
    });
</script>
<?php die(); }} ?>

<?php
    function needAdmin($conn) {
    if (!isLogin()) { needLogin(); die(); return false; }
    if (!isAdmin($_SESSION['user']->getID(), $conn)) { ?>
<script>
    swal({
        title: "ACCESS DENIED",
        text: "You don't have enough permission!",
        icon: "warning"
    });
</script>
<?php die(); return false;}
        return true;
    }
?>
<?php function back() {
    if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    } else {
        home();
    }
    die();
    } ?>
<?php function home() {
    header("Location: ../home/");
} ?>
<?php function logout() { ?>
    <script>
        swal({
            title: "ออกจากระบบ ?",
            text: "คุณต้องการออกจากระบบหรือไม่?",
            icon: "warning",
            buttons: true,
            dangerMode: true}).then((willDelete) => {
                if (willDelete) {
                    window.location = "../logout/";
                }
            });
</script>
<?php } ?>

<?php function deletePost($id) { ?>
    <script>
        swal({
            title: "ลบข่าวหรือไม่ ?",
            text: "หลังจากที่ลบแล้ว ข่าวนี้จะไม่สามารถกู้คืนได้!",
            icon: "warning",
            buttons: true,
            dangerMode: true}).then((willDelete) => {
                if (willDelete) {
                    window.location = "../post/delete.php?id=<?php echo $id; ?>";
                }
            });
    </script>
<?php } ?>
<?php function warningSwal($title,$name) { ?>
    <script>
    swal({
        title: "<?php echo $title; ?>",
        text: "<?php echo $name; ?>",
        icon: "warning"
    });
    </script>
<?php } ?>
<?php function errorSwal($title,$name) { ?>
    <script>
    swal({
        title: "<?php echo $title; ?>",
        text: "<?php echo $name; ?>",
        icon: "error"
    });
    </script>
<?php } ?>
<?php function successSwal($title,$name) { ?>
    <script>
    swal({
        title: "<?php echo $title; ?>",
        text: "<?php echo $name; ?>",
        icon: "success"
    });
    </script>
<?php } ?>
<?php function debug($message) { echo $message; } ?>

<?php
    function startsWith($haystack, $needle) {
        return substr_compare($haystack, $needle, 0, strlen($needle)) === 0;
    }
    function endsWith($haystack, $needle) {
        return substr_compare($haystack, $needle, -strlen($needle)) === 0;
    }
    
    if (isLogin() && !isValidUserID($_SESSION['user']->getID(), $conn)) {
        session_destroy();
        header("Location: ../home/");
    }
?>
