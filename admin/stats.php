<?php
include("header.php");
$page = "stats";
?>
<!-- start content-outer ........................................................................................................................START -->
<div id="content-outer">
<!-- start content -->
<div id="content">

	<!--  start page-heading -->
	<div id="page-heading">
		<h1>Stats</h1>
	</div>
	<!-- end page-heading -->

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
		<!--  start content-table-inner ...................................................................... START -->
		<div id="content-table-inner">
		
			<!--  start table-content  -->
			<div id="table-content">
				<!--  start product-table ..................................................................................... -->
				<form id="mainform" action="">
				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
				<tr>
					<th class="table-header-check"><a id="toggle-all" ></a> </th>
					<th class="table-header-repeat line-left"><a href="">Hit</a>	</th>
					<th class="table-header-repeat line-left minwidth-1"><a href="">IP Address</a></th>
					<th class="table-header-repeat line-left"><a href="">Host</a></th>
                                        <th class="table-header-repeat line-left"><a href="">Browser</a></th>
                                        <th class="table-header-repeat line-left"><a href="">Version</a></th>
                                        <th class="table-header-repeat line-left"><a href="">OS</a></th>
					<th class="table-header-repeat line-left"><a href="">Time</a></th>
					<th class="table-header-repeat line-left"><a href="">Campaign</a></th>
					<th class="table-header-repeat line-left"><a href="">UID</a></th>
				</tr>
				<?php
				if(isset($_GET['page']) && $_GET['page'] > 1)
				{
					showStats($_GET['page']);
				}
				else
				{
					showStats(); 
				}
				?>
				</table>
				</form>
			</div>
			<!--  end content-table  -->
		
			<!--  start actions-box ............................................... -->
			<div id="actions-box">
				<a href="" class="action-slider"></a>
				<div id="actions-box-slider">
					<a href="" class="action-edit">Edit</a>
					<a href="" class="action-delete">Delete</a>
				</div>
				<div class="clear"></div>
			</div>
			<!-- end actions-box........... -->
			
			<!--  start paging..................................................... -->
			<table border="0" cellpadding="0" cellspacing="0" id="paging-table">
			<tr>
			<td>
				<?php 
				if(isset($_GET['page']) && $_GET['page'] != 0)
				{
					$page = $_GET['page'];
				}
				else
				{
					$page = 1;
				}
				?>
				<a href="?page=1" class="page-far-left"></a>
				<a href="?page=<?php echo($page - 1); ?>" class="page-left"></a>
				<div id="page-info">Page <strong><?php echo($page); ?></strong> / <?php echo(htmlspecialchars(maxPages(), ENT_QUOTES)); ?></div>
				<a href="?page=<?php echo($page + 1); ?>" class="page-right"></a>
				<a href="?page=<?php echo(htmlspecialchars(maxPages(), ENT_QUOTES)); ?>" class="page-far-right"></a>
			</td>
			<td>
			</td>
			</tr>
			</table>
			<!--  end paging................ -->
			
			<div class="clear"></div>
		 
		</div>
		<!--  end content-table-inner ............................................END  -->
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
<!--  end content-outer........................................................END -->

<div class="clear">&nbsp;</div>
<?php include("footer.php"); ?> 
