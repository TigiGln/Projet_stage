function check(source) {
checkboxes = document.querySelectorAll("input[name^='check']");
for(var i=0, n=checkboxes.length;i<n;i++) {
checkboxes[i].checked = source.checked;
}
}
		