<?php
$ip = $_SERVER['REMOTE_ADDR'];
$host = gethostbyaddr($_SERVER['REMOTE_ADDR']);
include('func.php');
checkBanned($ip);
if(isset($_POST['os']))
{
	trackIP($_POST['browserName'],$_POST['browserVersion'],$_POST['os'],$ip,$host, $_GET['campaign']);
}
?>
<script language="JavaScript" type="text/javascript" src="/js/jquery-1.4.1.min.js"></script>
<script src="/js/browser.js" ></script>
<script>
if (window.XMLHttpRequest){
    xmlhttp=new XMLHttpRequest();
}

else{
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}

var url = document.URL;
var params = "browserName=" + BrowserDetect.browser + "&browserVersion=" + BrowserDetect.version + "&os=" + BrowserDetect.OS + "&ip=<?php echo($ip); ?>&host=<?php echo($host); ?>&uid=<?php $_SESSION['uid']; ?>";
xmlhttp.open("POST", url, true);
xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlhttp.setRequestHeader("Content-length", params.length);
xmlhttp.setRequestHeader("Connection", "close");
xmlhttp.send(params);
</script>
<script>
<?php
// thanks to Mark Ignacio ( https://github.com/mark-ignacio ) for helping with 
// this function
?>
var url = window.location.origin + "/includes/tracker.php";
$(document).ready(function() {
    $('a').click(function(e) {
        var redirect = this.href;
        e.preventDefault();
        var campaign = "<?php echo $_GET['campaign'] ?>";
        var uid = "<?php echo $_GET['uid'] ?>";
        $.post(url, {url:this.href,campaignNum:campaign,user:uid}, function() {  document.location.href = redirect });
        return false;
    });
});
</script>
