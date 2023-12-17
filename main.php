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

    switch($line){
        case "list":                                                                                                //Si la commande est list, on appel la méthode list
            $command->list();
            break;
        case preg_match('/^detail\s+(\d+)$/', $line, $matches) ? true : false:                                       //Si la commande est detail [idValide], on appel la méthode detail
            $idDetail = $matches[1];                                                                                 //On récupère l'id depuis notre commande
            $command->detail((int) $idDetail);
            break;   
        case preg_match('/^create\s+([^,]+),\s+([^,]+),\s+([^,]+)$/', $line, $matches) ? true : false:               //Si la commande est create [nom], [email], [numéro_de_telephone], on appel la méthode create
            $command->create($matches[1], $matches[2], $matches[3]);
            break;
        case preg_match('/^delete\s+(\d+)$/', $line, $matches) ? true : false:                                       //Si la commande est delete [idValide], on appel la méthode delete                        
            $idDelete = $matches[1];
            $command->delete($idDelete);       
            break;             
        case 'help':                                                                                                 //Si la commande est help, on appel la méthode help
            $command->help();
            break;
        case 'exit':                                                                                                 //Si la commande est exit, on appel la méthode exit (et on sort du programme)
            $command->exit();
            break;
        default:
            $command->error();
            break;
    }
}

