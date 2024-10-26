<!DOCTYPE HTML>

<html>
	<head>
		<title>如何賺錢</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<link type="image/png" sizes="96x96" rel="icon" href="assets/icons8-hard-working-96.png">
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	</head>

	<body class="is-preload">

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Main -->
					<div id="main">
						<div class="inner">

							<!-- Content -->
								<section>
									<header class="main">
										<h1>SamplePage.php</h1>
									</header>

									<div>
<?php include "../inc/dbinfo.inc"; ?>
<html>
<body>
<h1>Sample page</h1>
<?php

  /* Connect to MySQL and select the database. */
  $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

  if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

  $database = mysqli_select_db($connection, DB_DATABASE);

  /* Ensure that the EMPLOYEES table exists. */
  VerifyEmployeesTable($connection, DB_DATABASE);

  /* If input fields are populated, add a row to the EMPLOYEES table. */
  $employee_name = htmlentities($_POST['NAME']);
  $employee_address = htmlentities($_POST['ADDRESS']);

  if (strlen($employee_name) || strlen($employee_address)) {
    AddEmployee($connection, $employee_name, $employee_address);
  }
?>

<!-- Input form -->
<form action="<?PHP echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
  <table border="0">
    <tr>
      <td>NAME</td>
      <td>ADDRESS</td>
    </tr>
    <tr>
      <td>
        <input type="text" name="NAME" maxlength="45" size="30" />
      </td>
      <td>
        <input type="text" name="ADDRESS" maxlength="90" size="60" />
      </td>
      <td>
        <input type="submit" value="Add Data" />
      </td>
    </tr>
  </table>
</form>

<!-- Display table data. -->
<table border="1" cellpadding="2" cellspacing="2">
  <tr>
    <td>ID</td>
    <td>NAME</td>
    <td>ADDRESS</td>
  </tr>

<?php

$result = mysqli_query($connection, "SELECT * FROM EMPLOYEES");

while($query_data = mysqli_fetch_row($result)) {
  echo "<tr>";
  echo "<td>",$query_data[0], "</td>",
       "<td>",$query_data[1], "</td>",
       "<td>",$query_data[2], "</td>";
  echo "</tr>";
}
?>

</table>

<!-- Clean up. -->
<?php

  mysqli_free_result($result);
  mysqli_close($connection);

?>

</body>
</html>


<?php

/* Add an employee to the table. */
function AddEmployee($connection, $name, $address) {
   $n = mysqli_real_escape_string($connection, $name);
   $a = mysqli_real_escape_string($connection, $address);

   $query = "INSERT INTO EMPLOYEES (NAME, ADDRESS) VALUES ('$n', '$a');";

   if(!mysqli_query($connection, $query)) echo("<p>Error adding employee data.</p>");
}

/* Check whether the table exists and, if not, create it. */
function VerifyEmployeesTable($connection, $dbName) {
  if(!TableExists("EMPLOYEES", $connection, $dbName))
  {
     $query = "CREATE TABLE EMPLOYEES (
         ID int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
         NAME VARCHAR(45),
         ADDRESS VARCHAR(90)
       )";

     if(!mysqli_query($connection, $query)) echo("<p>Error creating table.</p>");
  }
}

