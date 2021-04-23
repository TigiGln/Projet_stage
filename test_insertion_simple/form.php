<?php
    session_start();
    include('header.html');
?>
<?php
    include("menu.html");
?>
        <form method="get" action="result.php" enctype="multipart/form-data">
            <select name="list_query" id="list_query">
                <option value="PMID">PMID</option>
                <option value="ELocationID">DOI</option>
                <option value="Author">Author</option>
                <option value="Title">Title</option>
                <option value="dp">Year</option>
            </select>
            <p>
                <textarea name="textarea" id="textarea" cols="50" rows="4"></textarea>
            </p>
            <p>
                <label for="file">My file</label>
                <input type="file" name="myfile" id="file" accept=".txt">
            </p>
            <p>
                <input type="submit" value="Start search">
            </p>
        </form>
<?php      
    include('footer.html');
?>