<!DOCTYPE html>
<html>
	<head>
		<?php require_once('header.php'); ?>
	</head>
	<body id="bodyy">
		<form name="form" action="scraped_data.php" method="GET" class="formclass">
			<label>Enter Github Repository URL:
				<input type="text" name="url" placeholder="Enter Name" />
			</label>
			<label>
				<input type="submit" name="submit" value="Submit" />
			</label>
		</form>
	</body>
</html>