<?php

class Command{
    private $contactManager;

    public function __construct(ContactManager $contactManager){
        $this->contactManager = $contactManager;
    }

    public function list(): void{                                                         //Méthode permettant l'affichage de la liste des contacts
        $contacts = $this->contactManager->findAll();

        foreach($contacts as $contact){
            echo $contact . "\n";
        }
    }

    public function detail(int $idDetail): void{                                              //Méthode permettant l'affichage d'un seul contact
        $contact = $this->contactManager->findById($idDetail);

        if($contact){
            echo $contact . "\n";
        } else{
            echo "Aucun contact trouvé avec l'ID : $idDetail\n";
        }
    }

    public function create($newName, $newEmail, $newPhone): void{                         //Méthode permettant de créer un nouveau contact en lui spécifiant un nom, un email et un numéro de tel

        if(!is_string($newName) || !filter_var($newEmail, FILTER_VALIDATE_EMAIL) || !preg_match('/^\d{10}$/', $newPhone)){
            $this->error();
        } else{
            $database = $this->contactManager->connexion();
            $requete = $database->prepare('INSERT INTO contacts(name, email, phone_number) VALUES (:name, :email, :phone_number)');
            $requete->execute([
                'name' => $newName,
                'email' => $newEmail,
                'phone_number' =>$newPhone,
            ]);
            echo("L'utilisateur " . htmlspecialchars($newName) . " à été créé avec succès !\n");
        }
    }
    
    public function delete($idDelete): void{                                              //Méthode permettant de supprimer un contact en indiquant son ID
        $contact = $this->contactManager->findById($idDelete);

        if($contact){
            $pdo = $this->contactManager->connexion();
            $requete = $pdo->prepare("DELETE FROM contacts WHERE id = :idDelete");
            $requete->execute([
                'idDelete' => $idDelete,
            ]);
            echo("L'utilisateur à été supprimé avec succès !\n");
        } else{
            echo "Aucun contact trouvé avec l'ID : $idDelete\n";
        }
    }
    
    public function help(): void{                                                         //Méthode affichant l'aide
        echo "\nhelp : affiche l'aide\n\nlist : liste les contact\n\ndetail [id] : affiche les détails d'un contace\n\ncreate [name], [email], [phone number] : crée un contact\n\ndelete [id] : supprime un contact\n\nexit : quitte le programme\n\n";
    }
    
    public function exit(): void{                                                         //Méthode permettant de quitter le programme
        die('So long !');
    }

    public function error(): void{                                                        //Méthode à appeler en cas d'erreur
        echo ("\nLa commande que vous avez rentrée contient une erreur, veuillez réessayer.\nPlus d'information : tapez help.\n\n");
    }
}