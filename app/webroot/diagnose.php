<?php
/**
 *
 * @package		FPPlatformUltraPlus
 * @author 		amal_196at13
 * @copyright 	Copyright (c) 2012 {@link http://www.agriya.com/ Agriya Infoway}
 * @license		http://www.agriya.com/ Agriya Infoway Licence
 * @since 		2012-03-07
 **/
if (!defined('ROOT')) {
    define('ROOT', dirname(dirname(dirname(__FILE__))));
}
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
$app = ROOT . DS . 'app' . DS;
$webroot = $app . 'webroot';
$js = $app . 'webroot' . DS . 'js';
$css = $app . 'webroot' . DS . 'css';
$img = $app . 'webroot' . DS . 'img';
$tmp = $app . 'tmp';
$media = $app . 'media';
$config = $app . 'Config';
include '../Config/database.php';
$facebook_settings_id = 9;
$twitter_settings_id = 15;
$google_settings_id = 88;
$googleplus_settings_id = 115;
$yahoo_settings_id = 89;
$linkedin_settings_id = 91;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>FPPlatformUltraPlus - Diagnostic Tool</title>
<style type="text/css">
body{
	color:#4c4c4c;
	line-height:18px;
	font-size:12px;
	font-family:verdana;
}
/** table-list */
table.list,table.list td,table.list th {
	border:1px solid #e5e5e5;
}
table.topic-list td,table.topic-list th {
	border:none;
	border-bottom:1px solid #e5e5e5;
}
table.list, table.list-info {
	border-spacing:0;
	border-collapse:collapse;
	margin: 5px auto;
    width: 90%;
}
table.list td,table.list th {
    padding:6px 5px;
	border-width:1px;
	background-color:#fff;
	vertical-align:middle;
	font-size:12px;
    font-family:verdana;
}
table.list td{
	text-align: left;
}
table.list th {
	color:#36769C;
	background:#DCEDF2;
	text-align:left;
}
table.list th a {
	color:#36769C;
}
table.list th a:hover{
    text-decoration:none;
}
table.list tr.altrow td {
	background-color:#f0f7fe;
}
table.list tr:hover td {
	background-color:#EFFDFF;
}
table.list tr th.dl,table.list tr td.dl {
	text-align:left;
}
table.list tr th.deal-name,table.list tr td.deal-name {
	width:150px;
	white-space:wrap;
}
table.list tr th.dc,table.list tr td.dc {
	text-align:center;
}
table.list tr th.dr,table.list tr td.dr {
	text-align:right;
}
table.list tr.total-block td {
	background:#f0f8fe;
	font-weight:bold;
}
table.list tr td.deal-name,table.list tr th.deal-name {
	width:220px;
}
table.list tr td.green, table.list-info tr td.green {
	background:#91CE5F;
	color: white;
    font-size: 13px;
    font-weight: bold;
}
table.list tr td.red, table.list-info tr td.red {
	background:#ED6F75;
	color: white;
    font-size: 13px;
    font-weight: bold;
}
table.list tr td.yellow, table.list-info tr td.yellow {
	background:#F2F27D;
	color:#333333;
    font-size: 13px;
    font-weight: bold;
}
table.list tr td.orange, table.list-info tr td.orange  {
	background:#F7A33D;
	color: white;
    font-size: 13px;
    font-weight: bold;
}
table.list-info {
	float:right;
}
table.list-info tr td  {
	margin:0;
	padding:0 10px 0 5px;
	border-bottom:2px solid #e5e5e5;
	background-color:#fff;
	vertical-align:middle;
	font-size:12px;
  font-family:verdana;
	text-align:left;
}

table.list-info tr td.green, table.list-info tr td.red, table.list-info tr td.yellow, table.list-info tr td.orange, table.list-info tr td.orange {
	background:#91CE5F;
	width:20px;
	padding:0;
}
table.list-info tr td.red {
	background:#ED6F75;
}
table.list-info tr td.yellow {
	background:#F2F27D;
}
table.list tr td.orange, table.list-info tr td.orange  {
	background:#F7A33D;
}
div.list-info-block{
	float:right;
	width:625px;
}
div.top-block-left {
	float:left;
}
div.top-block{
	min-height:90px;
	overflow:hidden;
}
.info-details {
    background: url("img/icon-info-details.png") no-repeat scroll 10px center #F9F9F9;
    border: 1px dashed #e5e5e5;
    margin: 6px auto;
    padding: 15px 15px 15px 50px;
    width:85%;
}
.invalid_mail{
color:#C40000;
}
.green_req_details{
background:#52AF0A;
color:#FFFFFF;
}
.red_req_details{
    background:#DB3D47;
    color:#FFFFFF;
   padding:2px 0px;
}
.red_req_details h1{
    font-size:17px;
}
.orange_req_details{
background:#f68e08;
color:#FFFFFF;
}
.yellow_req_details{
background:#FAFA3D;
color:#000000;
}
.pay_gate_req{
width:500px;
background-color:#DB3D47;
color:#FFFFFF;
}
.cred_detail {
background:#F2F27D;
color:#000000;
text-align:center;
}
h1{
     font-size: 22px !important;
}
div#final_verdict h1{
     font-size:18px !important;
}

