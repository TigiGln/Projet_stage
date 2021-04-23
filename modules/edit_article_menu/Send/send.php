<link href="./modules/edit_article_menu/send/send.css" rel="stylesheet"/>
<div id="send" class="d-flex flex-column" data-article="[ID]">
	<div class="alert alert-secondary mt-0 mb-0 p-1">
		Once you send the article to someone else, unless the person sent it back to you, you will not be able to note, nor annotate it.
  	</div>
  	<!-- send data using js function to augment it and catch servers failure-->
	<div class="form-group">
		<label for="sendTo">Send To:</label>
		<input type="text" list="users" id="sendTo" name="sendTo" class="form-control" />
		<datalist id="users">
			<!--TODO: get users from database and print options -->
		    <option value="John">
		    <option value="Pierre">
		</datalist>
	</div>
	<button type="button" class="btn btn-success" onclick="validate([ID])">Send</button>
<script src="./modules/edit_article_menu/send/send-INTERACTIONS.js"></script>
</div>