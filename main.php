<?php

require_once './class/DBConnect.php';
require_once './class/ContactManager.php';
require_once './class/Contact.php';
require_once './class/Command.php';

$dbConnect = new DBConnect;
$contactManager = new ContactManager($dbConnect);
$command = new Command($contactManager);

while (true) {
    $line = readline("Entrez votre commande : ");
    echo "Vous avez saisi : $line\n";   

    $parts = explode(' ', $line);                                           //Séparation de la chaine de caractère $line pour utiliser les commandes écrites en plusieurs mots (create, detail et delete)
    $commandType = $parts[0];

    if($line == 'list'){                                                    //Si la commande est list, on appel la méthode list
        $command->list();
    }
    elseif($commandType == "detail"){                                       //Si la commande est detail [idValide], on appel la méthode detail
        if($line == "detail"){                                      //rajouté pour provoquer une erreur si on écrit "detail" sans espace, vus que le explode ne trigger qu'a l'espace
            $command->error();
        }
        else{
            $idDetail = $parts[1];                                  //On récupère l'id depuis notre explode
            if(!is_numeric($idDetail)){                             //Vérification que l'id est bien un chiffre
                $command->error();
            }else{
                $command->detail($idDetail);
            }
        }
    }
    elseif($commandType == "create"){                                       //Si la commande est create [nom], [email], [numéro_de_telephone], on appel la méthode create
        $excludeCreate = array_slice($parts, 1);
        $createComponents = explode(', ', implode(' ', $excludeCreate));    //Création d'un nouveau tableau pour récupérer les nom, email et numéro en excluant create (le nom de la commande)

        if($line == "create" || count($createComponents) != 3){             //Vérification que la ligne est valide et que createComponents contient bien 3 arguments
            $command->error();
        } else{
            $command->create($createComponents[0], $createComponents[1], $createComponents[2]);
        }
    }
    elseif($commandType == "delete"){                                       //Si la commande est delete [idValide], on appel la méthode delete
        if($line == "delete"){                                              //Vérification de si la ligne de commande est valide
            $command->error();
        }else{                          
            $idDelete = $parts[1];
            if(!is_numeric($idDelete)){                                     //Vérification que l'id est valide
                $command->error();
            }else{
                $command->delete($idDelete);
            }
        }
    }                                                   
    elseif($line == 'help'){                                                //Si la commande est help, on appel la méthode help
        $command->help();
    }
    elseif($line == 'exit'){                                                //Si la commande est exit, on appel la méthode exit (et on sort du programme)
        $command->exit();
    }
    else{                                                                   //Si la commande ne correspond a rien de tout le reste, on appel la méthode error
        $command->error();
    }
}