</style>
</head>
<?php
$req_not_met = 0;
$req_not_met_pre = 0;
$req_not_met_no_man = 0;
$req_met_unable_check = 0;
$master_db = _db_check('master',$facebook_settings_id,$twitter_settings_id,$google_settings_id,$googleplus_settings_id,$yahoo_settings_id,$linkedin_settings_id);
$default_db = _db_check('default',$facebook_settings_id,$twitter_settings_id,$google_settings_id,$googleplus_settings_id,$yahoo_settings_id,$linkedin_settings_id);
$_writable_folders = array(
    $tmp,
    $media,
    $css,
    $js,
    $img,
    ROOT . DS . 'core' . DS . 'vendors' . DS . 'securimage'
);
$out = '';
foreach($_writable_folders as $folder) {
    if (_is_writable_recursive($folder)) {
        $out.= '<tr><td> ' . $folder . '</td><td class="green">Writable</td></tr>';
    } else {
        $out.= '<tr><td>' . $folder . '</td><td class="red">Not Writable</td></tr>';
        $req_not_met = 1;
    }
}
$_writable_files = array(
	$webroot,
    $config,
    $app . 'Console' . DS . 'Command' . DS . 'cron.sh',
    $app . 'Console' . DS . 'Command' . DS . 'CronShell.php',
    ROOT . DS . 'core' . DS . 'lib' . DS . 'Cake' . DS . 'Console' . DS . 'cake'
);
foreach($_writable_files as $file) {
    if (is_writable($file)) {
        $out.= '<tr><td> ' . $file . '</td><td class="green">Writable</td></tr>';
    } else {
        $out.= '<tr><td>' . $file . '</td><td class="red">Not Writable</td></tr>';
        $req_not_met = 1;
    }
}
$tmpCacheFileSize = bytes_to_higher(dskspace($tmp . 'cache'));
$tmpLogsFileSize = bytes_to_higher(dskspace($tmp . 'logs'));
$writable = $out;
?>
<?php
//---------------- Default table -------------------------------------------------------
function _db_check($database = 'default',$facebook_settings_id,$twitter_settings_id,$google_settings_id,$googleplus_settings_id,$yahoo_settings_id,$linkedin_settings_id)
{
    $db_config_obj = new DATABASE_CONFIG;
    $db_info = array();
    $db_data = $db_config_obj->$database;
    $hostname = $db_data['host'];
    $username = $db_data['login'];
    $password = $db_data['password'];
    $database = $db_data['database'];
    $link = @mysql_connect($hostname, $username, $password);
    if ($link) {
        $db_info['db_connection'] = 'Connected';
        $db_selected = @mysql_select_db($database, $link);
        if ($db_selected) {
			$db_info['db_connect_status'] = true;
            $db_info['db_connect'] = $database;
            //------------------Site Admin Mail------------------------
            $admin_mail = '';
            $result_admin_email = mysql_query("select * from settings where name ='EmailTemplate.admin_email'", $link);
            if (!$result_admin_email) {
                echo $db_info['admin_mail']['error'] = mysql_error();
            } else {
                if ($row_admin_email = mysql_fetch_assoc($result_admin_email)) {
                    $db_info['admin_mail']['value'] = $row_admin_email['value'];
                }
            }

            // ----------payment Gateway info get ------------------------------
            $result = mysql_query("select * from payment_gateways", $link);
            $db_info['payment_gateway']['error'] = 'None';
            if (!$result) {
                echo $db_info['payment_gateway']['error'] = mysql_error();
            } else {
                while ($row = mysql_fetch_assoc($result)) {
                    $db_info['payment_gateway']['gateway'][] = $row;
                }
            }
            // ----------payment Gateway info get ------------------------------
            // ----------payment Gateway setting  info get ------------------------------
            $result = mysql_query("SELECT payment_gateways.display_name, payment_gateways.is_test_mode, payment_gateways.is_active, payment_gateway_settings.id, payment_gateway_settings.payment_gateway_id, payment_gateway_settings.name, payment_gateway_settings.test_mode_value, payment_gateway_settings.live_mode_value  FROM payment_gateways, payment_gateway_settings WHERE payment_gateways.id = payment_gateway_settings.payment_gateway_id", $link);
            $db_info['payment_gateway']['error'] = 'None';
            if (!$result) {
                echo $db_info['payment_gateway']['error'] = mysql_error();
            } else {
                while ($row = mysql_fetch_assoc($result)) {
                    $db_info['payment_gateway']['gateway_settings'][] = $row;
                }
            }
            foreach($db_info['payment_gateway']['gateway'] as $key => &$gateway) {
                foreach($db_info['payment_gateway']['gateway_settings'] as &$settings) {
                    if ($gateway['id'] == $settings['payment_gateway_id']) {
                        if ($settings['name'] != 'is_enable_for_add_to_wallet' && $settings['name'] != 'is_enable_for_project' && $settings['name'] != 'is_enable_for_signup' && $settings['name'] != 'is_enable_for_pledge' && $settings['name'] != 'is_enable_for_donate') {
                            $db_info['payment_gateway']['gateway'][$key]['settings'][] = $settings;
                        } else {
                            $db_info['payment_gateway']['gateway'][$key][$settings['name']] = $settings['test_mode_value'];
                        }
                    }
                }
            }
            $result = mysql_query("select * from settings where setting_category_parent_id in (1,2,38)", $link);
            $db_info['payment_gateway']['error'] = 'None';
            if (!$result) {
                echo $db_info['payment_gateway']['error'] = mysql_error();
            } else {
                $db_info['settings'][$linkedin_settings_id] = $db_info['settings'][$yahoo_settings_id] =$db_info['settings'][$google_settings_id] = $db_info['settings'][$googleplus_settings_id] = $db_info['settings'][$twitter_settings_id] = $db_info['settings'][$facebook_settings_id] = array(
                    'Mandatory' => array() ,
                    'Credentials' => array() ,
                    'Not Mandatory' => array()
                );
                $mandatory = array(
                    'facebook.fb_app_id',
                    'facebook.fb_secrect_key',
					'facebook.page_id',
					'facebook.site_facebook_url',
					'facebook.fb_access_token',
					'facebook.fb_user_id',
                    'twitter.consumer_key',
                    'twitter.consumer_secret',
                    'twitter.site_user_access_key',
                    'twitter.site_user_access_token',
					'google.consumer_key',
					'google.consumer_secret',
					'googleplus.consumer_key',
					'googleplus.consumer_secret',
					'yahoo.consumer_key',
					'yahoo.consumer_secret',
					'linkedin.consumer_key',
					'linkedin.consumer_secret',
                );
                $site_settings = array(
					'EmailTemplate.admin_email'
                );
                $site_name = array(
                    'site.name'
                );
                while ($row = mysql_fetch_assoc($result)) {
                    if (in_array($row['name'], $mandatory)) {
                        $db_info['settings'][$row['setting_category_id']]['Mandatory'][] = array(
							'name' => $row['name'],
                            'label' => $row['label'],
                            'value' => $row['value']
                        );
                    } elseif (in_array($row['name'], $site_settings)) {
                        $db_info['settings']['sitesettings']['site_setting'][] = array(
							'name' => $row['name'],
                            'label' => $row['label'],
                            'value' => $row['value']
                        );
                    } elseif ($row['setting_category_id'] == $facebook_settings_id || $row['setting_category_id'] == $twitter_settings_id || $row['setting_category_id'] == $google_settings_id || $row['setting_category_id'] == $googleplus_settings_id || $row['setting_category_id'] == $yahoo_settings_id || $row['setting_category_id'] == $linkedin_settings_id) {
                        $db_info['settings'][$row['setting_category_id']]['Mandatory'][] = array(
							'name' => $row['name'],
                            'label' => $row['label'],
                            'value' => $row['value']
                        );
                    } elseif (in_array($row['name'], $site_name)) {
                        $db_info['settings']['site'][] = $row['value'];
                    }
                }
				sort($db_info['settings'][$facebook_settings_id]['Mandatory']);
				sort($db_info['settings'][$twitter_settings_id]['Mandatory']);
				sort($db_info['settings'][$google_settings_id]['Mandatory']);
				sort($db_info['settings'][$googleplus_settings_id]['Mandatory']);
				sort($db_info['settings'][$yahoo_settings_id]['Mandatory']);
				sort($db_info['settings'][$linkedin_settings_id]['Mandatory']);
            }
            // ----------payment Gateway info get ------------------------------

        } else {
			$db_info['db_connect_status'] = false;
            $db_info['db_connect'] = mysql_error();
        }
        mysql_close($link);
    } else {
        $db_info['db_connection'] = mysql_error();
    }
	if (in_array('mysql', PDO::getAvailableDrivers())) {
		try {
			$dbh = new PDO('mysql:host=' . $hostname . ';dbname=' . $database, $username, $password);
			$sth = $dbh->query('SELECT * FROM users');
			if (!array_key_exists('table', $sth->getColumnMeta(0))) {
				$db_info['pdo_install_error'] = 'The installed PDO has problem as mentioned in http://ask.cakephp.org/questions/view/model_name_not_returned_from_controller_to_view' . "\n" . 'There is no workaround through coding; so please get the PDO installed as mentioned in the link.';
			}
		}
		catch(PDOException $e) {
			$db_info['pdo_install_error'] = 'Error!: ' . $e->getMessage();
		}
	}
    return $db_info;
}
//---------------- Default table -------------------------------------------------------
// Reference: http://www.izzycode.com/php/php-function-get-atomic-time.html
function GetAtomicTime()
{
    // Get time server list ...
    $atomic_time_server_content = file_get_contents('http://tf.nist.gov/tf-cgi/servers.cgi');
    preg_match_all('/<table[^>]*>(.*?)<\/table>/si', $atomic_time_server_content, $matches);
    // Only the 3rd table has info...
    $atomic_time_server_table = $matches[0][2];
    preg_match_all('/<td[^>]*>((?:<td.+?<\/td|.)*?)\s*<\/td>/si', $atomic_time_server_table, $matches);
    // take only "Up" server IPs...
    $server_ips = array();
    for ($i = 5, $len = count($matches[1]); $i < $len; $i+= 4) {
        if (strpos($matches[1][$i+2], 'All services available') !== false) {
            $server_ips[] = $matches[1][$i];
        }
    }
    // Look up in any "Up" server, if it fails, try one by one...
    for ($i = 0, $len = count($server_ips) , $is_server_responds = false; !$is_server_responds && ($i < $len); ++$i) {
        $fp = fsockopen($server_ips[$i], 37);
        if ($fp) {
            fputs($fp, "\n");
            $timevalue = fread($fp, 49);
            fclose($fp);
            $is_server_responds = true;
            // debug...
               }
    }
    $atomic_time = (abs(hexdec('7fffffff') -hexdec(bin2hex($timevalue)) -hexdec('7fffffff')) -2208988800);
    return $atomic_time;
}
//---------------------
function _is_writable_recursive($dir)
{
    if (!($folder = @opendir($dir))) {
        return false;
    }
    while ($file = readdir($folder)) {
        if ($file != '.' && $file != '..' && $file != '.svn' && (!is_writable($dir . DS . $file) || (is_dir($dir . DS . $file) && !_is_writable_recursive($dir . DS . $file)))) {
            closedir($folder);
            return false;
        }
    }
    closedir($folder);
    return true;
}
function _dskspace($dir)
{
    $s = @stat($dir);
    $space = $s['blocks']*512;
    if ($space < 0) { //Windows?
        $space = filesize($dir);
    }
    if (is_dir($dir)) {
        $dh = opendir($dir);
        while (($file = readdir($dh)) !== false) {
            if ($file != '.' and $file != '..') {
                $space+= _dskspace($dir . '/' . $file);
            }
        }
        closedir($dh);
    }
    return $space;
}
function dskspace($dir)
{
    // http://www.php.net/manual/en/function.disk-total-space.php#72324
    if ($output = exec('du -sk ' . $dir)) {
        preg_match('/\d+/', $output, $size_in_kb);
        return $size_in_kb[0]*1024;
    } else {
        return _dskspace($dir);
    }
}
// Bytes to highest unit conversion
function bytes_to_higher($bytes)
{
    $symbols = array(
        'B',
        'KB',
        'MB',
        'GB',
        'TB',
        'PB',
        'EB',
        'ZB',
        'YB'
    );
    $exp = floor(log($bytes) /log(1024));
    return sprintf('%.2f ' . $symbols[$exp], ($bytes ? ($bytes/pow(1024, floor($exp))) : 0));
}
?>

<body>

