<link href="./utils/notes/notes.css" rel="stylesheet"/>
<div id="notes" class="notesEditor d-flex flex-column">

<div id="notesEditor" class="notesEditor d-flex flex-column">
	<div class="notesToolbar">
	<div class="alert alert-secondary mt-0 mb-0">Your notes:</div>
	<div class="line bg-light">
	<div class="notesBox">
		<span class="notesAction" data-action="bold" title="Bold">
			<img src="https://image.flaticon.com/icons/svg/25/25432.svg">
		</span>
		<span class="notesAction" data-action="italic" title="Italic">
			<img src="https://image.flaticon.com/icons/svg/25/25392.svg">
		</span>
		<span class="notesAction" data-action="underline" title="Underline">
			<img src="https://image.flaticon.com/icons/svg/25/25433.svg">
		</span>
		<span class="notesAction" data-action="createLink" title="Insert Link">
			<img src="https://image.flaticon.com/icons/svg/25/25385.svg">
		</span>
		<span class="notesAction" data-action="unlink" title="Unlink">
			<img src="https://image.flaticon.com/icons/svg/25/25341.svg">
		</span>
		<span class="notesAction" data-action="undo" title="Undo">
			<img src="https://image.flaticon.com/icons/svg/25/25249.svg">
		</span>
		<span class="notesAction" data-action="removeFormat" title="Remove format">
			<img src="https://image.flaticon.com/icons/svg/25/25454.svg">  
		</span>
		<span id="notesCode" class="notesAction" data-action="code" title="Show HTML-Code">
			<img src="https://image.flaticon.com/icons/svg/25/25185.svg">
		</span>
		<button id="notesSave" type="button" onclick="notesSave(<?php echo $PMCID ?>)" class="btn btn-success">S</button>
	</div>
	</div>
	<div id="notesArea">
		<div id="notesVisualView" contenteditable="true"></div>
	<textarea id="notesHtmlView"></textarea>
	</div>
</div>

<div class="alert alert-secondary mt-0 mb-0">Notes Thread:</div>
<div id="notesThread" class="notesThread overflow-auto alert alert-light mt-0 mb-0">
	<!---->
</div>
<script src="./utils/notes/notes-INTERACTIONS.js"></script>
<script src="./utils/notes/notes-WYSIWYG.js"></script>
</div>