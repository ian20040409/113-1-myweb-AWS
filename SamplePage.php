<?php include "../inc/dbinfo.inc"; ?>
<!DOCTYPE HTML>
<!--
	Editorial by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>林恩佑的網站 11111110</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<link type="image/png" sizes="96x96" rel="icon" href="assets/icons8-hard-working-96.png">
	</head>

	<body class="is-preload">

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Main -->
					<div id="main">
						<div class="inner">

							<!-- Header -->
								<header id="header">
									<a href="/" class="logo"><strong>林恩佑的網站 11111110</strong></a>
									<ul class="icons">
										<li><a href="https://www.facebook.com/profile.php?id=100068804133842" class="icon brands fa-facebook-f alt"><span class="label">Facebook</span></a></li>
										<li><a href="https://www.youtube.com/@ianlin17698/" class="icon brands fa-youtube alt"><span class="label">Instagram</span></a></li>
										<li><a href="https://github.com/ian20040409/111-2_Web_Editorial" class="icon brands fa-github alt"><span class="label">Instagram</span></a></li>
										<div>
										<h2>
										
										</h2>
										</div>
									</ul>
								</header>

							<!-- Content -->
								<section>
									<header class="main">
										<h1>員工管理</h1>
									</header>

									<!-- 添加/更新表單 -->
									<div class="box">
										<?php
											/* 連接到MySQL並選擇數據庫。 */
											$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

											if (mysqli_connect_errno()) {
												echo "<p>無法連接到MySQL: " . mysqli_connect_error() . "</p>";
												exit();
											}

											$database = mysqli_select_db($connection, DB_DATABASE);

											/* 確保EMPLOYEES表存在。 */
											VerifyEmployeesTable($connection, DB_DATABASE);

											/* 處理刪除操作 */
											if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
												$id = intval($_GET['id']);
												DeleteEmployee($connection, $id);
											}

											/* 處理編輯操作 */
											$employee_id = '';
											$employee_name = '';
											$employee_address = '';
											$action = 'add';

											if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
												$employee_id = intval($_GET['id']);
												$employee = GetEmployee($connection, $employee_id);
												if ($employee) {
													$employee_name = $employee['NAME'];
													$employee_address = $employee['ADDRESS'];
													$action = 'update';
												}
											}

											/* 處理表單提交 */
											if ($_SERVER['REQUEST_METHOD'] == 'POST') {
												if (isset($_POST['action'])) {
													$action_post = $_POST['action'];
													$employee_name_post = htmlentities($_POST['NAME']);
													$employee_address_post = htmlentities($_POST['ADDRESS']);
													if ($action_post == 'add') {
														if (strlen($employee_name_post) || strlen($employee_address_post)) {
															AddEmployee($connection, $employee_name_post, $employee_address_post);
														}
													} elseif ($action_post == 'update' && isset($_POST['id'])) {
														$id_post = intval($_POST['id']);
														UpdateEmployee($connection, $id_post, $employee_name_post, $employee_address_post);
													}
												}
											}
										?>
										<form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="POST">
											<input type="hidden" name="action" value="<?php echo $action; ?>" />
											<?php if ($action == 'update') { ?>
												<input type="hidden" name="id" value="<?php echo $employee_id; ?>" />
											<?php } ?>
											<div class="row gtr-uniform">
												<div class="col-6 col-12-small">
													<input type="text" name="NAME" id="name" value="<?php echo $employee_name; ?>" placeholder="姓名" maxlength="45" required />
												</div>
												<div class="col-6 col-12-small">
													<input type="text" name="ADDRESS" id="address" value="<?php echo $employee_address; ?>" placeholder="地址" maxlength="90" required />
												</div>
												<div class="col-12">
													<ul class="actions">
														<li><input type="submit" value="<?php echo ($action == 'update') ? '更新員工' : '添加員工'; ?>" class="primary" /></li>
														<?php if ($action == 'update') { ?>
															<li><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>" class="button">取消</a></li>
														<?php } ?>
													</ul>
												</div>
											</div>
										</form>
									</div>

									<!-- 搜尋表單 -->
									<div class="box">
										<form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="GET">
											<div class="row gtr-uniform">
												<div class="col-6 col-12-small">
													<input type="text" name="search_name" placeholder="按姓名搜尋" value="<?php if (isset($_GET['search_name'])) echo htmlentities($_GET['search_name']); ?>" />
												</div>
												<div class="col-6 col-12-small">
													<input type="text" name="search_address" placeholder="按地址搜尋" value="<?php if (isset($_GET['search_address'])) echo htmlentities($_GET['search_address']); ?>" />
												</div>
												<div class="col-12">
													<ul class="actions">
														<li><input type="submit" value="搜尋" class="primary" /></li>
														<li><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>" class="button">重置</a></li>
													</ul>
												</div>
											</div>
										</form>
									</div>

									<!-- 顯示員工列表 -->
									<div class="box">
										<header>
											<h2>員工列表</h2>
										</header>
										<div class="table-wrapper">
											<table>
												<thead>
													<tr>
														<th>ID</th>
														<th>姓名</th>
														<th>地址</th>
														<th>操作</th>
													</tr>
												</thead>
												<tbody>
													<?php
														/* 處理查詢 */
														$search_conditions = array();

														if (isset($_GET['search_name']) && $_GET['search_name'] != '') {
															$search_name = mysqli_real_escape_string($connection, $_GET['search_name']);
															$search_conditions[] = "NAME LIKE '%$search_name%'";
														}

														if (isset($_GET['search_address']) && $_GET['search_address'] != '') {
															$search_address = mysqli_real_escape_string($connection, $_GET['search_address']);
															$search_conditions[] = "ADDRESS LIKE '%$search_address%'";
														}

														$query = "SELECT * FROM EMPLOYEES";
														if (count($search_conditions) > 0) {
															$query .= " WHERE " . implode(' AND ', $search_conditions);
														}

														$result = mysqli_query($connection, $query);

														while($query_data = mysqli_fetch_assoc($result)) {
															echo "<tr>";
															echo "<td>" . htmlspecialchars($query_data['ID']) . "</td>";
															echo "<td>" . htmlspecialchars($query_data['NAME']) . "</td>";
															echo "<td>" . htmlspecialchars($query_data['ADDRESS']) . "</td>";
															echo "<td>";
															echo "<a href='" . $_SERVER['SCRIPT_NAME'] . "?action=edit&id=" . $query_data['ID'] . "' class='button small'>編輯</a> ";
															echo "<a href='" . $_SERVER['SCRIPT_NAME'] . "?action=delete&id=" . $query_data['ID'] . "' class='button small' onclick=\"return confirm('確定要刪除此員工嗎？');\">刪除</a>";
															echo "</td>";
															echo "</tr>";
														}
													?>
												</tbody>
											</table>
										</div>
									</div>

									<?php
										/* 清理資源 */
										if ($result) {
											mysqli_free_result($result);
										}
										mysqli_close($connection);
									?>

								</section>

						</div>
					</div>

				<!-- Sidebar -->
					<div id="sidebar">
						<div class="inner">

							<!-- Menu -->
							<nav id="menu">
								<header class="major">
									<h2>Menu</h2>
								</header>
								<ul>
									<li><a href="/">🏠 首頁</a></li>
									<li><a href="photo_post/about.html">📂 關於作者</a></li>
									<li><a href="photo_post/photo_index.html">📸 相簿</a></li>
								</ul>
							</nav>
							
							<!-- 聯絡我 -->
							<section>
								<header class="major">
									<h2>☎️ 聯絡我</h2>
								</header>
								<p>This is fake</p>									
								<ul class="contact">
									<li class="icon solid fa-envelope"><a href="mailto:ian@untitled.com">ian@untitled.com</a></li>
									<li class="icon solid fa-phone">(000) 000-0000</li>
									<li class="icon solid fa-map">Ian Road<br /></li>
								</ul>
							</section>
							
							
							
							
							

						</div>
					</div>

			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>