<?php
////////////Post Facebook//////////////////////
$fb_check = '';
if (isset($_GET['action']) && $_GET['action'] == 'post' && $_GET['to'] != '' && $_GET['to'] == 'facebook') {
    if (!empty($master_db['settings'][$facebook_settings_id]['Mandatory'][0]['value']) && !empty($master_db['settings'][$facebook_settings_id]['Mandatory'][2]['value']) && !empty($master_db['settings'][$facebook_settings_id]['Mandatory'][3]['value']) && !empty($master_db['settings'][$facebook_settings_id]['Mandatory'][5]['value'])) {
        $site = $master_db['settings']['site'][0];
        $app_id = $master_db['settings'][$facebook_settings_id]['Mandatory'][2]['value'];
        $secret_key = $master_db['settings'][$facebook_settings_id]['Mandatory'][3]['value'];
        $fb_access_token = $master_db['settings'][$facebook_settings_id]['Mandatory'][0]['value'];
        $fb_page_id = $master_db['settings'][$facebook_settings_id]['Mandatory'][5]['value'];
        $message = 'This is the test post from ' . $site . ' - Facebook';
        include_once '../vendors/facebook/facebook.php';
        $facebook = new Facebook(array(
            'appId' => $app_id,
            'secret' => $secret_key,
            'cookie' => true
        ));
        try {
            $url = "http://" . $_SERVER['SERVER_NAME'];
            $facebook->api('/' . $fb_page_id . '/feed', 'POST', array(
                'access_token' => $fb_access_token,
                'message' => $message,
                'picture' => '',
                'icon' => '',
                'link' => $url,
                'caption' => $_SERVER['SERVER_NAME'],
                'description' => $_SERVER['SERVER_NAME']
            ));
            $fb_check = 'Successfully posted on facebook wall';
        }
        catch(Exception $e) {
            $fb_check = 'Post on facebook error - ' . $e;
        }
    } else {
        $fb_check = 'Facebook API values should not be empty';
    }
}
////////////Post Facebook ends////////////////
////////////Post twitter//////////////////////
$twit_check = '';
if (isset($_GET['action']) && $_GET['action'] == 'post' && $_GET['to'] != '' && $_GET['to'] == 'twitter') {
    if (!empty($master_db['settings'][$twitter_settings_id]['Mandatory'][0]['value']) && !empty($master_db['settings'][$twitter_settings_id]['Mandatory'][1]['value']) && !empty($master_db['settings'][$twitter_settings_id]['Mandatory'][2]['value']) && !empty($master_db['settings'][$twitter_settings_id]['Mandatory'][3]['value'])) {
        function post_tweet($tweet_text, $master_db, $twitter_settings_id)
        {
            // Set the authorization values
            // In keeping with the OAuth tradition of maximum confusion,
            // the names of some of these values are different from the Twitter Dev interface
            // user_token is called Access Token on the Dev site
            // user_secret is called Access Token Secret on the Dev site
            $connection = new tmhOAuth(array(
                'consumer_key' => $master_db['settings'][$twitter_settings_id]['Mandatory'][0]['value'],
                'consumer_secret' => $master_db['settings'][$twitter_settings_id]['Mandatory'][1]['value'],
                'user_token' => $master_db['settings'][$twitter_settings_id]['Mandatory'][3]['value'],
                'user_secret' => $master_db['settings'][$twitter_settings_id]['Mandatory'][2]['value'],
            ));
            // Make the API call
            $connection->request('POST', $connection->url('1/statuses/update') , array(
                'status' => $tweet_text
            ));
            return $connection->response['code'];
        }
        $site = $master_db['settings']['site'][0];
        $tweet_text = 'This is the test post from ' . $site . ' - Twitter on ' . date('h:i:s A', time());
        $result = post_tweet($tweet_text, $master_db, $twitter_settings_id);
        if ($result == 200) {
            $twit_check = 'Successfully posted on twitter';
        } else {
            $twit_check = 'Post on twitter error - ' . $result;
        }
    } else {
        $twit_check = 'Twitter API values should not be empty';
    }
}
////////////Post twitter ends//////////////////////
////////////Mail work status//////////////////////
$email_check = '';
if (isset($_GET['action']) && $_GET['action'] == 'email' && $_GET['to'] != '') {
    $site = $master_db['settings']['site'][0];
    if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $_GET['to'])) {
        $email_check = "<div class='invalid_mail'>Invalid email</div>";
    } else {
        $to = $_GET['to'];
        $subject = 'Important: ' . $site . ' Test Email';
        $body = 'This is the test email from ' . $site . '. If you receive this email, your server is more likely working fine.';
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers.= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
        // More headers
        $headers.= 'From: ' . $site . ' <' . $to . '>' . "\r\n";
        if (@mail($to, $subject, $body, $headers)) {
            $email_check = "Staus: Email is working";
        } else {
            $email_check = "Staus: Email is not working";
        }
    }
}
////////////Mail work status ends//////////////////////

?>
<?php
if (!empty($fb_check)) { ?><center><h2><?php
    echo $fb_check . '<br><a href="' . $_SERVER['PHP_SELF'] . '#fb">Back</a>'; ?></h2></center><?php
} ?>
<?php
if (!empty($twit_check)) { ?><center><h2><?php
    echo $twit_check . '<br><a href="' . $_SERVER['PHP_SELF'] . '#tweet">Back</a>'; ?></h2></center><?php
} ?>
<?php
if (!empty($email_check)) { ?><center><h2><?php
    echo $email_check . '<br><a href="' . $_SERVER['PHP_SELF'] . '#mail">Back</a>'; ?></h2></center><?php
} ?>
<!-- ///////////////////////////////////////////////////////////////// html content ///////////////////////////////////////////////////////////////////////////////////////////////////// -->
<div class="top-block">
<div class="top-block-left">
<h1>FPPlatformUltraPlus Diagnostic Tool</h1>
<em>This tool will check server and software configuration</em> &nbsp;&nbsp;<a href="#final_verdict">Final Verdict</a>
<h2> Step 1: Checking Server Requirements... </h2>
</div>
<div class="list-info-block">

<table class="list-info">
  <tr>
    <td class="green">&nbsp;</td>
    <td> - Requirement Met!</td>
    <td class="red">&nbsp;</td>
    <td > - Requirement not met. <b>Need to fix!</b></td>
  </tr>
  <tr>
    <td class="orange">&nbsp;</td>
    <td> - Requirement met, but, unable to check exact version.</td>
    <td class="yellow">&nbsp;</td>
    <td> - Requirement not met, but, its not madatory.</td>
  </tr>
</table>
</div>
</div>

<table border="2" class="list">

  <tr>
    <th colspan="2"> Settings </th>
    <th> Required Server Settings </th>
    <th> Current  Server Settings </th>
  </tr>
  <tr>
	<th colspan="4">
    	 Mandatory
    </th>
</tr>
<?php
$php_version = PHP_VERSION;
$php_version = explode('.', $php_version);
$class = 'class="red"';
if (5 == $php_version[0] && ((2 == $php_version[1] && $php_version[2] >= 7) || (3 == $php_version[1] && $php_version[2] <= 8))) {
    $class = 'class="green"';
} else {
    $req_not_met = 1;
    $req_not_met_pre = 1;
}
?>
  <tr>
    <td colspan="2"> PHP Version </td>
    <td>
<p>5.2.7+ (preferably 5.3.5)</p>
		</td>
    <td <?php
echo $class; ?>> <?php
echo PHP_VERSION; ?>	</td>
  </tr>
<?php
$class = 'class="red"';
if (function_exists('mysql_get_client_info')) {
    $sql_version = mysql_get_client_info();
    $php_version = explode('.', $sql_version);
    if (5 <= $php_version[0]) {
        $class = 'class="green"';
    } else {
        $requird.= "<li> MySQL Version Should be 5.x </li>";
        $req_not_met = 1;
        $req_not_met_pre = 1;
    }
} else {
    $sql_version = "-";
    $req_not_met = 1;
    $req_not_met_pre = 1;
}
?>
  <tr>
    <td colspan="2"> MySQL Version </td>
    <td> 5.x </td>
     <td <?php
echo $class; ?>> <?php
echo $sql_version; ?>		</td>
  </tr>
<?php
if (function_exists('get_extension_funcs')) {
    if (get_extension_funcs('gd')) {
        $gd_info = gd_info();
        $gd_version = explode(' ', $gd_info['GD Version']);
        $gd_version = str_replace("(", "", $gd_version[1]);
        $gd_version = explode('.', $gd_version);
        if ($gd_version[0] >= 2) {
            $class = 'class="green"';
        } else {
            $requird.= "<li> PHP Extension GD Version should be need  2.x </li>";
            $req_not_met = 1;
            $req_not_met_pre = 1;
        }
        $gd_version = $gd_info['GD Version'];
    } else {
        $gd_version = " Not Installed";
        $req_not_met = 1;
        $req_not_met_pre = 1;
    }
}
?>
  <tr>
    <td rowspan="6"> Extensions </td>
    <td> GD </td>
    <td> GD Version - 2.x+ </td>
    <td <?php
echo $class; ?>> <?php
echo $gd_version; ?> </td>
  </tr>
<?php
$class = 'class="red"';
if (function_exists('get_extension_funcs')) {
    if (get_extension_funcs('pcre')) {
        $pcre_version = PCRE_VERSION;
        $pcre_versions = explode('.', $pcre_version);
        if (7 <= $pcre_versions[0]) {
            $class = 'class="green"';
        } else {
            $requird.= "<li> PHP Extension PCRE Version should be need  7.x </li>";
            $req_not_met = 1;
            $req_not_met_pre = 1;
        }
    } else {
        $pcre_version = "Not Installed";
        $req_not_met = 1;
        $req_not_met_pre = 1;
    }
}
?>
  <tr>
    <td> PCRE </td>
    <td>  PCRE Version - 7.x+ </td>
    <td <?php
echo $class; ?>><?php
echo $pcre_version;
?></td>
  </tr>
<?php
$class = 'class="red"';
if (function_exists('get_extension_funcs')) {
    if (get_extension_funcs('curl')) {
        $curl_info = curl_version();
        $curl_infos = explode('.', $curl_info['version']);
        if (7 <= $curl_infos[0]) {
            $curl_info = $curl_info['version'];
            $class = 'class="green"';
        } else {
            $requird.= "<li> PHP Extension CURL Version should be need  7.x </li>";
            $req_not_met = 1;
            $req_not_met_pre = 1;
        }
    } else {
        $requird.= "<li> PHP Extension CURL Version should be need  7.x </li>";
        $curl_info = "Not Installed";
        $req_not_met = 1;
        $req_not_met_pre = 1;
    }
}
?>
  <tr>
    <td> CURL </td>
    <td> CURL version - 7.x+ </td>
    <td <?php
echo $class; ?>><?php
echo $curl_info; ?></td>
  </tr>
<?php
$class = 'class="red"';
if (function_exists('get_extension_funcs')) {
    if (get_extension_funcs('json')) {
        $class = 'class="orange"';
        $json_info = "Installed [don't know version]";
        $req_met_unable_check = 1;
    } else {
        $json_info = "Not Installed";
        $requird.= "<li> PHP Extension JSON Version should be need  1.x </li>";
        $req_not_met = 1;
        $req_not_met_pre = 1;
    }
}
?>
  <tr >
    <td> JSON </td>
    <td> json version - 1.x+ </td>
    <td <?php
echo $class; ?>> <?php
echo $json_info; ?>   </td>
  </tr>
<?php
if (in_array('mysql', PDO::getAvailableDrivers())) {
    if (!empty($master_db['pdo_install_error'])) {
		$pdo_info = $master_db['pdo_install_error'];
		$class = 'class="red"';
	} else {
		$pdo_info = "Enabled";
		$class = 'class="green"';
	}
} else {
    $pdo_info = "Disabled";
    $class = 'class="red"';
}
?>
  <tr >
    <td> PDO </td>
    <td> <?php
echo $pdo_info; ?> </td>
    <td <?php
echo $class; ?>> <?php
echo $pdo_info; ?>   </td>
  </tr>

 <?php
if (function_exists('imagettftext')) {
    $pdo_info = "Yes";
    $class = 'class="green"';
} else {
    $pdo_info = "No";
    $class = 'class="red"';
}
?>
  <tr >
    <td> GD with TrueType fonts support </td>
    <td>Yes </td>
    <td <?php
