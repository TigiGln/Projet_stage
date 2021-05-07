<?php
    require "./class_gestion_bd.php";
    require "./class_article.php";

    $objet = new ManagerDb('localhost', 'biblio', 'thierry', 'Th1erryG@llian0');
    $article = new Article('pubmed', '5646454gty', 'The - gene cluster of  encodes GH43- and GH62-α-l-...', 'The α-l-arabinofuranosidases (α-l-ABFs) are exoenz...', '2019', 'Biotechnology for biofuels', 'PMC6556953', '1', 'Auteurs last', '1');
    
    //var_dump($article);
    //$objet->object_attributes($article);

    //$objet->is_exist('article', 'num_access', '33469030');
    //$objet->fields_table('article');
    $objet->addDb($article, ['article', 'user']);

?>