<?php
include('./views/header.html');

//Security for now: if the cookie isn't set
$menu = 'insert'; //To save where we are so the menu can add the active tag
//Menu
include('./views/menu.php');
?>

<div class="p-4 w-100">
	<form id="insertForm" method="post" action="insertion-results.php" enctype="multipart/form-data">
		<fieldset><legend><h2>Search for Insertion</h2></legend> <!-- fieldset title -->
			<div class="input-group">
				<div class="col-sm-1 m-1"> 
					<span></span>
					<select name="list_query" id="list_query" class="form-control input-sm">
						<option value="PMID">PMID</option>
						<option value="ELocationID">DOI</option>
						<option value="Author">Author</option>
						<option value="Title">Title</option>
						<option value="Date-Publication">Year</option>
					</select>
					</p>
					<p>
					<textarea name="insert_text" id="insert" cols="50" rows="4"></textarea>
					</p>
					<p>
					<label for="file"></label><br>
					<input type="file" name="myfile" id="file" accept=".txt", ".doc", ".docx", ".odt"/>
					</p>
			</fieldset>
			<p>
				<input type="submit" value="Start search" />
			</p>
		</form>
			
	</body>
</html>

<?php
include('./views/footer.html');
?>