echo $class; ?>> <?php
echo $pdo_info; ?>   </td>
  </tr>
<?php
$class = 'class="red"';
if (function_exists('ini_get')) {
    $memory_limit = ini_get('memory_limit');
    $memory_limits = str_replace("M", "", $memory_limit);
    if ($memory_limits >= 32 && $memory_limits < 128) {
        $class = 'class="orange"';
        $req_met_unable_check = 1;
    } elseif ($memory_limits >= 128) {
        $class = 'class="green"';
    } else {
        $requird.= "<li> php.ini settings Memory Limit should be minimum 32M</li>";
        $req_not_met = 1;
        $req_not_met_pre = 1;
    }
} else {
    $memory_limit = '[don\'t know memory_limit]';
    $req_not_met = 1;
    $req_not_met_pre = 1;
}
?>
  <tr>
  	<td rowspan="3"> php.ini settings </td>
    <td> memory_limit </td>
    <td> 128M </td>
    <td <?php
echo $class; ?>>
    	<?php
echo $memory_limit; ?>
    </td>
  </tr>
<?php
$class = 'class="red"';
if (function_exists('ini_get')) {
    if (ini_get('safe_mode')) {
        $safe_mode = "ON";
        $req_not_met = 1;
        $req_not_met_pre = 1;
    } else {
        $class = 'class="green"';
        $safe_mode = "OFF";
    }
} else {
    $class = 'class="orange"';
    $safe_mode = '[don\'t know safe_mode status]';
    $req_met_unable_check = 1;
}
?>
  <tr>
    <td> safe_mode </td>
    <td> OFF </td>
    <td <?php
echo $class; ?>>
    	<?php
echo $safe_mode; ?>
    </td>
  </tr>
<?php
$class = 'class="red"';
if (function_exists('ini_get')) {
    if (ini_get('open_basedir')) {
        $open_basedir = ini_get('open_basedir');
        $req_not_met = 1;
        $req_not_met_pre = 1;
    } else {
        $class = 'class="green"';
        $open_basedir = "No Value";
    }
} else {
    $class = 'class="orange"';
    $open_basedir = '[don\'t know open_basedir status]';
    $req_met_unable_check = 1;
}
?>
  <tr>
    <td> open_basedir </td>
    <td> No Value </td>
     <td <?php
echo $class; ?>>
    	<?php
echo $open_basedir; ?>
    </td>
  </tr>
<?php
$class = 'class="red"';
if (function_exists('apache_get_version')) {
    $apace_version = apache_get_version();
    $apace_version_info = explode(" ", $apace_version);
    $apace_version_info = explode('/', $apace_version_info[0]);
    $apace_version_info = explode('.', $apace_version_info[1]);
    if ($apace_version_info[0] >= 2) $class = 'class="green"';
    else if ($apace_version_info[0] == 1) $class = 'class="orange"';
    $req_met_unable_check = 1;
} else {
    $version = explode(" ", $_SERVER["SERVER_SOFTWARE"], 3);
    $apace_version_info = explode('/', $version[0]);
    $apace_version_info = explode('.', $apace_version_info[1]);
    if ($apace_version_info[0] >= 2) $class = 'class="green"';
    else if ($apace_version_info[0] == 1) $class = 'class="orange"';
    $req_met_unable_check = 1;
    $apace_version = $version[0];
}
?>
  <tr>
    <td colspan="2">Apache  </td>
    <td> 1+ (preferably 2+) </td>
    <td <?php
echo $class; ?>>
    	<?php
echo $apace_version; ?>
    </td>
  </tr>

<?php
if (function_exists('apache_get_modules')) {
    $modules = apache_get_modules();
    $class = 'class="red"';
    if (in_array("mod_rewrite", $modules)) {
        $class = 'class="green"';
        $mod_rewrite = "Loaded";
    } else {
        $mod_rewrite = "Not Loaded";
        $req_not_met = 1;
        $req_not_met_pre = 1;
    }
?>
 <tr>
    <td rowspan="1"> Loaded  Modules </td>
    <td> mod_rewrite </td>
    <td> load </td>
    <td <?php
    echo $class; ?>> <?php
    echo $mod_rewrite; ?> </td>
  </tr>

<?php
}
?>
<tr>
	<th colspan="4">
    	Not Mandatory
    </th>
</tr>
<?php
$class = 'class="green"';
if (function_exists('ini_get')) {
    $max_execution_time = ini_get('max_execution_time');
    if ($max_execution_time < 180) {
        $class = 'class="yellow"';
        $req_not_met_no_man = 1;
    }
} else {
    $max_execution_time = '[don\'t know max_execution_time]';
}
?>
  <tr>
    <td rowspan="2"> php.ini settings </td>
    <td> max_execution_time (not mandatory)</td>
    <td> 180  </td>
    <td <?php
echo $class; ?>>
    	<?php
echo $max_execution_time; ?>
    </td>
  </tr>
<?php
$class = 'class="green"';
if (function_exists('ini_get')) {
    $max_input_time = ini_get('max_input_time');
    if ($max_input_time < 6000) {
        $class = 'class="yellow"';
        $req_not_met_no_man = 1;
    }
} else {
    $max_input_time = '[don\'t know max_input_time]';
}
?>
  <tr>
    <td> max_input_time (not mandatory)</td>
    <td> 6000  </td>
    <td <?php
echo $class; ?>>
    	<?php
echo $max_input_time; ?>
    </td>
  </tr>

<?php
if (function_exists('apache_get_modules')) {
?>

<?php
    $class = 'class="yellow"';
    if (in_array("mod_deflate", $modules)) {
        $class = 'class="green"';
        $mod_deflate = "Loaded";
    } else {
        $class = 'class="yellow"';
        $mod_deflate = "Not Loaded";
        $req_not_met_no_man = 1;
    }
?>
  <tr>
  	<td rowspan="2"> Loaded  Modules </td>
    <td> mod_deflate (not mandatory, but highly recommended for better performance - gzip) </td>
    <td> load </td>
    <td <?php
    echo $class; ?>><?php
    echo $mod_deflate; ?></td>
  </tr>
<?php
    $class = 'class="yellow"';
    if (in_array("mod_rewrite", $modules)) {
        $class = 'class="green"';
        $mod_rewrite = "Loaded";
    } else {
        $mod_rewrite = "Not Loaded";
        $req_not_met_no_man = 1;
    }
?>
  <tr >
    <td> mod_expires (not mandatory, but highly recommended for better performance - browser caching)</td>
    <td> load </td>
    <td <?php
    echo $class; ?>><?php
    echo $mod_rewrite; ?></td>
  </tr>
<?php
}
?>

</table>
<?php
$pre_launch_mode_flag = 0;
if ($req_not_met_pre == 1) {
    $pre_launch_mode_flag = 1;
}
?>
<p class="info-details">
	<span> Note: </span>
    <span> If any of the above settings are displayed 'Red'. It means, your current server settings are not compatable for the site. Contact your service provider at once. </span>
</p>
<h2>Step 2: Checking File Permissions...</h2>
<table border="2" class="list">
<tr>
    <th> Folders</th>
    <th> Permissions</th>
</tr>
<?php
echo $writable; ?>
</table>

<p class="info-details">
	<span> Note: </span>
    <span>
		The above folders need to be writable (Have to chmod to 655 or 755 or 775 depending upon the server configuration. Note: 777 is highly discouraged).
		<br/>For more info: <a href="http://dev1products.dev.agriya.com/doku.php?id=fpplatformultraplus-install#setting_up_files" target="_blank">http://dev1products.dev.agriya.com/doku.php?id=fpplatformultraplus-install#setting_up_files</a>
	</span>
</p>

<h2>Step 3: Checking Database Setting...</h2>
<table width="500" border="2" class="list">
  <tr>
    <th>&nbsp;</th>
    <th>Master</th>
    <th>Default</th>
  </tr>
  <tr>
    <td>MySql Connect</td>
    <td class="<?php
echo ($master_db['db_connection'] == 'Connected') ? 'green' : 'red'; ?>"><?php
echo $master_db['db_connection'];
if ($master_db['db_connection'] != 'Connected') {
    $req_not_met = 1;
} ?></td>
    <td class="<?php
echo ($default_db['db_connection'] == 'Connected') ? 'green' : 'red'; ?>"><?php
echo $default_db['db_connection']; ?></td>
  </tr>
  <tr>
    <td>Connect Database</td>
    <td class="<?php
echo ($master_db['db_connect_status']) ? 'green' : 'red'; ?>"><?php
echo $master_db['db_connect']; ?></td>
    <td class="<?php
echo ($default_db['db_connect_status']) ? 'green' : 'red'; ?>"><?php
echo $default_db['db_connect']; ?></td>
  </tr>
</table>
<p class="info-details">
	<span> Note: </span>
    <span>
		Verify your database connectivity if above showed in 'Red' background color.
		<br/>For more info: <a href="http://dev1products.dev.agriya.com/doku.php?id=fpplatformultraplus-install#setting_up_database" target="_blank">http://dev1products.dev.agriya.com/doku.php?id=fpplatformultraplus-install#setting_up_database</a>
	</span>
</p>
<h2>Step 4: Checking Server Configuration...</h2>
<table border="2" class="list">
<tr>
	<th> Settings </th>
    <th> Install? </th>
</tr>
<?php
$ssl_enable = 'Installed';
$url = "https://" . $_SERVER['SERVER_NAME'];
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
if (curl_exec($ch) === false) {
    $ssl_enable = 'Not Installed';
}
curl_close($ch);
?>
  <tr>
    <td>SSL Certificate</td>
    <td class="<?php
echo ($ssl_enable == 'Installed') ? 'green' : 'yellow'; ?>">
	   <?php
echo $ssl_enable; ?>
    </td>
  </tr>