<?php
/* 添加員工到表中 */
function AddEmployee($connection, $name, $address) {
   $n = mysqli_real_escape_string($connection, $name);
   $a = mysqli_real_escape_string($connection, $address);

   $query = "INSERT INTO EMPLOYEES (NAME, ADDRESS) VALUES ('$n', '$a');";

   if(!mysqli_query($connection, $query)) {
       echo("<div class='alert alert-danger'>添加員工資料時出錯。</div>");
   }
}

/* 更新員工信息 */
function UpdateEmployee($connection, $id, $name, $address) {
    $id = intval($id);
    $n = mysqli_real_escape_string($connection, $name);
    $a = mysqli_real_escape_string($connection, $address);

    $query = "UPDATE EMPLOYEES SET NAME = '$n', ADDRESS = '$a' WHERE ID = $id";

    if(!mysqli_query($connection, $query)) {
        echo("<div class='alert alert-danger'>更新員工資料時出錯。</div>");
    }
}

/* 刪除員工 */
function DeleteEmployee($connection, $id) {
    $id = intval($id);
    $query = "DELETE FROM EMPLOYEES WHERE ID = $id";

    if(!mysqli_query($connection, $query)) {
        echo("<div class='alert alert-danger'>刪除員工資料時出錯。</div>");
    }
}

/* 獲取單個員工信息 */
function GetEmployee($connection, $id) {
    $id = intval($id);
    $query = "SELECT * FROM EMPLOYEES WHERE ID = $id";
    $result = mysqli_query($connection, $query);
    if ($result) {
        return mysqli_fetch_assoc($result);
    }
    return null;
}

/* 檢查表是否存在，如果不存在則創建 */
function VerifyEmployeesTable($connection, $dbName) {
  if(!TableExists("EMPLOYEES", $connection, $dbName))
  {
     $query = "CREATE TABLE EMPLOYEES (
         ID int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
         NAME VARCHAR(45),
         ADDRESS VARCHAR(90)
       )";

     if(!mysqli_query($connection, $query)) {
         echo("<div class='alert alert-danger'>創建表時出錯。</div>");
     }
  }
}

/* 檢查表是否存在 */
function TableExists($tableName, $connection, $dbName) {
  $t = mysqli_real_escape_string($connection, $tableName);
  $d = mysqli_real_escape_string($connection, $dbName);

  $checktable = mysqli_query($connection,
      "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_NAME = '$t' AND TABLE_SCHEMA = '$d'");

  if(mysqli_num_rows($checktable) > 0) return true;

  return false;
}
?>