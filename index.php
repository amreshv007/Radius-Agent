<?php include 'header.php'; ?>
<h1 class="heading">Radius Agent</h1>
<!-- Form input of GitHub public Repository URL -->
<form name="form" action="scraped_data.php" method="GET" class="formclass">
	<label class="form_heading">Enter GitHub Repository URL:</label>
	<label>
		<input type="text" name="url" class="git_url" placeholder="Enter Name" />
	</label>
	<label>
		<input type="submit" name="submit" value="Submit" />
	</label>
</form>
<?php include 'footer.php'; ?>
	