<?php
$ssl_enable = 'Configured';
$url = "http://m." . $_SERVER['SERVER_NAME'];
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
if (curl_exec($ch) === false) {
    if ($master_db['settings']['site'][1]) //If mobile layout is enabled in admin section.
    {
        $ssl_enable = 'm.&lt;domain name&gt; points to the "public_html" folder which have the app & core folders.';
    } else {
        $ssl_enable = 'Not Installed';
    }
}
// Close handle
curl_close($ch);
?>
  <tr>
    <td>Mobile Version (Subdomain configured for m.<?php echo $_SERVER['SERVER_NAME']; ?> ?)</td>
    <td class="<?php
echo ($ssl_enable == 'Configured') ? 'green' : 'red'; ?>">
		<?php
echo $ssl_enable; ?>
    </td>
  </tr>
<?php
if (!empty($master_db['settings']['sitesettings']['site_setting'][0]['value'])) {
    $site = $master_db['settings']['site'][0];
	$to = $master_db['settings']['sitesettings']['site_setting'][0]['value'];
    $subject = 'Important: ' . $site . ' Test Email';
    $body = 'This is the test email from ' . $site . '. If you receive this email, your server is more likely working fine.';
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers.= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
    // More headers
    $headers.= 'From: ' . $site . ' <' . $to . '>' . "\r\n";
    if (@mail($to, $subject, $body, $headers)) {
        $email = "Working";
    } else {
        $email = "Not Working";
    }
} else {
    $email = "Admin email should not be empty";
}
?>
  <tr>
    <td> Mail System</td>
    <td class="<?php
echo ($email == 'Working') ? 'green' : 'red'; ?>">
		<?php
if ($email == 'Working') {
    $to = $master_db['settings']['sitesettings']['site_setting'][0]['value'];
    echo $admin_mail_link = '<a href="' . $_SERVER['PHP_SELF'] . '?action=email&amp;to=' . $to . '" id="mail">Send test mail</a> to ' . $to;
} else {
    echo $email;
} ?>
    </td>
  </tr>
<?php
$username = "";
$password = "";
$url = 'http://' . $_SERVER['HTTP_HOST'];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
$output = curl_exec($ch);
$info = curl_getinfo($ch);
curl_close($ch);
if ($info['http_code'] == 401) {
    $htaccess_papp_protected = "Protected";
    $class = "red";
} else {
    $htaccess_papp_protected = "Not Protected";
    $class = "green";
}
?>
  <tr>
    <td>htaccess Password Protected</td>
    <td class="<?php
echo $class; ?>">
		<?php
echo $htaccess_papp_protected; ?>
    </td>
  </tr>
</table>
<p class="info-details">
	<span> Note: </span>
    <span>
		<br/>For more info: <a href="http://dev1products.dev.agriya.com/doku.php?id=fpplatformultraplus-install#manage_settings" target="_blank">http://dev1products.dev.agriya.com/doku.php?id=fpplatformultraplus-install#manage_settings</a>
	</span>
</p>
<?php
if ($master_db['payment_gateway']['error'] == 'None') { ?>
<h2>Step 5: Checking Third Party Configuration...</h2>

<table border="2" class="list">
  <tr align="center">
    <th colspan="8">Payment Gateway</th>
  </tr>
  <tr>
    <th>Gateway</th>
    <th>Active?</th>
    <th>Live mode?</th>
    <th>Enable for Wallet?</th>
    <th>Enable for Project Listing?</th>
    <th>Enable for Pledge?</th>
    <th>Enable for Donate?</th>
  </tr>

  <?php
    $payment_gateway_active = "no";
    $payment_gateway_inactive = "no";
    foreach($master_db['payment_gateway']['gateway'] as $gateway) {
        if ($gateway['is_active']) {
            $payment_gateway_active = "yes";
            if (!$gateway['is_test_mode']) {
                $class = 'green';
            } else {
                $class = 'red';
                $req_not_met = 1;
            }
        } else {
            $payment_gateway_inactive = "yes";
            $class = '';
        }
?>
  <tr>
    <td><?php
        echo $gateway['display_name']; ?></td>
    <td><?php
        echo ($gateway['is_active']) ? 'Yes' : 'No'; ?></td>
    <td class="<?php
        echo $class; ?>"><?php
        echo (!$gateway['is_test_mode']) ? 'Yes' : 'No'; ?></td>
    <td><?php
        echo ($gateway['is_enable_for_add_to_wallet']) ? 'Yes' : 'No'; ?></td>
	<td><?php
        echo ($gateway['is_enable_for_project']) ? 'Yes' : 'No'; ?></td>
    <td><?php
        echo ($gateway['is_enable_for_pledge']) ? 'Yes' : 'No'; ?></td>
    <td><?php
        echo ($gateway['is_enable_for_donate']) ? 'Yes' : 'No'; ?></td>
  </tr>
  <?php
    } ?>
</table>
<?php
    if ($payment_gateway_inactive == "yes" && $payment_gateway_active == "no") { ?>
<div class="pay_gate_req"> All payment gateways are disabled. Please select atleast one.
</div>
<?php
    } ?>
<table width="400" border="2" class="list">
    <tr>
        <th colspan="4">Payment Gateway Settings</th>
    </tr>
    <tr>
        <th>Gateway</th>
        <th>Settings</th>
        <th>Live</th>
    </tr>
	<?php
    $setting_labels = array(
        'payee_account' => 'Payee Account',
        'receiver_emails' => 'Receiver Emails',
        'adaptive_API_AppID' => 'Adaptive API App ID',
        'adaptive_API_Signature' => 'Adaptive API Signature',
        'adaptive_API_Password' => 'Adaptive API Password',
        'adaptive_API_UserName' => 'Adaptive API Username',
        'MRB_ID' => 'Merchant Referral Bonus ID',
        'masspay_API_UserName' => 'Masspay API UserName',
        'masspay_API_Password' => 'Masspay API Password',
        'masspay_API_Signature' => 'Masspay API Signature',
    );
	// unset wallet payment gateway
	unset($master_db['payment_gateway']['gateway'][1]);
    foreach($master_db['payment_gateway']['gateway'] as $key => $gateway) {
        $i = 0;
        foreach($gateway['settings'] as $setting) {
            if ($setting['name'] != 'is_enable_wallet') {
                if ($i == 0) {
?>
                    <tr>
                        <td rowspan="<?php
                    echo (count($gateway['settings'])); ?>"><?php
                    echo $gateway['display_name']; ?></td>
                        <td><?php
                    echo $setting_labels[$setting['name']]; ?></td>
                        <td class="<?php
                    echo ($setting['live_mode_value']) ? 'green' : 'red'; ?>">
                        <?php
                    if (!$setting['live_mode_value']) {
                        $req_not_met = 1;
                    }
                    if ($setting['name'] != 'masspay_API_Password' && $setting['name'] != 'masspay_API_Signature' && $setting['name'] != 'adaptive_API_Signature' && $setting['name'] != 'adaptive_API_Password' && $setting['name'] != 'authorize_net_trans_key' && $setting['name'] != 'pagseguro_token') {
                        echo ($setting['live_mode_value']) ? $setting['live_mode_value'] : 'no Value';
                    } else {
                        echo ($setting['live_mode_value']) ? 'yes (Security purpose hide value)' : 'no Value';
                    }
?>
                        </td>
                    </tr>
				<?php
                } else {
?>
<tr>
<td><?php
                    echo $setting_labels[$setting['name']]; ?></td>
<td class="<?php
                    echo ($setting['live_mode_value']) ? 'green' : 'red'; ?>">
<?php
                    if (!$setting['live_mode_value']) {
                        $req_not_met = 1;
                    }
                    if ($setting['name'] != 'masspay_API_Password' && $setting['name'] != 'masspay_API_Signature' && $setting['name'] != 'adaptive_API_Signature' && $setting['name'] != 'adaptive_API_Password' && $setting['name'] != 'authorize_net_trans_key' && $setting['name'] != 'pagseguro_token') {
                        echo ($setting['live_mode_value']) ? $setting['live_mode_value'] : 'No Value';
                    } else echo ($setting['live_mode_value']) ? 'yes (Security purpose hide value)' : 'No Value';
?>
</td>
</tr>
  <?php
                }
                $i++;
            }
        }
    } ?>
</table>

<table class="list">
    <tr>
        <th>Priority</th>
        <th>Name</th>
        <th>Value</th>
    </tr>
	<?php
    foreach($master_db['settings'] as $key => $setting) {
        $assigned_keys = array(
            $facebook_settings_id,
            $twitter_settings_id,
			$google_settings_id,
			$googleplus_settings_id,
			$yahoo_settings_id,
			$linkedin_settings_id,
			'sitesettings',
        );

        if (in_array($key, $assigned_keys)) {
?>
            <tr>
                <th colspan="3">
                <?php
            switch ($key) {
                case $facebook_settings_id: // facebook
                    echo 'Facebook - <a href="' . $_SERVER['PHP_SELF'] . '?action=post&amp;to=facebook" id="fb">Test post</a> to wall';
                    //echo 'Facebook - <a href="#" id="fb">Test post</a> to wall';
                    break;

                case $twitter_settings_id: // Twitter
                    echo 'Twitter - <a href="' . $_SERVER['PHP_SELF'] . '?action=post&amp;to=twitter" id="tweet">Test post</a> to Twitter';
					//echo 'Twitter - <a href="#" id="tweet">Test post</a> to Twitter';
                    break;
				case $google_settings_id: // Google
                    echo 'Google';
					//echo 'Twitter - <a href="#" id="tweet">Test post</a> to Twitter';
                    break;
				case $googleplus_settings_id: // GooglePlus
                    echo 'Google+';
					//echo 'Twitter - <a href="#" id="tweet">Test post</a> to Twitter';
                    break;
				case $yahoo_settings_id: // Yahoo
                    echo 'Yahoo';
					//echo 'Twitter - <a href="#" id="tweet">Test post</a> to Twitter';
                    break;
				case $linkedin_settings_id: // LinkedIn
                    echo 'LinkedIn';
					//echo 'Twitter - <a href="#" id="tweet">Test post</a> to Twitter';
                    break;
                case 'sitesettings': // Site Settings
                    echo "Site Settings";
                    break;

            }
?>
                </th>
            </tr>
	<?php
        } ?>
	<?php
        if (is_array($setting)) {

		if($key == $facebook_settings_id) //To display facebook credentials in the last rows
		{
			$setting['Mandatory'][9] = $setting['Mandatory'][2];
			$setting['Mandatory'][10] = $setting['Mandatory'][5];
            unset($setting['Mandatory'][2]);
			unset($setting['Mandatory'][5]);
		}
		if($key == $twitter_settings_id) //To display twitter credentials in the last rows
		{
			$setting['Mandatory'][8] = $setting['Mandatory'][5];
			$setting['Mandatory'][9] = $setting['Mandatory'][6];
            unset($setting['Mandatory'][5]);
			unset($setting['Mandatory'][6]);
		}
		foreach($setting as $data => $step) {
                $i = 0;
				if($key == $facebook_settings_id || $key == $twitter_settings_id)
				{
					$count = count($step)+1;
				} else {
					$count = count($step);
				}
                if (is_array($step)) {
					$settings_check_yes_no = array(
					);
					$settings_check_one_zero = array(
						'site.is_in_prelaunch_mode',
						'site.maintenance_mode',
						'facebook.enable_facebook_post_open_deal',
						'Project.post_project_on_facebook',
						'twitter.prompt_for_email_after_register',
						'twitter.enable_twitter_post_open_deal',
						'Project.post_project_on_twitter',
						'social_networking.post_project_on_user_twitter',
					);
					$secure_key_value = array(
						'facebook.fb_secrect_key',
						'twitter.consumer_secret',
						'facebook.fb_access_token',
						'twitter.site_user_access_key',
						'twitter.site_user_access_token',
					);
                    foreach($step as $mantry) {
                        $class = 'yellow';
                        if ($data != 'Not Mandatory') {
                            $class = (!empty($mantry['value'])) ? 'green' : 'red';
                        } else {
                            $class = (!empty($mantry['value'])) ? 'green' : 'yellow';
                        }
                        if ($class == 'red') {
                            $req_not_met = 1;
                        }
                        if ($class == 'yellow') {
                            $req_not_met_no_man = 1;
                        }
                        if ($i == 0) {
?>
						<tr>
							<td rowspan="<?php
                            echo $count; ?>"><?php
                            echo ($data == 'site_setting')?'':$data; ?></td>
							<td><?php
                            echo $mantry['label']; ?></td>
							<td class="<?php
                            echo $class; ?> "><?php
							if ($mantry['name'] == 'EmailTemplate.admin_email') {
                                echo ($mantry['value']) ? $mantry['value'] : 'Contact email should not be empty';
                            } else {
                                if (in_array($mantry['name'], $settings_check_yes_no)) {
									echo ($mantry['value']) ? 'yes' : 'No Value';
								} elseif (in_array($mantry['name'], $secure_key_value)) {
									echo ($mantry['value']) ? 'yes (Security purpose hide value)' : 'No Value';
								} elseif (in_array($mantry['name'], $settings_check_one_zero)) {
									echo ($mantry['value']) ? 'On' : 'Off';
								} else {
									echo ($mantry['value']) ? $mantry['value'] : 'No Value';
								}
                            }
?>
							</td>
						</tr>
					<?php
                        } else {
						if($mantry['name'] == 'facebook.fb_access_token')
						{
?>
							<tr>
							<td colspan="2">
                            <div class="cred_detail">
                            The following 2 settings will automatically be updated when clicking "Update Facebook Credentials" link in Facebook tab found under admin settings.
                            </div>
                            </td>
                            </tr>
<?php
						}

						if($mantry['name'] == 'twitter.site_user_access_key')
						{
?>
							<tr>
							<td colspan="2">
                            <div class="cred_detail">
                            The following 2 settings will automatically be updated when clicking "Update Twitter Credentials" link in Twitter tab found under admin settings.
                            </div>
                            </td>
                            </tr>
<?php
						}
?>
						<tr>
							<td><?php
                            echo $mantry['label']; ?></td>
							<?php
                            if ($mantry['name'] == 'site.maintenance_mode') {
                                if (!empty($mantry['value'])) {
                                    $class = 'red';
                                } else {
                                    $class = 'green';
                                }
                            }
?>
							<td class="<?php
                            echo $class; ?> "><?php
                            if (in_array($mantry['name'], $settings_check_yes_no)) {
                                echo ($mantry['value']) ? 'yes' : 'No Value';
                            } elseif (in_array($mantry['name'], $secure_key_value)) {
                                echo ($mantry['value']) ? 'yes (Security purpose hide value)' : 'No Value';
							} elseif (in_array($mantry['name'], $settings_check_one_zero)) {
                                echo ($mantry['value']) ? 'On' : 'Off';
                            } else {
                                echo ($mantry['value']) ? $mantry['value'] : 'No Value';
                            }
?>
							</td>
						</tr>
						<?php
                        }
                        $i++;
                    }
                }
            }
        }
    }
?>
</table>
<p class="info-details">
	<span> Note: </span>
    <span>
		Above shows the settings enabled/disabled currently in the site. Login in as Administrator and go to "Settings" to manage the above displayed ones.
		<br/>For more info: <a href="http://dev1products.dev.agriya.com/doku.php?id=fpplatformultraplus-install#manage_settings" target="_blank">http://dev1products.dev.agriya.com/doku.php?id=fpplatformultraplus-install#manage_settings</a>
    </span>
</p>
<?php
} ?>
<h2>Step 6: Checking Server Time...</h2>
<table border="2" class="list">
    <tr>
        <th> Settings </th>
        <th> Time </th>
    </tr>
    <tr>
        <td>Atomic Time (sec)</td>
        <td class=""><?php
