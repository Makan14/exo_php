<?php
$contenu = ''; // variable d'affichage

// Connexion à la BDD :
// ⚡️ pour Mac ⚡️
$pdo = new PDO(
    'mysql:host=localhost;dbname=contacts',// driver mysql (pourrait être oracle, IBM, ODBC...) + nom de la BDD
    'root', // pseudo de la BDD
//     '', // mdp de la BDD
    'root', // mdp de la BDD ⚡️ pour Mac ⚡️
    array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, // pour afficher les messages d'erreur SQL
        PDO::MYSQL_ATTR_INIT_COMMAND => 'set NAMES utf8'// définition du jeu de caractère des échanges avec la BDD
    )
);

// On sélectionne tous les contacts :
$query = $pdo->prepare("SELECT * FROM contact");
$query->execute(); // les méthodes prepare() et execute() vont TOUJOURS ensemble

// On prépare le tableau HTML :
$contenu .= '<table border="1">';
    $contenu .= '<tr>';
    $contenu .= '<th>Nom</th>';
    $contenu .= '<th>Prénom</th>';
    $contenu .= '<th>Téléphone</th>';
    $contenu .= '<th>Autres infos</th>';
    $contenu .= '</tr>';
    
    // Tant qu'il y a un résultat dans $query, on prépare la ligne de la table HTML correspondant au contact :
    while($contact = $query->fetch(PDO::FETCH_ASSOC)){
        // echo '<pre>';
        //     var_dump($contact);
        // echo '</pre>';  
        $contenu .= '<tr>';
            $contenu .= '<th>'. $contact['nom'].'</th>';
            $contenu .= '<th>'. $contact['prenom'].'</th>';
            $contenu .= '<th>'. $contact['telephone'].'</th>';
            // lien cliquable "plus d'infos" :   
            $contenu .= '<th><a href="?id_contact='. $contact['id_contact'] .'">Plus d\'infos</a></th>';
        $contenu .= '</tr>';    
}
$contenu .= '</table>';

// Si on a cliqué sur un lien "plus d'infos" :
if (isset($_GET['id_contact'])) { // si l'indice "id_contact" est dans $_GET, donc dans l'url, c'est qu'on a demandé le détail d'un contact
    // echo 'ligne 47 - echo';
    // die('ligne 47 - die');
    // exit('ligne 47 - exit');
    // on peut faire un echo, un exit ou un die pour vérifier que l'on passe bien dans cette condition
    
    $_GET['id_contact'] = htmlspecialchars($_GET['id_contact'], ENT_QUOTES); // permet de transformer les caractères spéciaux en entités HTML pour se prémunir des risques JS (XSS pour cross X script) et CSS

    // on fait une requête préparée de sélection du contact dans la BDD :
    $query = $pdo->prepare("SELECT * FROM contact WHERE id_contact = :id_contact");
    $query->bindParam(':id_contact', $_GET['id_contact']);
    $query->execute(); // avec un prepare TOUJOURS un execute()

    // on transforme le résultat de la requête en un array associatif :
    $contact = $query->fetch(PDO::FETCH_ASSOC); // pas de while car certain de n'avoir qu'un seul résultat

    // on affiche les infos du contact :
    $contenu .= '<h2>Détails du contact</h2>';

    // var_dump($contact); 
    // si l'id renseigné dans l'URL (la requete) n'existe pas 
    // dans query() il n'existe pas
    // et dans fetch() on aura un booléen : false

    if (!$contact) { // le contact n'existe pas 
        // die('68');
        $contenu .= '<p>Ce contact n\'existe pas.</p>';    
    } else {
        $contenu .= '<ul>';    
            $contenu .= '<li>'. $contact['nom'] .'</li>';  
            $contenu .= '<li>'. $contact['prenom'] .'</li>';  
            $contenu .= '<li>'. $contact['telephone'] .'</li>';  
            $contenu .= '<li>'. $contact['email'] .'</li>';  
            $contenu .= '<li>'. $contact['annee_rencontre'] .'</li>';  
            $contenu .= '<li>'. $contact['type_contact'] .'</li>';  
        $contenu .= '</ul>';   
    }


} // fin du if (isset($_GET['id_contact']))

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Liste des contacts</h1>

    <?php echo $contenu; ?>
    
</body>
</html>