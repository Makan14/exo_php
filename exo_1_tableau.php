<!-- vs creez 1 tableau PHP contenant ls pays suivants : france, italie, espagne, allemagne, inconnu auxquels vs associez ls valeurs suivantes : paris, rome, madrid, berlin, '?' -->

<!-- vs parcourez ce tableau pr afficher la phrase "la capitale X se situe en Y" dns 1 paragraphe (ou X remplace la capitale et Y le pays) -->

<!-- pr le pays inconu vs afficherez "ca n existe pas !" à la place de la phrase précédente. -->

<?php 
    //tableau de chaque pays
    $tab = array("France" => "Paris", "Italie" => "Rome", "Espagne" => "Madrid", "Allemagne" => "Berlin", "Inconnu" => "?");
    echo print_r ($tab);//affiche le tableau dns le navigateur
    
    foreach($tab as $key => $value){

        // var_dump ($tab);

        echo "<hr>";

        // var_dump ($key);
        echo "<hr>";

        // var_dump ($value);

        echo "<hr>";
        if ($key == "Inconnu") {
            echo "<p> Ca n'existe pas </p>";
        }else {
            echo "<p>La capitale " . $value . " se situe en " . $key . "</p>";

        }
    }
    

?>