echo GetAtomicTime(); ?></td>
    </tr>
    <tr>
        <td>Server Time (sec)</td>
        <td class=""><?php
echo time(); ?></td>
    </tr>
    <tr>
        <td>Difference (sec)</td>
        <td class=""><?php
echo abs(GetAtomicTime() -time()); ?></td>
    </tr>
    <?php
if (abs(GetAtomicTime() -time()) > 60*5) { ?>
        <tr>
            <td colspan="2" class="red">Difference is greater than 5 mins</td>
        </tr>
    <?php
} else { ?>
        <tr>
            <td colspan="2" class="green">Difference is less than 5 mins</td>
        </tr>
    <?php
} ?>
</table>
<p class="info-details">
	<span> Note: </span>
    <span>
		Timing difference may affect "Signin" with Twitter, Facebook, Google, Yahoo!, etc
	</span>
</p>


<?php
$url = "http://" . $_SERVER['SERVER_NAME'] . "/";
if ($req_not_met == 1) {
    $req_sts = 'Sorry, can\'t proceed. Please fix the above remarks.';
    $setclass = 'red_req_details';
} elseif ($req_not_met_no_man == 1) {
    $req_sts = 'Alert: You may able to run <a href="' . $url . '">the site</a>. But, you\'re strongly advised to fix above warnings.';
    $setclass = 'yellow_req_details';
}
else {
    $req_sts = 'Success, you should be able to run <a href="' . $url . '">the site</a>';
    $setclass = 'green_req_details';
}
?>
<h1>Final Verdict</h1>
<div align="center" class="<?php
echo $setclass; ?>" id="final_verdict"><h1><?php
echo $req_sts; ?></h1></div>
<?php
if (!empty($pre_launch_mode)) { ?>
<div align="center" class="<?php
    echo $setclass_pre_launch; ?>" id="final_verdict"><h1><?php
    echo $pre_launch_mode; ?></h1></div>
<?php
} ?>


<?php
class tmhOAuth {
  /**
* Creates a new tmhOAuth object
*
* @param string $config, the configuration to use for this request
*/
  function __construct($config) {
    $this->params = array();
    $this->auto_fixed_time = false;

    // for ease of testing
    if (file_exists(dirname(__FILE__).'/_account.php')) {
      include '_account.php';
      if (isset($_accounts) && $config['consumer_key'] == 'YOUR_CONSUMER_KEY') :
        if ($config['user_token'] == 'A_USER_TOKEN')
          $config = array_merge($config, $_accounts['test_with_user']);
        else
          $config = array_merge($config, $_accounts['test']);
      endif;
    }

    // default configuration options
    $this->config = array_merge(
      array(
        'consumer_key' => '',
        'consumer_secret' => '',
        'user_token' => '',
        'user_secret' => '',
        'use_ssl' => true,
        'host' => 'api.twitter.com',
        'debug' => false,
        'force_nonce' => false,
        'nonce' => false, // used for checking signatures. leave as false for auto
        'force_timestamp' => false,
        'timestamp' => false, // used for checking signatures. leave as false for auto
        'oauth_version' => '1.0',

        // you probably don't want to change any of these curl values
        'curl_connecttimeout' => 30,
        'curl_timeout' => 10,
        // for security you may want to set this to TRUE. If you do you need
        // to install the servers certificate in your local certificate store.
        'curl_ssl_verifypeer' => false,
        'curl_followlocation' => false, // whether to follow redirects or not

        // streaming API
        'is_streaming' => false,
        'streaming_eol' => "\r\n",
        'streaming_metrics_interval' => 60,
      ),
      $config
    );
  }

  /**
* Generates a random OAuth nonce.
* If 'force_nonce' is true a nonce is not generated and the value in the configuration will be retained.
*
* @param string $length how many characters the nonce should be before MD5 hashing. default 12
* @param string $include_time whether to include time at the beginning of the nonce. default true
* @return void
*/
  private function create_nonce($length=12, $include_time=true) {
    if ($this->config['force_nonce'] == false) {
      $sequence = array_merge(range(0,9), range('A','Z'), range('a','z'));
      $length = $length > count($sequence) ? count($sequence) : $length;
      shuffle($sequence);
      $this->config['nonce'] = md5(substr(microtime() . implode($sequence), 0, $length));
    }
  }

  /**
* Generates a timestamp.
* If 'force_timestamp' is true a nonce is not generated and the value in the configuration will be retained.
*
* @return void
*/
  private function create_timestamp() {
    $this->config['timestamp'] = ($this->config['force_timestamp'] == false ? time() : $this->config['timestamp']);
  }

