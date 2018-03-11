<?php 
session_start();
include_once"config.php";
if(!isset($_SESSION['username']) || !isset($_SESSION['password'])){
	header("Location: index.php");
}else{
$ip = $_SERVER['REMOTE_ADDR'];
mysql_query("update members set `ip`='".$ip."' where username=".$_SESSION['username']."");
$fetch_ip = mysql_num_rows(mysql_query("SELECT * FROM `members` WHERE ip='".$_SERVER['REMOTE_ADDR']."'"));
if( $fetch_ip > 1 ) {
header("Location: banned.php");
}
$fetch_users_data = mysql_fetch_object(mysql_query("SELECT * FROM `members` WHERE username='".$_SESSION['username']."'"));
$ref_id=$fetch_users_data->id;
$query_refs = "SELECT COUNT(referral_ID) FROM members where referral_ID=".$ref_id."";  
$result_refs = mysql_query($query_refs) or die(mysql_error()); 
foreach(mysql_fetch_array($result_refs) as $total_referrals);
include("includes.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<script type="text/javascript">IPQ = false;</script><script src="http://www.ipqualityscore.com/api/filter.php?KEY=kq81xjlx7mram8plf9pzg32uiool3g&ID=15&SID=<?php echo $_SESSION['username'];?>" type="text/javascript"></script><script type="text/javascript">if (!IPQ) { window.location = 'http://www.ipqualityscore.com/help/removeAB.php'; }</script><noscript>Please enable JavaScript to access this page.<meta http-equiv="refresh" content="0;url=http://www.ipqualityscore.com/help/enableJS.php" /></noscript>
  <title><?php echo $title ?></title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="style.css" type="text/css" />
   <link rel="stylesheet" href="style_chat.css" type="text/css" />
  <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
  
  <script>
  $(document).ready(function() {
    $("#tabs").tabs();
  });
  </script>
</head>

<body>
<div id="wrapper">
    <div id="header">

        <a href="index.php">
        <div id="logo">
        </div></a>
        <div id="updates">
        <span>&nbsp;</span>
        </div>
        <div id="login">
        <div id="loginwelcome">
			<table>
			   <tr>
			   	   <td>
					  Welcome <b><?php echo $membername ?></b>
				   </td>
				   </tr>
				   <tr>
				   <td align="right" width="310">
				   Total Points: <b><?php echo $memberpoints ?></b>&nbsp;<br>
				   <?php if ($pointsneeded<=0){ ?>
				   You can now <a href="request.php"><b>request a voucher</b></a>!<?php }else{ ?>
			       Points Needed: <b><?php echo $pointsneeded ?></b><?php } ?>
			 	  <br>
					</td>
				</tr>
		</table>
		</div>
            
        </div>

         <ul id="navigation">
		    	<li><a href="index.php">Home</a></li>
  			    <?php if(isset($_SESSION['username']) && isset($_SESSION['password'])){  ?>	
  			    <li class="on"><a href="members.php">Members</a></li>
  			    <?php } ?>
                <li><a href="vouchers.php">Vouchers</a></li>
                <li><a href="terms.php">Terms</a></li>
                <li><a href="help.php">Help</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                   <?php if(isset($_SESSION['username']) && isset($_SESSION['password'])){  ?>	
  			    <li><a href="logout.php">Logout</a></li>
  			    <?php } ?>
            </ul>
    <div id="content">
 
		
		
	<div class="chatroom"> 
	<h1>ShoutBox</h1>
	<form method="post" id="form">  
		<table>  
			<tr>  
				<?php if (!$_SESSION['username']) { 
				echo '
				<td><input class="text" id="message" type="text" MAXLENGTH="255" disabled="disabled" value="User Not Logged In" /></td>';  
				} else {
				echo '
				<td><input class="text" id="message" type="text" MAXLENGTH="255" onfocus="resetBox(this, \'Enter your message\')" value="Enter your message" /></td>'; 
				}
				echo '
				<td><input id="nick" MAXLENGTH="55" type="hidden" value="'.$_SESSION['username'].'" /></td>';
				?>
			</tr>  
			<tr>  
				<td></td>  
				<td><input id="send" type="submit" value=">>"/></td>  
			</tr>  
		</table>
	</form>  
	<div id="shoutbox"> 
		<div id="container">  
			<ul class="menu">  
			</ul>  
			<span class="clear"></span>  
			<div class="content">  
				<div id="loading"></div>  
				<ul>  
				<ul>  
			</div>  
		</div>  
	</div>
	<script type="text/javascript" src="shoutbox.js"></script> 
</div>	
<?php 
if ($_SESSION['username']) { 
	echo '
	<a href="javascript:newwindow()" onClick="open_pop()" class="emoticon">Emoticons</a> ';
}
if (($_SESSION['username'] == "love4ever2h" ) || ($_SESSION['username'] == "WWSSupport")) {
	echo '
	<a href="mod.php" target="_blank" style="padding-left: 45px;" class="emoticon">Moderation</a> ';
} ?>
<div style="clear:both;"></div>
    <span style="clear:both;float:right;"
<br>
		<?php if ($pointsneeded <= 0){?>
		<a href="request.php"><img src="images/claim_voucher.png" border="0"></a>
		<?php } ?>
		</span>
     <h2>Members Area</h2><br>	
        <p>
        <b>Total points: <?php echo $memberpoints; ?></b><br>
        <b>Completed surveys: <?php echo $membersurveys; ?></b>
        <br>
        <?php if ($pointsneeded > 0){?>
		Points left before you can request a voucher: <?php echo $pointsneeded ?> 
		<?php } ?>
		<?php if ($pointsneeded <= 0){?>
		<br>
		Congratulations! You've earned enough points to request a voucher. <br>
		<a href="request.php">Click here</a> to contact us to confirm your selection, and email address.<br>
		<?php } ?>
		     
		<br><br>
		</p>
		<h2>Refer users and get MORE free points!</h2><br>
		<p>
		Your unique referral link is <a href="<?php echo $yourdomain?>?join=<?php echo $ref_id ?>"><?php echo $yourdomain ?>?join=<?php echo $ref_id ?></a><br><br>
		Give this unique link to all your friends and colleagues, and you will earn <?php echo $refer_points ?> points for every survey they complete!<br><br>
		<b>Your total number of referred users: <?php echo $total_referrals ?></b></p><br><br>
		<h2>Complete offers below to earn points</h2>

		</p>
<br><br>
<div id="tabs">
    <ul>
        <li><a href="#fragment-1"><span>RadiumeOne</span></a></li>
        <li><a href="#fragment-2"><span>PaymentWall</span></a></li>
        <li><a href="#fragment-3"><span>MatoMy</span></a></li>
        <li><a href="#fragment-4"><span>SuperSonicAds</span></a></li>
    </ul>
    <div id="fragment-1">
        <p></p>
   <iframe src="http://panel.gwallet.com/network-node/impression?appId=ad2bf1fef01545dd895acdb75f4c0b12&userId=<?php echo $_SESSION['username'];?>" frameborder="0" width="800" height="2200" scrolling="auto"></iframe>
   </div>
   <div id="fragment-2">
<iframe src="http://wallapi.com/api/ps/?key=0025d774a2c8242ca3d7b9934e51af39&uid=<?php echo $_SESSION['username'];?>&widget=p3_1" frameborder="0" width="800" height="2200" scrolling="auto"></iframe>
    </div>
 <div id="fragment-3">
<iframe src="http://service.matomy.com/offer/?id=ea472426-cf97-48ce-ae17-2d377c6a10e6&user_id=<?php echo $_SESSION['username'];?>&age=[AGE]&gender=[GENDER]" frameborder="0" width="800" height="2200" scrolling="auto"></iframe>
   </div>
<div id="fragment-4">
<iframe src="http://www.supersonicads.com/delivery/panel.php?applicationKey=2b4af7e9&applicationUserId=<?php echo $_SESSION['username'];?>" frameborder="0" width="800" height="2200" scrolling="auto"></iframe>
 </div>
<br><br>		
    </div>
 
<script type="text/javascript">
<!--
function open_pop(){window.open('emotes.htm','mywin','left=20,top=20,width=540,height=360,toolbar=0,menubar=0,resizable=0,scrollbars=1')}
function open_pop3(){window.open('mod.php','mywin2','left=20,top=20,width=640,height=485,toolbar=0,menubar=0,resizable=0,scrollbars=1')}
function namegame(name){namecontent=opener.document.getElementById("message").value;opener.document.getElementById("message").value="@"+name+"- "}
function resetBox(box,defaultvalue){if(box.value==defaultvalue){box.value=""}}
-->
</script>
<?php include("footer.php");?>