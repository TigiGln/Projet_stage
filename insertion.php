<?php
//CLASS IMPORT
include('./POO/main_menu.class');
?>

<?php
include('./views/header.html');

//Menu
(new mainMenu('Insertion'))->write();
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
					<small class="text-muted"><span>&#8593;</span> Click to change type</small>
				</div>
			  <textarea name="insert_text" id="insert" class="form-control m-1" rows="4"></textarea>
			</div>
			<div class="mb-3">
				<label for="formFile" class="form-label"></label>
				<input class="form-control" name="myfile" type="file" id="file" accept=".txt", ".doc", ".docx", ".odt">
			</div>
		</fieldset>
		<input type="submit" value="Start seach" class="btn btn-outline-success" />
	</form>
</div>

<?php
include('./views/footer.html');
?>