  /**
* Encodes the string or array passed in a way compatible with OAuth.
* If an array is passed each array value will will be encoded.
*
* @param mixed $data the scalar or array to encode
* @return $data encoded in a way compatible with OAuth
*/
  private function safe_encode($data) {
    if (is_array($data)) {
      return array_map(array($this, 'safe_encode'), $data);
    } else if (is_scalar($data)) {
      return str_ireplace(
        array('+', '%7E'),
        array(' ', '~'),
        rawurlencode($data)
      );
    } else {
      return '';
    }
  }

  /**
* Decodes the string or array from it's URL encoded form
* If an array is passed each array value will will be decoded.
*
* @param mixed $data the scalar or array to decode
* @return $data decoded from the URL encoded form
*/
  private function safe_decode($data) {
    if (is_array($data)) {
      return array_map(array($this, 'safe_decode'), $data);
    } else if (is_scalar($data)) {
      return rawurldecode($data);
    } else {
      return '';
    }
  }

  /**
* Returns an array of the standard OAuth parameters.
*
* @return array all required OAuth parameters, safely encoded
*/
  private function get_defaults() {
    $defaults = array(
      'oauth_version' => $this->config['oauth_version'],
      'oauth_nonce' => $this->config['nonce'],
      'oauth_timestamp' => $this->config['timestamp'],
      'oauth_consumer_key' => $this->config['consumer_key'],
      'oauth_signature_method' => 'HMAC-SHA1',
    );

    // include the user token if it exists
    if ( $this->config['user_token'] )
      $defaults['oauth_token'] = $this->config['user_token'];

    // safely encode
    foreach ($defaults as $k => $v) {
      $_defaults[$this->safe_encode($k)] = $this->safe_encode($v);
    }

    return $_defaults;
  }

  /**
* Extracts and decodes OAuth parameters from the passed string
*
* @param string $body the response body from an OAuth flow method
* @return array the response body safely decoded to an array of key => values
*/
  function extract_params($body) {
    $kvs = explode('&', $body);
    $decoded = array();
    foreach ($kvs as $kv) {
      $kv = explode('=', $kv, 2);
      $kv[0] = $this->safe_decode($kv[0]);
      $kv[1] = $this->safe_decode($kv[1]);
      $decoded[$kv[0]] = $kv[1];
    }
    return $decoded;
  }

  /**
* Prepares the HTTP method for use in the base string by converting it to
* uppercase.
*
* @param string $method an HTTP method such as GET or POST
* @return void value is stored to a class variable
* @author themattharris
*/
  private function prepare_method($method) {
    $this->method = strtoupper($method);
  }

  /**
* Prepares the URL for use in the base string by ripping it apart and
* reconstructing it.
*
* @param string $url the request URL
* @return void value is stored to a class variable
* @author themattharris
*/
  private function prepare_url($url) {
    $parts = parse_url($url);

    $port = @$parts['port'];
    $scheme = $parts['scheme'];
    $host = $parts['host'];
    $path = @$parts['path'];

    $port or $port = ($scheme == 'https') ? '443' : '80';

    if (($scheme == 'https' && $port != '443')
        || ($scheme == 'http' && $port != '80')) {
      $host = "$host:$port";
    }
    $this->url = "$scheme://$host$path";
  }

  /**
* Prepares all parameters for the base string and request.
* Multipart parameters are ignored as they are not defined in the specification,
* all other types of parameter are encoded for compatibility with OAuth.
*
* @param array $params the parameters for the request
* @return void prepared values are stored in class variables
*/
  private function prepare_params($params) {
    // do not encode multipart parameters, leave them alone
    if ($this->config['multipart']) {
      $this->request_params = $params;
      $params = array();
    }

    // signing parameters are request parameters + OAuth default parameters
    $this->signing_params = array_merge($this->get_defaults(), (array)$params);

    // Remove oauth_signature if present
    // Ref: Spec: 9.1.1 ("The oauth_signature parameter MUST be excluded.")
    if (isset($this->signing_params['oauth_signature'])) {
      unset($this->signing_params['oauth_signature']);
    }

    // Parameters are sorted by name, using lexicographical byte value ordering.
    // Ref: Spec: 9.1.1 (1)
    uksort($this->signing_params, 'strcmp');

    // encode. Also sort the signed parameters from the POST parameters
    foreach ($this->signing_params as $k => $v) {
      $k = $this->safe_encode($k);
      $v = $this->safe_encode($v);
      $_signing_params[$k] = $v;
      $kv[] = "{$k}={$v}";
    }

    // auth params = the default oauth params which are present in our collection of signing params
    $this->auth_params = array_intersect_key($this->get_defaults(), $_signing_params);
    if (isset($_signing_params['oauth_callback'])) {
      $this->auth_params['oauth_callback'] = $_signing_params['oauth_callback'];
      unset($_signing_params['oauth_callback']);
    }

    // request_params is already set if we're doing multipart, if not we need to set them now
    if ( ! $this->config['multipart'])
      $this->request_params = array_diff_key($_signing_params, $this->get_defaults());

    // create the parameter part of the base string
    $this->signing_params = implode('&', $kv);
  }

  /**
* Prepares the OAuth signing key
*
* @return void prepared signing key is stored in a class variables
*/
  private function prepare_signing_key() {
    $this->signing_key = $this->safe_encode($this->config['consumer_secret']) . '&' . $this->safe_encode($this->config['user_secret']);
  }

  /**
* Prepare the base string.
* Ref: Spec: 9.1.3 ("Concatenate Request Elements")
*
* @return void prepared base string is stored in a class variables
*/
  private function prepare_base_string() {
    $base = array(
      $this->method,
      $this->url,
      $this->signing_params
    );
    $this->base_string = implode('&', $this->safe_encode($base));
  }

  /**
* Prepares the Authorization header
*
* @return void prepared authorization header is stored in a class variables
*/
  private function prepare_auth_header() {
    $this->headers = array();
    uksort($this->auth_params, 'strcmp');
    foreach ($this->auth_params as $k => $v) {
      $kv[] = "{$k}=\"{$v}\"";
    }
    $this->auth_header = 'OAuth ' . implode(', ', $kv);
    $this->headers[] = 'Authorization: ' . $this->auth_header;
  }

  /**
* Signs the request and adds the OAuth signature. This runs all the request
* parameter preparation methods.
*
* @param string $method the HTTP method being used. e.g. POST, GET, HEAD etc
* @param string $url the request URL without query string parameters
* @param array $params the request parameters as an array of key=value pairs
* @param string $useauth whether to use authentication when making the request.
*/
  private function sign($method, $url, $params, $useauth) {
    $this->prepare_method($method);
    $this->prepare_url($url);
    $this->prepare_params($params);

    // we don't sign anything is we're not using auth
    if ($useauth) {
      $this->prepare_base_string();
      $this->prepare_signing_key();

      $this->auth_params['oauth_signature'] = $this->safe_encode(
        base64_encode(
          hash_hmac(
            'sha1', $this->base_string, $this->signing_key, true
      )));

      $this->prepare_auth_header();
    }
  }

  /**
* Make an HTTP request using this library. This method doesn't return anything.
* Instead the response should be inspected directly.
*
* @param string $method the HTTP method being used. e.g. POST, GET, HEAD etc
* @param string $url the request URL without query string parameters
* @param array $params the request parameters as an array of key=value pairs
* @param string $useauth whether to use authentication when making the request. Default true.
* @param string $multipart whether this request contains multipart data. Default false
*/
  function request($method, $url, $params=array(), $useauth=true, $multipart=false) {
    $this->config['multipart'] = $multipart;

    $this->create_nonce();
    $this->create_timestamp();

    $this->sign($method, $url, $params, $useauth);
    $this->curlit($multipart);
  }

  /**
* Make an HTTP request using this library. This method is different to 'request'
* because on a 401 error it will retry the request.
*
* When a 401 error is returned it is possible the timestamp of the client is
* too different to that of the API server. In this situation it is recommended
* the request is retried with the OAuth timestamp set to the same as the API
* server. This method will automatically try that technique.
*
* This method doesn't return anything. Instead the response should be
* inspected directly.
*
* @param string $method the HTTP method being used. e.g. POST, GET, HEAD etc
* @param string $url the request URL without query string parameters
* @param array $params the request parameters as an array of key=value pairs
* @param string $useauth whether to use authentication when making the request. Default true.
* @param string $multipart whether this request contains multipart data. Default false
*/
  function auto_fix_time_request($method, $url, $params=array(), $useauth=true, $multipart=false) {
    $this->request($method, $url, $params, $useauth, $multipart);

    // if we're not doing auth the timestamp isn't important
    if ( ! $useauth)
      return;

    // some error that isn't a 401
    if ($this->response['code'] != 401)
      return;

    // some error that is a 401 but isn't because the OAuth token and signature are incorrect
    // TODO: this check is horrid but helps avoid requesting twice when the username and password are wrong
    if (stripos($this->response['response'], 'password') !== false)
     return;

    // force the timestamp to be the same as the Twitter servers, and re-request
    $this->auto_fixed_time = true;
    $this->config['force_timestamp'] = true;
    $this->config['timestamp'] = strtotime($this->response['headers']['date']);
    $this->request($method, $url, $params, $useauth, $multipart);
  }

  /**
* Make a long poll HTTP request using this library. This method is
* different to the other request methods as it isn't supposed to disconnect
*
* Using this method expects a callback which will receive the streaming
* responses.
*
* @param string $method the HTTP method being used. e.g. POST, GET, HEAD etc
* @param string $url the request URL without query string parameters
* @param array $params the request parameters as an array of key=value pairs
* @param string $callback the callback function to stream the buffer to.
*/
  function streaming_request($method, $url, $params=array(), $callback='') {
    if ( ! empty($callback) ) {
      if ( ! function_exists($callback) ) {
        return false;
      }
      $this->config['streaming_callback'] = $callback;
    }
    $this->metrics['start'] = time();
    $this->metrics['interval_start'] = $this->metrics['start'];
    $this->metrics['tweets'] = 0;
    $this->metrics['last_tweets'] = 0;
    $this->metrics['bytes'] = 0;
    $this->metrics['last_bytes'] = 0;
    $this->config['is_streaming'] = true;
    $this->request($method, $url, $params);
  }

