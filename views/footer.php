	    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
		<script src="../trie_table_statut/sort_status.js"></script>
		<script>
			function refreshPopovers() 
			{
  				var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
  				var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
    				return new bootstrap.Popover(popoverTriggerEl)
  				});
			}
			refreshPopovers()
		</script>
	</body>
</html>