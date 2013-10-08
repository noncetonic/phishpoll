<?php include("header.php"); 
$page = "campaigns";
?>
<div id="content-outer">
<!-- start content -->
<div id="content">

<?php
if(isset($_GET['page']) && $_GET['page'] == "createTemplate")
{ ?>
<div id="page-heading"><h1>Create Email Template</h1></div>


<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
<tr>
	<th rowspan="3" class="sized"><img src="images/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
	<th class="topleft"></th>
	<td id="tbl-border-top">&nbsp;</td>
	<th class="topright"></th>
	<th rowspan="3" class="sized"><img src="images/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
</tr>
<tr>
	<td id="tbl-border-left"></td>
	<td>
	<!--  start content-table-inner -->
	<div id="content-table-inner">
	
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
	<td>
	
	
		<!--  start step-holder -->
		<div id="step-holder">
			<div class="step-dark-left"><a href="">Create Email Template</a></div>
			<div class="clear"></div>
		</div>
		<!--  end step-holder -->
	
		<!-- start id-form -->
		<?php if(isset($_POST['html']) && !empty($_POST['html']))
		{
			echo(createTemplate($_POST['html'], $_POST['campaignName']));
		}
		?>
		<form action="#" method="POST" id="templateForm">
		<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
		<tr>
			<th valign="top">Email Template:</th>
			<td>
				<h3>Note: use @@url@@ in place of real URL</h3>
				<h4>Example: [totally legit](@@url@@)</h4>
				<div id="epicEditor" style="width:500px;height:700px">
				<textarea id="epiceditor"></textarea>
				</div>
				<script src="js/epiceditor/js/epiceditor.js"></script>
				<script>
					var opts = {
						basePath: 'js/epiceditor',
						textarea: 'epiceditor',
						container: 'epicEditor'
					}
					var templateMaker;
					templateMaker = new EpicEditor(opts);
					templateMaker.load();
				
					function getHTML(){
						document.getElementById('html').value=templateMaker.exportFile(null,'html');
						document.getElementById('templateForm').submit();
					}
				</script>
			</td>
			<td></td>
		</tr>
		<tr>
			<th valign="top">Campaign Name:</th>
				<td>
					<?php listCampaigns(); ?>
				</td>
		</tr>
		<td>
			<input type="hidden" value="" id="html" name="html"/>
			<input type="button" name="templateSubmit" class="form-submit" onclick="getHTML()"/>
		</td>
		<td></td>
	</tr>
	</table>
	<!-- end id-form  -->
		</form>
	</td>
<?php
}
?>
<?php
if(isset($_GET['page']) && $_GET['page'] == "create")
{ ?>
<div id="page-heading"><h1>Create Campaign</h1></div>


<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
<tr>
        <th rowspan="3" class="sized"><img src="images/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
        <th class="topleft"></th>
        <td id="tbl-border-top">&nbsp;</td>
        <th class="topright"></th>
        <th rowspan="3" class="sized"><img src="images/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
</tr>
<tr>
        <td id="tbl-border-left"></td>
        <td>
        <!--  start content-table-inner -->
        <div id="content-table-inner">

        <table border="0" width="100%" cellpadding="0" cellspacing="0">
        <tr valign="top">
        <td>


                <!--  start step-holder -->
                <div id="step-holder">
                        <div class="step-dark-left"><a href="">Create Campaign</a></div>
                        <div class="clear"></div>
                </div>
                <!--  end step-holder -->

                <!-- start id-form -->
                <?php
                if(isset($_POST['campaignName']) && !empty($_POST['campaignName']))
                {
			if(isset($_POST['campaignURL']) && !empty($_POST['campaignURL']))
			{
                       		$name = $_POST['campaignName'];
				$url = $_POST['campaignURL'];
                       		echo(createCampaign($name,$url));
			}
                }
                ?>
                <form action="" method="POST">
                <table border="0" cellpadding="0" cellspacing="0"  id="id-form">
                <tr>
                        <th valign="top">Campaign Name:</th>
                        <td><input type="text" class="inp-form" name="campaignName"/></td>
                        <td></td>
                </tr>
		<tr>
			<th valaign="top">Camapign URL:</th>
			<td><input type="text" class="inp-form" name="campaignURL" /></td>
			<td></td>
		</tr>
                <td>
                        <input type="submit" value="" class="form-submit" />
                </td>
                <td></td>
        </tr>
        </table>
        <!-- end id-form  -->
                </form>
        </td>
<?php
}
?>
<?php
if(isset($_GET['page']) && $_GET['page'] == "mailer")
{ ?>
<div id="page-heading"><h1>Launch Campaign</h1></div>


<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
<tr>
        <th rowspan="3" class="sized"><img src="images/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
        <th class="topleft"></th>
        <td id="tbl-border-top">&nbsp;</td>
        <th class="topright"></th>
        <th rowspan="3" class="sized"><img src="images/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
</tr>
<tr>
        <td id="tbl-border-left"></td>
        <td>
        <!--  start content-table-inner -->
        <div id="content-table-inner">

        <table border="0" width="100%" cellpadding="0" cellspacing="0">
        <tr valign="top">
        <td>


                <!--  start step-holder -->
                <div id="step-holder">
                        <div class="step-dark-left"><a href="">Launch Campaign</a></div>
                        <div class="clear"></div>
                </div>
                <!--  end step-holder -->

                <!-- start id-form -->
                <?php
                if(isset($_POST['campaignName']) && !empty($_POST['campaignName']))
                {
			if(isset($_POST['emailFrom']) && !empty($_POST['emailFrom']))
			{
				if(isset($_POST['targets']) && !empty($_POST['targets']))
				{
					if(isset($_POST['subject']) && !empty($_POST['subject']))
					{
						goPhish($_POST['campaignName'],$_POST['emailFrom'],$_POST['targets'],$_POST['subject']);
					}
				}
			}
                }
                ?>
                <form action="" method="POST">
                <table border="0" cellpadding="0" cellspacing="0"  id="id-form">
                <tr>
                        <th valign="top">Campaign:</th>
                        <td><?php listCampaigns(); ?></td>
                        <td></td>
                </tr>
		<tr>
			<th valign="top">Email From:</th>
			<td><input type="text" class="inp-form" name="emailFrom" id="emailFrom" /></td>
			<td></td>
		</tr>
		<tr>
			<th valign="top">Subject:</th>
			<td><input type="text" class="inp-form" name="subject" /></td>
			<td></td>
		</tr>
		<tr>
			<th valign="top">Targets:</th>
			<td><textarea name="targets" id="targets" cols="80" rows="20">Enter Target Email Addresses. One Email Per Line</textarea></td>
			<td></td>
		</tr>
                <td>
                        <input type="submit" value="" class="form-submit" />
                </td>
                <td></td>
        </tr>
        </table>
        <!-- end id-form  -->
                </form>
        </td>
<?php
}
?>
	<td>

	<!--  start related-activities -->
	<div id="related-activities">
		
		<!--  start related-act-top -->
		<div id="related-act-top">
		<img src="images/forms/header_related_act.gif" width="271" height="43" alt="" />
		</div>
		<!-- end related-act-top -->
		
		<!--  start related-act-bottom -->
		<div id="related-act-bottom">
		
			<!--  start related-act-inner -->
			<div id="related-act-inner">
			
				<div class="left"><a href=""><img src="images/forms/icon_plus.gif" width="21" height="21" alt="" /></a></div>
				<div class="right">
					<h5>Add User</h5>
					Add a new user
					<ul class="greyarrow">
						<li><a href="?page=add">Click here to add a user</a></li> 
					</ul>
				</div>
				
				<div class="clear"></div>
				<div class="lines-dotted-short"></div>
				
				<div class="left"><a href=""><img src="images/forms/icon_minus.gif" width="21" height="21" alt="" /></a></div>
				<div class="right">
					<h5>Delete User</h5>
					Allows you to delete a user
					<ul class="greyarrow">
						<li><a href="?page=del">Click here to delete a user</a></li> 
					</ul>
				</div>
				
				<div class="clear"></div>
				<div class="lines-dotted-short"></div>
				
				<div class="left"><a href=""><img src="images/forms/icon_edit.gif" width="21" height="21" alt="" /></a></div>
				<div class="right">
					<h5>Search For A User</h5>
					Function to search for a user
					<ul class="greyarrow">
						<li><a href="?page=search">Click here to search for a user</a></li> 
					</ul>
				</div>
				<div class="clear"></div>
				
			</div>
			<!-- end related-act-inner -->
			<div class="clear"></div>
		
		</div>
		<!-- end related-act-bottom -->
	
	</div>
	<!-- end related-activities -->

</td>
</tr>
<tr>
<td><img src="images/shared/blank.gif" width="695" height="1" alt="blank" /></td>
<td></td>
</tr>
</table>
 
<div class="clear"></div>
 

</div>
<!--  end content-table-inner  -->
</td>
<td id="tbl-border-right"></td>
</tr>
<tr>
	<th class="sized bottomleft"></th>
	<td id="tbl-border-bottom">&nbsp;</td>
	<th class="sized bottomright"></th>
</tr>
</table>









 





<div class="clear">&nbsp;</div>

</div>
<!--  end content -->
<div class="clear">&nbsp;</div>
</div>
<!--  end content-outer -->

 

<div class="clear">&nbsp;</div>
<?php include('footer.php'); ?>