  /**
* Handles the updating of the current Streaming API metrics.
*/
  function update_metrics() {
    $now = time();
    if (($this->metrics['interval_start'] + $this->config['streaming_metrics_interval']) > $now)
      return false;

    $this->metrics['tps'] = round( ($this->metrics['tweets'] - $this->metrics['last_tweets']) / $this->config['streaming_metrics_interval'], 2);
    $this->metrics['bps'] = round( ($this->metrics['bytes'] - $this->metrics['last_bytes']) / $this->config['streaming_metrics_interval'], 2);

    $this->metrics['last_bytes'] = $this->metrics['bytes'];
    $this->metrics['last_tweets'] = $this->metrics['tweets'];
    $this->metrics['interval_start'] = $now;
    return $this->metrics;
  }

  /**
* Utility function to create the request URL in the requested format
*
* @param string $request the API method without extension
* @param string $format the format of the response. Default json. Set to an empty string to exclude the format
* @return string the concatenation of the host, API version, API method and format
*/
  function url($request, $format='json') {
    $format = strlen($format) > 0 ? ".$format" : '';
    $proto = $this->config['use_ssl'] ? 'https:/' : 'http:/';

    // backwards compatibility with v0.1
    if (isset($this->config['v']))
      $this->config['host'] = $this->config['host'] . '/' . $this->config['v'];

    return implode('/', array(
      $proto,
      $this->config['host'],
      $request . $format
    ));
  }

  /**
* Utility function to parse the returned curl headers and store them in the
* class array variable.
*
* @param object $ch curl handle
* @param string $header the response headers
* @return the string length of the header
*/
  private function curlHeader($ch, $header) {
    $i = strpos($header, ':');
    if ( ! empty($i) ) {
      $key = str_replace('-', '_', strtolower(substr($header, 0, $i)));
      $value = trim(substr($header, $i + 2));
      $this->response['headers'][$key] = $value;
    }
    return strlen($header);
  }

  /**
* Utility function to parse the returned curl buffer and store them until
* an EOL is found. The buffer for curl is an undefined size so we need
* to collect the content until an EOL is found.
*
* This function calls the previously defined streaming callback method.
*
* @param object $ch curl handle
* @param string $data the current curl buffer
*/
  private function curlWrite($ch, $data) {
    $l = strlen($data);
    if (strpos($data, $this->config['streaming_eol']) === false) {
      $this->buffer .= $data;
      return $l;
    }

    $buffered = explode($this->config['streaming_eol'], $data);
    $content = $this->buffer . $buffered[0];

    $this->metrics['tweets']++;
    $this->metrics['bytes'] += strlen($content);

    if ( ! function_exists($this->config['streaming_callback']))
      return 0;

    $metrics = $this->update_metrics();
    $stop = call_user_func(
      $this->config['streaming_callback'],
      $content,
      strlen($content),
      $metrics
    );
    $this->buffer = $buffered[1];
    if ($stop)
      return 0;

    return $l;
  }

  /**
* Makes a curl request. Takes no parameters as all should have been prepared
* by the request method
*
* @return void response data is stored in the class variable 'response'
*/
  private function curlit() {
    if (@$this->config['prevent_request'])
      return;

    // method handling
    switch ($this->method) {
      case 'GET':
        // GET request so convert the parameters to a querystring
        if ( ! empty($this->request_params)) {
          foreach ($this->request_params as $k => $v) {
            // Multipart params haven't been encoded yet.
            // Not sure why you would do a multipart GET but anyway, here's the support for it
            if ($this->config['multipart']) {
              $params[] = $this->safe_encode($k) . '=' . $this->safe_encode($v);
            } else {
              $params[] = $k . '=' . $v;
            }
          }
          $qs = implode('&', $params);
          $this->url = strlen($qs) > 0 ? $this->url . '?' . $qs : $this->url;
          $this->request_params = array();
        }
        break;
    }

    // configure curl
    $c = curl_init();
    curl_setopt($c, CURLOPT_USERAGENT, "themattharris' HTTP Client");
    curl_setopt($c, CURLOPT_CONNECTTIMEOUT, $this->config['curl_connecttimeout']);
    curl_setopt($c, CURLOPT_TIMEOUT, $this->config['curl_timeout']);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, $this->config['curl_ssl_verifypeer']);
    curl_setopt($c, CURLOPT_FOLLOWLOCATION, $this->config['curl_followlocation']);
    curl_setopt($c, CURLOPT_URL, $this->url);
    // process the headers
    curl_setopt($c, CURLOPT_HEADERFUNCTION, array($this, 'curlHeader'));
    curl_setopt($c, CURLOPT_HEADER, FALSE);
    curl_setopt($c, CURLINFO_HEADER_OUT, true);

    if ($this->config['is_streaming']) {
      // process the body
      $this->response['content-length'] = 0;
      curl_setopt($c, CURLOPT_TIMEOUT, 0);
      curl_setopt($c, CURLOPT_WRITEFUNCTION, array($this, 'curlWrite'));
    }

    switch ($this->method) {
      case 'GET':
        break;
      case 'POST':
        curl_setopt($c, CURLOPT_POST, TRUE);
        break;
      default:
        curl_setopt($c, CURLOPT_CUSTOMREQUEST, $this->method);
    }

    if ( ! empty($this->request_params) ) {
      // if not doing multipart we need to implode the parameters
      if ( ! $this->config['multipart'] ) {
        foreach ($this->request_params as $k => $v) {
          $ps[] = "{$k}={$v}";
        }
        $this->request_params = implode('&', $ps);
      }
      curl_setopt($c, CURLOPT_POSTFIELDS, $this->request_params);
    } else {
      // CURL will set length to -1 when there is no data, which breaks Twitter
      $this->headers[] = 'Content-Type:';
      $this->headers[] = 'Content-Length:';
    }

    // CURL defaults to setting this to Expect: 100-Continue which Twitter rejects
    $this->headers[] = 'Expect:';

    if ( ! empty($this->headers)) {
      curl_setopt($c, CURLOPT_HTTPHEADER, $this->headers);
    }

    // do it!
    $response = curl_exec($c);
    $code = curl_getinfo($c, CURLINFO_HTTP_CODE);
    $info = curl_getinfo($c);
    curl_close($c);

    // store the response
    $this->response['code'] = $code;
    $this->response['response'] = $response;
    $this->response['info'] = $info;
  }

  /**
* Debug function for printing the content of an object
*
* @param mixes $obj
*/
  function pr($obj) {
    echo '<pre style="word-wrap: break-word">';
    if ( is_object($obj) )
      print_r($obj);
    elseif ( is_array($obj) )
      print_r($obj);
    else
      echo $obj;
    echo '</pre>';
  }

  /**
* Returns the current URL. This is instead of PHP_SELF which is unsafe
*
* @param bool $dropqs whether to drop the querystring or not. Default true
* @return string the current URL
*/
  function php_self($dropqs=true) {
    $url = sprintf('%s://%s%s',
      $_SERVER['SERVER_PORT'] == 80 ? 'http' : 'https',
      $_SERVER['SERVER_NAME'],
      $_SERVER['REQUEST_URI']
    );

    $parts = parse_url($url);

    $port = @$parts['port'];
    $scheme = $parts['scheme'];
    $host = $parts['host'];
    $path = @$parts['path'];
    $qs = @$parts['query'];

    $port or $port = ($scheme == 'https') ? '443' : '80';

    if (($scheme == 'https' && $port != '443')
        || ($scheme == 'http' && $port != '80')) {
      $host = "$host:$port";
    }
    $url = "$scheme://$host$path";
    if ( ! $dropqs)
      return "{$url}?{$qs}";
    else
      return $url;
  }

  /**
* Entifies the tweet using the given entities element
*
* @param array $tweet the json converted to normalised array
* @return the tweet text with entities replaced with hyperlinks
*/
  function entify($tweet) {
    $keys = array();
    $replacements = array();
    $is_retweet = false;

    if (isset($tweet['retweeted_status'])) {
      $tweet = $tweet['retweeted_status'];
      $is_retweet = true;
    }

    if (!isset($tweet['entities'])) {
      return $tweet['text'];
    }

    // prepare the entities
    foreach ($tweet['entities'] as $type => $things) {
      foreach ($things as $entity => $value) {
        $tweet_link = "<a href=\"http://twitter.com/{$value['screen_name']}/statuses/{$tweet['id']}\">{$tweet['created_at']}</a>";

        switch ($type) {
          case 'hashtags':
            $href = "<a href=\"http://search.twitter.com/search?q=%23{$value['text']}\">#{$value['text']}</a>";
            break;
          case 'user_mentions':
            $href = "@<a href=\"http://twitter.com/{$value['screen_name']}\" title=\"{$value['name']}\">{$value['screen_name']}</a>";
            break;
          case 'urls':
            $url = empty($value['expanded_url']) ? $value['url'] : $value['expanded_url'];
            $display = isset($value['display_url']) ? $value['display_url'] : str_replace('http://', '', $url);
            // Not all pages are served in UTF-8 so you may need to do this ...
            $display = urldecode(str_replace('%E2%80%A6', '&hellip;', urlencode($display)));
            $href = "<a href=\"{$value['url']}\">{$display}</a>";
            break;
        }
        $keys[$value['indices']['0']] = substr(
          $tweet['text'],
          $value['indices']['0'],
          $value['indices']['1'] - $value['indices']['0']
        );
        $replacements[$value['indices']['0']] = $href;
      }
    }

    ksort($replacements);
    $replacements = array_reverse($replacements, true);
    $entified_tweet = $tweet['text'];
    foreach ($replacements as $k => $v) {
      $entified_tweet = substr_replace($entified_tweet, $v, $k, strlen($keys[$k]));
    }
    return $entified_tweet;
  }

}
?>
</body>
</html>