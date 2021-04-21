<link href="./utils/comment/comment.css" rel="stylesheet"/>
<div id="subMenu">
	<div id="editor" class="editor d-flex flex-column" style="pointer-events: none; user-select: none;">
	  <div class="toolbar">
	  	<div class="alert alert-secondary mt-0 mb-0">Selection:</div>
		<div class="selected overflow-auto alert-light mt-0 mb-0">
			<div id="selection"></div>
	  	</div>
	  	<div class="alert alert-secondary mt-0 mb-0">Write a comment:</div>
	    <div class="line bg-light">
	      <!-- Actions -->
	    <div class="box">
	        <span class="action" data-action="bold" title="Bold">
	          <img src="https://image.flaticon.com/icons/svg/25/25432.svg">
	        </span>
	        <span class="action" data-action="italic" title="Italic">
	          <img src="https://image.flaticon.com/icons/svg/25/25392.svg">
	        </span>
	        <span class="action" data-action="underline" title="Underline">
	          <img src="https://image.flaticon.com/icons/svg/25/25433.svg">
	        </span>
	        <span class="action" data-action="createLink" title="Insert Link">
	          <img src="https://image.flaticon.com/icons/svg/25/25385.svg">
	        </span>
	        <span class="action" data-action="unlink" title="Unlink">
	          <img src="https://image.flaticon.com/icons/svg/25/25341.svg">
	        </span>
	        <span class="action" data-action="undo" title="Undo">
	          <img src="https://image.flaticon.com/icons/svg/25/25249.svg">
	        </span>
	        <span class="action" data-action="removeFormat" title="Remove format">
	          <img src="https://image.flaticon.com/icons/svg/25/25454.svg">  
	        </span>
	        <span id="code" class="action" data-action="code" title="Show HTML-Code"></span>
	        <input id="colorPicker" type="color" class="align-middle" value="#ffff00">
	        <button id="comment-save" type="button" onclick="commentSend(<?php echo $PMCID ?>)" class="btn btn-success">S</button>
	        <button id="comment-abort" type="button" onclick="commentClose()" class="btn btn-danger">X</button>
	    </div>
	  	</div>
	  <div id="comment-area">
	     <div id="visual-view" contenteditable="true"></div>
	    <textarea id="html-view"></textarea>
	  </div>
	</div>
	<div class="alert alert-secondary mt-0 mb-0">Comments Thread:</div>
	<div id="comments" class="thread overflow-auto alert alert-light mt-0 mb-0">
		<!---->
  	</div>
	<script src="./utils/comment/comment-INTERACTIONS.js"></script>
	<script src="./utils/comment/comment-WYSIWYG.js"></script>
</div>
</div>