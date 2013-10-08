<?php include("header.php"); 
$page = "users";
?>
<div id="content-outer">
<!-- start content -->
<div id="content">

<?php
if(isset($_GET['page']) && $_GET['page'] == "add")
{ ?>
<div id="page-heading"><h1>Add User</h1></div>


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
			<div class="step-dark-left"><a href="">Add New User</a></div>
			<div class="step-dark-right">&nbsp;</div>
			<div class="clear"></div>
		</div>
		<!--  end step-holder -->
	
		<!-- start id-form -->
		<?php
		if(isset($_POST['user']) && !empty($_POST['user']))
		{
			$user = $_POST['user'];
			$pass = $_POST['password'];
			echo(addUser($user,$pass));
		}
		?>
		<form action="" method="POST">
		<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
		<tr>
			<th valign="top">Username:</th>
			<td><input type="text" class="inp-form" name="user"/></td>
			<td></td>
		</tr>
		<td>
		<tr>
			<th valign="top">Password:</th>
			<td><input type="password" class="inp-form" name="password"/></td>
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
if(isset($_GET['page']) && $_GET['page'] == "del")
{ ?>
<div id="page-heading"><h1>Delete User</h1></div>


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
                        <div class="step-dark-left"><a href="">Delete User</a></div>
                        <div class="clear"></div>
                </div>
                <!--  end step-holder -->

                <!-- start id-form -->
                <?php
                if(isset($_POST['delUser']) && !empty($_POST['delUser']))
                {
                        $user = $_POST['delUser'];
                        echo(delUser($user));
                }
                ?>
                <form action="" method="POST">
                <table border="0" cellpadding="0" cellspacing="0"  id="id-form">
                <tr>
                        <th valign="top">IP Address:</th>
                        <td><input type="text" class="inp-form" name="delUser"/></td>
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
if(isset($_GET['page']) && $_GET['page'] == "search")
{ ?>
<div id="page-heading"><h1>Search For IP</h1></div>


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
                        <div class="step-dark-left"><a href="">Search For IP</a></div>
                        <div class="clear"></div>
                </div>
                <!--  end step-holder -->

                <!-- start id-form -->
                <?php
                if(isset($_POST['searchIP']) && !empty($_POST['searchIP']))
                {
                        $ip = $_POST['searchIP'];
                        echo(searchForBanned($ip));
                }
                ?>
                <form action="" method="POST">
                <table border="0" cellpadding="0" cellspacing="0"  id="id-form">
                <tr>
                        <th valign="top">IP Address:</th>
                        <td><input type="text" class="inp-form" name="searchIP"/></td>
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
