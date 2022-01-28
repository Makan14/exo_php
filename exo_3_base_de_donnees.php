<?php 

/* 1- Créer une base de données "contacts" avec une table "contact" :
	  id_contact PK AI INT(3)
	  nom VARCHAR(20)
	  prenom VARCHAR(20)
	  telephone VARCHAR(10)
	  annee_rencontre (YEAR)
	  email VARCHAR(255)
	  type_contact ENUM('ami', 'famille', 'professionnel', 'autre')

	2- Créer un formulaire HTML (avec doctype...) afin d'ajouter un contact dans la bdd. Le champ année est un menu déroulant de l'année en cours à 100 ans en arrière à rebours, et le type de contact est aussi un menu déroulant.
	
	3- Effectuer les vérifications nécessaires :
	   Les champs nom et prénom contiennent 2 caractères minimum, le téléphone 10 chiffres
	   L'année de rencontre doit être une année valide
	   Le type de contact doit être conforme à la liste des types de contacts
	   L'email doit être valide
	   En cas d'erreur de saisie, afficher des messages d'erreurs au-dessus du formulaire

	4- Ajouter les contacts à la BDD et afficher un message en cas de succès ou en cas d'échec.

*/

$bdd = new PDO('mysql:host=localhost;dbname=contacts','root', '',array(
    
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, 
   
    PDO:: MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
));

// j initialise cs 2 variables a vide(ne rien mettre entre ls quotes mm pas 1 space car je vais en avoir bsoin sur ttes mes pages du sites)
$erreur = '';
$content = '';


if($_POST){ 
    if (!isset($_POST['nom']) || !preg_match("#^[a-z]{2,20}$#", $_POST['nom']) >= 2 || iconv_strlen($_POST['nom']) > 20) {
        $erreur .= '<div class="alert alert-danger" role>Erreur format Nom/marque !</div>';
    }

    if (!isset($_POST['prenom']) || !preg_match("#^[a-z]{2,20}$#", $_POST['prenom']) >= 2 || iconv_strlen($_POST['prenom']) > 20) {
        $erreur .= '<div class="alert alert-danger" role>Erreur format prenom/marque !</div>';
    }
     
    if (!isset($_POST['telephone']) || !preg_match("#^[0-9]{10}$#", $_POST['telephone'])) {
        $erreur .= '<div class="alert alert-danger" role>Erreur format telephone !</div>';
    }
      
    if (!isset($_POST['annee_rencontre']) || iconv_strlen($_POST['annee_rencontre']) <= 2 || iconv_strlen($_POST['annee_rencontre']) > 30) {
        $erreur .= '<div class="alert alert-danger" role>Erreur format annee_rencontre !</div>';
    }

    if (!isset($_POST['email']) || !preg_match("#^[0-9]{1,7}$#", $_POST['email'])) {
        $erreur .= '<div class="alert alert-danger" role>Erreur format email !</div>';
    }
 
    if (!isset($_POST['type_contact']) || $_POST['type_contact'] != 'ami' && $_POST['type_contact'] != 'famille' && $_POST['type_contact'] != 'professionnel' && $_POST['type_contact'] != 'autre') {
        $erreur .= '<div class="alert alert-danger" role>Erreur format type_contact !</div>';
    }

    if (empty($erreur)) {
        //syntaxe de la requete prepare
        $ajoutContact = $bdd->prepare("INSERT INTO contact (nom, prenom, telephone, annee_rencontre, email, type_contact, created_at) VALUES (:nom, :prenom, :telephone, :annee_rencontre, :email, :type_contact, NOW())");
        //: = pointeur nommé
        $ajoutContact->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);
        $ajoutContact->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);
        $ajoutContact->bindValue(':telephone', $_POST['telephone'], PDO::PARAM_INT);
        $ajoutContact->bindValue(':annee_rencontre', $_POST['annee_rencontre'], PDO::PARAM_STR);
        $ajoutContact->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $ajoutContact->bindValue(':type_contact', $_POST['type_contact'], PDO::PARAM_STR);
        $ajoutContact->execute();

        $content .= '<div class="alert alert-success alert-dismissible fade show mt-5" role="alert">
                            <strong>Félicitations !</strong> Ajout du contact réussie !
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <title>Formulaire</title>
</head>
<body>
    
    <header>
        <nav class="navbar navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand">Navbar</a>
                <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </nav>
    </header>

    <form method="post" action="" class="p-4">
        <div class="row mb-4 mt-5">
            <div class="col">
                <input type="text" class="form-control" placeholder="prenom" aria-label="prenom" name="prenom">
            </div>

            <div class="col">
                <input type="text" class="form-control" placeholder="nom" aria-label="nom" name="nom">
            </div>
        </div>

        <div class="form-floating mb-4">
            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Adresse e-mail</label>
        </div>

        <div class="num mb-4"> 
            <input type="telephone" id="telephone" placeholder="Numéro de téléphone" name="telephone">
        </div>

        <select class="form-select" aria-label="Default select example">
            <option selected>Selectionnez l'année</option>
            <?php 
                for($annee = date('Y'); $annee >= date('Y') - 100; $annee--){
                    // j'affiche la valeur de l'année dans le selecteur
                    echo "<option>$annee</option>";
                }              
            ?>
            
        </select>

        <button type="submit" class="btn btn-primary mt-4">Valider</button>
    </form>

</body>
</html>