<?php

//namespace Services;

//Class pour la chargement automatique des classes
class Autoloader {

  //On enregistre dans des constantes de classe les entités, les services et les managers
  const ENTITIES = ["Account", "User"];
  const SERVICES= ["Autoloader", "Hydrator", "CheckForm"];
  const MANAGERS = ["AccountManager", "UserManager","Database"];

  //Fonction qui appelle l'autoload register qui se base sur la fonction statique loader
  static public function autoload() {
    spl_autoload_register('self::loader');
  }

  //Fonction qui require les fichiers selon leur nom de class
  //par exemple si le nom est trouvé dans le tableau des entités on charge une entité
  static public function loader($class){

    if(in_array($class, self::ENTITIES)) {
      require("../entities/" . $class . ".php");
    }
    elseif (in_array($class, self::MANAGERS)) {
      require("../models/" . $class . ".php");
    }
    elseif(in_array($class, self::SERVICES)) {
      require("../services/" . $class . ".php");
    }

  }
}

 ?>