/* Check for the existence of a table. */
function TableExists($tableName, $connection, $dbName) {
  $t = mysqli_real_escape_string($connection, $tableName);
  $d = mysqli_real_escape_string($connection, $dbName);

  $checktable = mysqli_query($connection,
      "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_NAME = '$t' AND TABLE_SCHEMA = '$d'");

  if(mysqli_num_rows($checktable) > 0) return true;

  return false;
}
?>                        
                
									</div>

									



								</section>
								<header class="main">
								<h3>👋 留言板</h3>
							</header>	
								<form method="post" action="db/comment.php" onsubmit="return validateForm()">
									<div class="row gtr-uniform">
										<div class="col-6 col-12-xsmall">
											<input type="text" name="name" id="name" value="" placeholder="姓名" />
										</div>
										<div class="col-6 col-12-xsmall">
											<input type="email" name="email" id="email" value="" placeholder="電子郵件" />
										</div>
										
										
										<!-- Break -->
										<div class="col-12">
											<textarea name="message" id="message" placeholder="請在這裡輸入內容..." rows="6"></textarea>
										</div>
										
										<div class="g-recaptcha" data-sitekey="6LfCDxQmAAAAAAHt2kCgrA15iixN4ob3_HjMsWYq"></div>
										
										<!-- Break -->
										<div class="col-12">
											<ul class="actions">
												<li><input type="submit" value="傳送" class="primary" /></li>
											</ul>
										</div>
									
									</div>
								</form>
								<section>
									<header><h3>📋 留言內容</h3></header>
<?php
include('db/conn.php');
$sql = "SELECT * FROM comment";
$result = $connect->query($sql);

if ($result->rowCount() > 0) {
  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $name = $row['name'];
    $message = $row['message'];
    ?>

    <section class="comment">
      <div class="avatar">
	  <img src="assets/user.png" alt="User Avatar">
      </div>
      <div class="comment-content">
        <h3 class="username"><?php echo $name; ?></h3>
        <p class="message"><?php echo $message; ?></p>
      </div>
    </section>

    <?php
  }
}
?>


								</section>


								</section>
								
						</div>
					</div>
					
					<head>
						
					  </head>
							
					  <body>
						
						<!-- 浮動按鈕 -->
						

						<body>
							<div id="floating-button" onclick="scrollToTop()">
								<img src="assets/arrow-up.png" alt="Arrow" width="50" height="50">
							  </div>
							  <script>
								function scrollToTop() {
								  $('html, body').animate({
									scrollTop: 0
								  }, 'slow');
								}
							  </script>
						  </body>	
				<!-- Sidebar -->
					<div id="sidebar">
						<div class="inner">

							<!-- Search -->
							<section>
								<form action="
								https://cse.google.com/cse?cx=a6281ea9750794650" id="a6281ea9750794650">
									<input type="hidden" name="cx" value="a6281ea9750794650">
									<input type="hidden" name="ie" value="UTF-8">
									
									<input type="text" name="q" placeholder="站内搜尋">
									
									<button class="button primary icon solid fa-search" type="submit">搜尋</button>
								  </form>
								  
							</section>
							<!-- Menu -->
							<nav id="menu">
								<header class="major">
									<h2>Menu</h2>
								</header>
								<ul>
									<li><a href="index.php">🏠 首頁</a></li>
									<li><a href="photo_post/about.html">📂 關於作者 </a></li>
									
										
									<li><a href="photo_post/photo_index.html">📸 相簿</a></li>
									</li>
									<li><a href="feedback.php">💬 意見回饋</a></li>
									

										
									
								</ul>
							</nav>

							<section>
								<header class="major">
									<h2>📌 釘選文章</h2>
								</header>
								<div class="mini-posts">
									
									<article>
										
										<a href="1.php" class="image"><img src="images/pic01.jpg" alt="" /><br><br>
										<h3>如何賺錢</h3></a>

									</article>
									<article>
										
										<a href="photo_post/about.html" class="image"><img src="photo_post\assets\img\about\hi.PNG" alt="" /><br><br>
										<h3>自我介紹</h3></a>											
									</article>
								</div>
								
							</section>
						<!-- Section -->
							<section>
								<header class="major">
									<h2>☎️ 聯絡我</h2>
								</header>
								<p>This is fake</p>									
								<ul class="contact">
									<li class="icon solid fa-envelope"><a href="mailto:information@untitled.tld">information@untitled.tld</a></li>
									<li class="icon solid fa-phone">(000) 000-0000</li>
									<li class="icon solid fa-map">Somewhere Road<br /></li>
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
		<script src="assets/js/validateForm.js"></script>


		
</body>

</html>