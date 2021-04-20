<link href="./utils/wysiwyg/wysiwyg.css" rel="stylesheet"/>
<div id="subMenu">
    <!-- Toast success -->
	<div id="editor" class="editor d-flex flex-column sticky-top" style="height: 100vh;">
	  <div class="toolbar">
		<div class="selected overflow-auto">
			<div id="selection" class="alert alert-info" role="alert"></div>
	  	</div>
	    <div class="line">
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
	        <!--<span class="action" data-action="strikeThrough" title="Strike through">
	          <img src="https://image.flaticon.com/icons/svg/25/25626.svg">
	        </span>-->
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
	        <span id="code" class="action" data-action="code" title="Show HTML-Code">
	          <!--<img src="https://image.flaticon.com/icons/svg/25/25185.svg">-->
	        </span>
	        <input id="colorPicker" type="color" class="align-middle" value="#ffff00">
	        <button id="Save" type="button" onclick="commentSend(<?php echo $PMCID ?>)" class="btn btn-success">S</button>
	        <button type="button" onclick="commentClose()" class="btn btn-danger">X</button>
	    </div>
	  	</div>
	  <div id="comment-area">
	     <div id="visual-view" contenteditable="true"></div>
	    <textarea id="html-view"></textarea>
	  </div>
	</div>
	<br>
	<div class="alert alert-info">Comments Thread:</div>
	<div id="comments" class="thread overflow-auto">
		<!---->
  	</div>
  	<br>
  	<div class="alert alert-info">CAZy:</div>
	<div id="array" class="overflow-auto">
		<!---->
  	</div>
	<script src="./utils/wysiwyg/wysiwyg.js"></script>
</div>
</div>