<!DOCTYPE HTML>
<html lang="zh-TW">
	<head>
	
		<title>林恩佑的網站 11111110</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		
		<link type="image/png" sizes="96x96" rel="icon" href="assets/icons8-hard-working-96.png">
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		
	
	</head>
	
	<body class="is-preload">

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Main -->
					<div id="main">
						<div class="inner">

							<!-- Header -->
								<header id="header">
									<a href="/" class="logo"><h2><strong>林恩佑的網站 11111110</strong></h2> by Ian</a>
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

							<!-- Banner -->
								<section id="banner">
									<div class="content">
										<header>
											<h1>Hi, My name is Ian</h1>
											<p>I am a college student majoring in Computer Science and Information Engineering.</p>
											
										</header>
										<p></p>
										<ul class="actions">
											<li><a href="photo_post/about.html" class="button big">了解更多</a></li>
										</ul>
									</div>
									
								</section>
							
								<section id="banner">
									<div class="jumbotron">
      <p>
		
      <?php

  echo "<table class='table table-bordered'>";
  echo "<tr><th>Meta-Data</th><th>Value</th></tr>";

  # Get the instance ID from meta-data and print to the screen
  $instance_id = shell_exec('ec2-metadata --instance-id 2> /dev/null | cut -d " " -f 2');
  # if its not set make it 0
  if (empty($instance_id)) {
      $instance_id = 0;
  }
  echo "<tr><td>InstanceId</td><td><i>";
  echo $instance_id;
  "</i></td><tr>";

  # Availability Zone
  $az = shell_exec('ec2-metadata -z 2> /dev/null | cut -d " " -f 2');
  # if its not set make it 0
     if (empty($az)) {
         $az = 0;
  }
  echo "<tr><td>Availability Zone</td><td><i>";
  echo  $az;
  "</i></td><tr>";

  echo "</table>";

  # This code performs a simple vmstat and grabs the current CPU idle time
  $idleCpu = exec('vmstat 1 2 | awk \'{ for (i=1; i<=NF; i++) if ($i=="id") { getline; getline; print $i }}\'');

  # Print out the idle time, subtracted from 100 to get the current CPU utilization
  echo "<br /><p>Current CPU Load: <b>"; 
  echo 100-$idleCpu;
  echo "%</b></p>";

?>

      <hr />

      
			</p>
     
    </div>


	<div>
		
	</div>
</section>

								
							<!-- Posts -->
							<section>
								<header class="major">
									<h2>AWS</h2>
								</header>
								<div class="posts">
									<article>
										<a href="aws/lab-app/index.php" class="image"><img src="https://a0.awsstatic.com/libra-css/images/logos/aws_logo_smile_1200x630.png" alt="aws" /></a>
										<h3>AWS</h3>
										 
										<ul class="actions">
											<li><a href="aws/lab-app/index.php" class="button">More</a></li>
										</ul>
									</article>
									<article>
									<a href="/SamplePage.php" class="image"><img src="https://picsum.photos/1200/630" alt="picsum.photos.example"/></a>
										<h3>SamplePage.php</h3>
										 
										<ul class="actions">
											<li><a href="/SamplePage.php" class="button">More</a></li>
										</ul>
									</article>
									
								</section>
								

						</div>
					</div>
					
						
						<!-- 浮動按鈕 -->
						<body>
						<div id="floating-button" onclick="scrollToTop()">
							<img src="assets/arrow-up.png" alt="Arrow" width="50" height="50" >
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

							<!-- Search 
							
							<section>
								<form action="
								https://cse.google.com/cse?cx=a6281ea9750794650" id="a6281ea9750794650">
									<input type="hidden" name="cx" value="a6281ea9750794650">
									<input type="hidden" name="ie" value="UTF-8">
									
									<input type="text" name="q" placeholder="站内搜尋">
									<button type="submit">搜尋</button>
								  </form>
								  
							</section>-->
							


							<!-- Menu -->
							<nav id="menu">
								<header class="major">
									<h2>Menu</h2>
								</header>
								<ul>
									<li><a href="/">🏠 首頁</a></li>
									<li><a href="photo_post\about.html">📂 關於作者</a></li>
									
									<li><a href="photo_post/photo_index.html">📸 相簿</a></li>
									</li>
									
									

										
									
								</ul>
							</nav>
							
							<!-- Section -->
								
								

							<!-- Section -->
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
