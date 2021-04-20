<!DOCTYPE html >
<html lang="en">
	<head>
        	<meta charset="utf-8" />
        	<title>Page de recherche d'article</title>
    	</head>
    	<body>
		<form method="post" action="insertion2.php" enctype="multipart/form-data">
			<fieldset><legend>Your search for insertion</legend> <!-- Titre du fieldset -->
					<p>
					<select name="list_query" id="list_query">
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

