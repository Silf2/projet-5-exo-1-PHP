<?php
    require_once "DBConnect.php";

    class ContactManager{
        private $dbConnect;

        public function findAll(){                                                  //Méthode permettant d'afficher la liste de tous les contacts
            $pdo = DBConnect::getPDO();

            $stmt = $pdo->query("SELECT * FROM contacts");
            $results = $stmt->fetchALL(PDO::FETCH_ASSOC);

            $contacts = [];
            foreach ($results as $data){                                            //Boucle permettant de remplir notre tableau contacts d'objets Contact
                $contacts[] = (new Contact())
                ->setId($data['id'])
                ->setName($data['name']);
            }

            return $contacts;
        }

        public function findById(int $idDetail): ?Contact{                                        //Méthode permettant d'afficher un seul contact spécifié
            $pdo = DBConnect::getPDO();

            $stmt = $pdo->prepare("SELECT * FROM contacts WHERE id = :idDetail");
            $stmt->execute([':idDetail' => $idDetail]);

            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if($data){
                $contact = new Contact();
                $contact->setId($data['id']);
                $contact->setName($data['name']);

                return $contact;
            }
            return null;
        }

        public function connexion(){                                                //Méthode permettant la connexion a la base de donnée en passant par la class ContactManager (et pas par DBConnect)
            return DBConnect::getPDO();
        }
    }