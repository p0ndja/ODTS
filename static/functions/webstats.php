<?php
    $wshost = "203.159.94.111";
    $wsuser = "pharmmd";
    $wspass = "22jbY$?*ZKXz^-a9X4ucrEgD";
    $wsdatabase = "pharmmd_webstats";
    $wsconn = mysqli_connect($wshost,$wsuser,$wspass,$wsdatabase); 
    mysqli_set_charset($wsconn, 'utf8');

    if(!$wsconn)  die('Could not connect: ' . mysqli_error($wsconn));
    
    date_default_timezone_set('Asia/Bangkok');
    $wsdate = date("Y-m-d",time());
    $wscurMonth = date("m",time());
    $wscurYear = date("Y",time());
    $db_table = $wsdate;

    function getIP() {
        if(!empty($_SERVER['HTTP_CLIENT_IP'])) return $_SERVER['HTTP_CLIENT_IP'];
        else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) return $_SERVER['HTTP_X_FORWARDED_FOR'];
        return $_SERVER['REMOTE_ADDR'];
    }

    $current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $referent = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "none";
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    function getOS() { 
    
        global $user_agent;
    
        $os_platform  = "Unknown OS Platform";
    
        $os_array     = array(
                                '/windows nt 10/i'      =>  'Windows 10',
                                '/windows nt 6.3/i'     =>  'Windows 8.1',
                                '/windows nt 6.2/i'     =>  'Windows 8',
                                '/windows nt 6.1/i'     =>  'Windows 7',
                                '/windows nt 6.0/i'     =>  'Windows Vista',
                                '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                                '/windows nt 5.1/i'     =>  'Windows XP',
                                '/windows xp/i'         =>  'Windows XP',
                                '/windows nt 5.0/i'     =>  'Windows 2000',
                                '/windows me/i'         =>  'Windows ME',
                                '/win98/i'              =>  'Windows 98',
                                '/win95/i'              =>  'Windows 95',
                                '/win16/i'              =>  'Windows 3.11',
                                '/macintosh|mac os x/i' =>  'Mac OS X',
                                '/mac_powerpc/i'        =>  'Mac OS 9',
                                '/linux/i'              =>  'Linux',
                                '/ubuntu/i'             =>  'Ubuntu',
                                '/iphone/i'             =>  'iPhone',
                                '/ipod/i'               =>  'iPod',
                                '/ipad/i'               =>  'iPad',
                                '/android/i'            =>  'Android',
                                '/blackberry/i'         =>  'BlackBerry',
                                '/webos/i'              =>  'Mobile'
                        );
    
        foreach ($os_array as $regex => $value)
            if (preg_match($regex, $user_agent))
                $os_platform = $value;
    
        return $os_platform;
    }
    
    function getBrowser() {
    
        global $user_agent;
    
        $browser        = "Unknown Browser";
    
        $browser_array = array(
                                '/msie/i'      => 'Internet Explorer',
                                '/firefox/i'   => 'Firefox',
                                '/safari/i'    => 'Safari',
                                '/chrome/i'    => 'Chrome',
                                '/edge/i'      => 'Edge',
                                '/opera/i'     => 'Opera',
                                '/netscape/i'  => 'Netscape',
                                '/maxthon/i'   => 'Maxthon',
                                '/konqueror/i' => 'Konqueror',
                                '/mobile/i'    => 'Mobile'
                            );
    
        foreach ($browser_array as $regex => $value)
            if (preg_match($regex, $user_agent))
                $browser = $value;
    
        return $browser;
    }
    
    $user_os        = getOS();
    $user_browser   = getBrowser();

    $log = array(
        'ip' => getIP(),
        'refer' => $referent,
        'os' => getOS(),
        'browser' => getBrowser(),
        'time' => date("Y-m-d h:i:s",time())
        );
        
    $r = "CREATE TABLE IF NOT EXISTS `$db_table`(
            id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            IP text NOT NULL,
            Target text,
            Refer text,
            OS text,
            Browser text,
            RawData text
        )";
    $q = mysqli_query($wsconn, $r);
    if (!$q) echo "There's an error on Webstats Database. [Can't Create Table]";

    $wsip = getIP(); $wstarget = $current_url; $wsrefer = $referent; $wsos = getOS(); $wsbrowser = getBrowser(); $wsraw = $user_agent;
    $r = "INSERT INTO `$db_table` (IP, Target, Refer, OS, Browser, RawData) VALUES ('$wsip', '$wstarget', '$wsrefer', '$wsos', '$wsbrowser', '$wsraw')";
    $q = mysqli_query($wsconn, $r);
    if (!$q) echo "There's an error on Webstats Database. [Can't Insert Stats]";

    

    $wstoday = mysqli_num_rows(mysqli_query($wsconn, "SELECT DISTINCT `ip` FROM `$wsdate`")); $_SESSION['wstoday'] = $wstoday;
    
    $r = "INSERT INTO `summary` (Date, Count) VALUES ('$db_table', '$wstoday') ON DUPLICATE KEY UPDATE Date=Date, Count=Count";
    $q = mysqli_query($wsconn, $r);
    if (!$q) echo "There's an error on Webstats Database. [Can't Update Summary]";

    $wsmonth = mysqli_num_rows(mysqli_query($wsconn, "SELECT * FROM `summary` WHERE date LIKE '%-$wscurMonth-%'")); $_SESSION['wsmonth'] = $wsmonth;
    $wsyear = mysqli_num_rows(mysqli_query($wsconn, "SELECT * FROM `summary` WHERE date LIKE '%$wscurYear%'")); $_SESSION['wsyear'] = $wsyear;
    $wstotal = mysqli_fetch_array(mysqli_query($wsconn, "SELECT SUM(Count) total FROM `summary`"), MYSQLI_ASSOC)['total']; $_SESSION['wstotal'] = $wstotal;
    
?>