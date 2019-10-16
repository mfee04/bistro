<body class="flat-bistro">
    <div class="app-container">
        <div class="row content-container">
            
            <nav class="navbar navbar-default navbar-fixed-top navbar-top">
                <div class="container-fluid">
                    <div class="navbar-header pull-left">
                        <button type="button" class="navbar-expand-toggle pt-1">
                            <i class="fa fa-bars icon"></i>
                        </button>

                        <ol class="breadcrumb navbar-breadcrumb" style="font-size:12px;">
                            <li style="font-size:25px;">
                                <a href="index.php"><i class="fa fa-home"></i></a>
                            </li> 
                        </ol>

                        <button type="button" class="navbar-right-expand-toggle pull-right visible-xs pt-1">
                            <i class="fa fa-th icon"></i>
                        </button>
                    </div>
                    <div class="navbar-right pull-right" style="height:66px;line-height: 66px;">
                        <button type="button" class="navbar-right-expand-toggle pull-right visible-xs">
                            <i class="fa fa-times icon"></i>
                        </button>
                        <div class="pr-5">
                            <?php if(isset($_SESSION['loginUser'])): ?> <!--有登入則顯示-->
                            <div class="btn-group mr-1 pl-3"><h5><?= $_SESSION['loginUser']['nickname'] ?></h5></div>
                            <div class="btn-group"><!--登出-->
                                <button type="button" class="btn btn-default">
                                    <a href="logout.php" style="text-decoration:none;">
                                        <i class="fa fa-sign-out"></i> Logout</a>
                                </button>
                            </div>
                            <?php else: ?>
                            <div class="btn-group"><!--登入-->
                                <button type="button" class="btn btn-default">
                                    <a href="login.php" style="text-decoration:none;">
                                        <i class="fa fa-sign-in"></i> Login</a>
                                </button>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div><!-- /.登入資訊 -->
                </div>
            </nav>

			<div class="side-menu sidebar-inverse">
				<nav class="navbar navbar-default" role="navigation">
					<div class="side-menu-container">
						<div class="navbar-header">
                            <a class="navbar-brand" href="index.php">
                                <div class="icon">
                                    <img src="lib/images/logo-head.svg" alt="logo">
                                </div>
                                <div class="title">
                                    <img src="lib/images/logo-body.svg" alt="logo">
                                </div>
                            </a>
                            <button type="button" class="navbar-expand-toggle pull-right visible-xs">
                                <i class="fa fa-times icon"></i>
                            </button>
                        </div>
						
						<ul class="nav navbar-nav">
							<!-- Dropdown-->
							<?php if (isset($_SESSION['loginUser']['m_level']) and $_SESSION['loginUser']['m_level'] == 'admin') : ?>

							<li class="panel panel-default dropdown 
							<?= $_SERVER['PHP_SELF'] == '/bistro/member_list.php' ? 'active' : '' ?>
							<?= $_SERVER['PHP_SELF'] == '/bistro/member_data_insert.php' ? 'active' : '' ?>
							">
								<a data-toggle="collapse" href="#dropdown-member">
									<span class="icon fa fa-group"></span><span class="title">會員管理</span>
								</a>
								<!-- Dropdown level 1 -->
								<div id="dropdown-member" class="panel-collapse collapse">
									<div class="panel-body">
										<ul class="nav navbar-nav">
											<li><a href="member_list.php">會員列表</a></li>
											<li><a href="member_data_insert.php">新增會員</a></li>
										</ul>
									</div>
								</div>
							</li>
							<?php else : ?>
							<?php endif; ?>
							<?php if (isset($_SESSION['loginUser']['m_level']) and in_array($_SESSION['loginUser']['m_level'], ['admin', 'bar'])) : ?>
			
							<!-- Dropdown-->
							<li class="panel panel-default dropdown 
							<?= $_SERVER['PHP_SELF'] == '/bistro/bar_list.php' ? 'active' : '' ?>
							<?= $_SERVER['PHP_SELF'] == '/bistro/bar_data_insert.php' ? 'active' : '' ?>
							">
								<a data-toggle="collapse" href="#dropdown-bar">
									<span class="icon fa fa-map-marker"></span><span class="title">酒吧管理</span>
								</a>
								<!-- Dropdown level 1 -->
								<div id="dropdown-bar" class="panel-collapse collapse">
									<div class="panel-body">
										<ul class="nav navbar-nav">
											<li><a href="bar_list.php">酒吧列表</a></li>
											<li><a href="bar_data_insert.php">新增酒吧</a></li>
										</ul>
									</div>
								</div>
							</li>
							<?php else : ?>
							<?php endif; ?>
							<?php if (isset($_SESSION['loginUser']['m_level']) and in_array($_SESSION['loginUser']['m_level'], ['admin', 'business'])) : ?>
							<!-- Dropdown-->
							<li class="panel panel-default dropdown 
							<?= $_SERVER['PHP_SELF'] == '/bistro/business_list.php' ? 'active' : '' ?>
							<?= $_SERVER['PHP_SELF'] == '/bistro/business_data_insert.php' ? 'active' : '' ?>
							">
								<a data-toggle="collapse" href="#dropdown-business">
									<span class="icon fa fa-black-tie"></span><span class="title">酒商管理</span>
								</a>
								<!-- Dropdown level 1 -->
								<div id="dropdown-business" class="panel-collapse collapse">
									<div class="panel-body">
										<ul class="nav navbar-nav">
											<li><a href="business_list.php">酒商列表</a>
											<li><a href="business_data_insert.php">新增酒商</a>
											</li>

										</ul>
									</div>
								</div>
							</li>
							<!-- Dropdown-->
							<li class="panel panel-default dropdown 
							<?= $_SERVER['PHP_SELF'] == '/bistro/wine_list.php' ? 'active' : '' ?>
							<?= $_SERVER['PHP_SELF'] == '/bistro/wine_data_insert.php' ? 'active' : '' ?>
							">
								<a data-toggle="collapse" href="#dropdown-wine">
									<span class="icon fa fa-glass"></span><span class="title">酒類管理</span>
								</a>
								<!-- Dropdown level 1 -->
								<div id="dropdown-wine" class="panel-collapse collapse">
									<div class="panel-body">
										<ul class="nav navbar-nav">
											<li><a href="wine_list.php">酒類列表</a></li>
											<li><a href="wine_data_insert.php">新增酒類</a></li>
										</ul>
									</div>
								</div>
							</li>
							<?php else : ?>
							<?php endif; ?>
							<!-- Dropdown-->
							<?php if (isset($_SESSION['loginUser']['m_level']) and in_array($_SESSION['loginUser']['m_level'], ['admin', 'bar'])) : ?>
							<li class="panel panel-default dropdown 
							<?= $_SERVER['PHP_SELF'] == '/bistro/activity_list.php' ? 'active' : '' ?>
							<?= $_SERVER['PHP_SELF'] == '/bistro/activity_data_insert.php' ? 'active' : '' ?>
							">
								<a data-toggle="collapse" href="#dropdown-activity">
									<span class="icon fa fa-pencil-square-o"></span><span class="title">活動管理</span>
								</a>
								<!-- Dropdown level 1 -->
								<div id="dropdown-activity" class="panel-collapse collapse">
									<div class="panel-body">
										<ul class="nav navbar-nav">
											<li><a href="activity_list.php">活動列表</a></li>
											<li><a href="activity_data_insert.php">新增活動</a></li>
										</ul>
									</div>
								</div>
							</li>
							<?php else : ?>
							<?php endif; ?>
						</ul>
					</div>
					<!-- /.navbar-collapse -->
				</nav>
			</div>

			<!-- Main Content -->
			<div class="container-fluid">
                <div class="side-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="card">
                                <div class="card-body">
                                <!-- .card-header .card-title .card.profile .card-body .card-footer -->