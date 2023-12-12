<?php
    class ContactManager{
        private $dbConnect;

        public function __construct(DBConnect $dbConnect){
            $this->dbConnect = $dbConnect;
        }

        public function findAll(){                                                  //Méthode permettant d'afficher la liste de tous les contacts
            $dbConnect = $this->dbConnect;
            $pdo = $dbConnect->getPDO();

            $stmt = $pdo->query("SELECT * FROM contacts");
            $results = $stmt->fetchALL(PDO::FETCH_ASSOC);

            $contacts = [];
            foreach ($results as $data){                                            //Boucle permettant de remplir notre tableau contacts d'objets Contact
                $contact = new Contact();
                $contact->setId($data['id']);
                $contact->setName($data['name']);
                $contacts[] = $contact;
            }

            return $contacts;
        }

        public function findById($idDetail){                                        //Méthode permettant d'afficher un seul contact spécifié
            $dbConnect = $this->dbConnect;
            $pdo = $dbConnect->getPDO();

            $stmt = $pdo->prepare("SELECT * FROM contacts WHERE id = :idDetail");
            $stmt->execute([':idDetail' => $idDetail]);

            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if($data){
                $contact = new Contact();
                $contact->setId($data['id']);
                $contact->setName($data['name']);

                return $contact;
            }else{
                return null;
            }
        }

        public function connexion(){                                                //Méthode permettant la connexion a la base de donnée en passant par la class ContactManager (et pas par DBConnect)
            $dbConnect = $this->dbConnect;
            $pdo = $dbConnect->getPDO();
            return $pdo;
        }
    }