<div class="col-md-3 left_col">
	  <div class="left_col scroll-view">
		<div class="navbar nav_title" style="border: 0;">
		  <span class="site_title">NEHR AMS</span>
		</div>

		<div class="clearfix"></div>

		<br />
		<?php 
			if(!isset($_SESSION['user_ID']))
			  {
				 header('Location: logout.php');
			  }

		?>
		<!-- sidebar menu -->
		<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
		  <div class="menu_section">
			<ul class="nav side-menu">
			  <li><a><i class="fa fa-home"></i> Asset Management <span class="fa fa-chevron-down"></span></a>
				<ul class="nav child_menu">
				  <li id="addassets.php"><a href="addasset.php">Add Assets</a></li>
                  <li id="bulkaddasset.php"><a href="bulkaddasset.php">Bulk Asset Import</a></li>
				  <li id="assetlist.php"><a href="assetlist.php">Edit/Delete Assets</a></li>
                  <?php if ($_SESSION['role'] == 'admin') {echo '<li id="adminassetlist.php"><a href="adminassetlist.php">Admin version list</a></li>' ;} ?>
				</ul>
			  </li>
			  <li><a><i class="fa fa-paper-plane-o"></i> Notifications<span class="fa fa-chevron-down"></span></a>
				<ul class="nav child_menu">
				  <li id="addnotification.php"><a href="addnotification.php">Add Notification</a></li>
				  <li id="notificationlist.php"><a href="notificationlist.php">Edit/Delete Notification</a></li>
				</ul>
			  </li>
			  <li><a><i class="fa fa-bar-chart-o"></i> Reports <span class="fa fa-chevron-down"></span></a>
				<ul class="nav child_menu">
				  <li id="generatereport.php"><a href="generatereport.php">Generate Report</a></li>
				  <li id="addreportstructure.php"><a href="addreportstructure.php">Add Reporting Structure</a></li>
				  <li id="editreportstructure.php"><a href="editreportstructure.php">Edit/Delete Reporting Structure</a></li>
				</ul>
			  </li>
			  <li><a><i class="fa fa-users"></i>User Management <span class="fa fa-chevron-down"></span></a>
				<ul class="nav child_menu">
				  <?php if ($_SESSION['role'] == 'admin') {echo '<li id="adduser.php"><a href="adduser.php">Add User</a></li>' ;} ?>
                  <?php if ($_SESSION['role'] == 'admin') {echo '<li id="bulkadduser.php"><a href="bulkadduser.php">Bulk Add Users</a></li>' ;} ?>
				  <?php if ($_SESSION['role'] == 'admin') {echo '<li id="userlist.php"><a href="userlist.php">Edit User</a></li>' ;} ?>

				  <li id="changepassword.php"><a href="changepassword.php">Change Password</a></li>
				</ul>
			  </li>
			  <li id="logs.php"><a href="logs.php"><i class="fa fa-cogs"></i> Logs</a>
			  </li>
			</ul>
		  </div>
		  

		</div>
		<!-- /sidebar menu -->

	  </div>
	</div>

	<!-- top navigation -->
	<div class="top_nav">
	  <div class="nav_menu">
		<nav>
		  <div class="nav toggle">
			<a id="menu_toggle"><i class="fa fa-bars"></i></a>
		  </div>

		  <ul class="nav navbar-nav navbar-right">
			<li class="">
			  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
				<?php echo $_SESSION['username']?>
				<span class=" fa fa-angle-down"></span>
			  </a>
			  <ul class="dropdown-menu dropdown-usermenu pull-right">
				<li><a href="logout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
			  </ul>
			</li>

			
		  </ul>
		</nav>
	  </div>
	</div>
	<!-- /top navigation -->
