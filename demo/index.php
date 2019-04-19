<?php
	require_once("../lib/multilang.php");

	multilang::set("dir", "langs/");
	multilang::setup();

?>
<!DOCTYPE html>
<html>
	<head>
		<title>multilangPHP - Demo Page</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- FONT -->
		<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,700" rel="stylesheet">
		<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css'>

		<!-- CSS -->
		<link href="theme/style.css" rel="stylesheet">
	</head>
	<body>
		<div class="menu">
			<div class="menu_alan">
				<div class="logo">multilangPHP <sup>v1.0.0</sup></div>
				<div class="link">
					<a href="#link1"><?=multilang::lang("link1")?></a>
					<a href="#link2"><?=multilang::lang("link2")?></a>
					<a href="#link3"><?=multilang::lang("link3")?></a>
				</div>
			</div>
		</div>
		<div class="dil_sec">
			<?php
				echo '<p>'.multilang::lang("select").'</p>';
				echo multilang::listlang("html");
			?>
		</div>
		<div class="box_alan">
			<h4>
			<?php
				echo sprintf(multilang::lang("select_log"), multilang::get("lang", 1));	
			?>
			</h4>
			<p><?=multilang::lang("t_e")?></p>
			<p><?=multilang::lang("t_e_no")?></p>
		</div>
		<div class="box_alan">
			<h3>multilangPHP Logs</h3>
			<div class="logs">
				<?php
					foreach (multilang::get("log", 1) as $i => $log) {
						echo sprintf('<p> [%s] %s</p>', $i, $log);
					}
				?>
			</div>
		</div>
		<footer>
			&copy; 2019 - Melih Berat ŞANLI
		</footer>
	</body>
</html>