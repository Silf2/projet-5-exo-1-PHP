<?php

class Contact{
    private $id;
    private $name;

    public function getId(): ?int{ //???
        return $this->id;
    }

    public function getName(): ?string{ //???
        return $this->name;
    }

    public function setId(?int $id): void{
        $this->id = $id;
    }

    public function setName(?string $name): void{
        $this->name = $name;
    }

    public function toString(): string{                                             //Méthode permettant d'afficher les contacts sous la forme demandée
        return "Contact [ID : {$this->id}, Name : {$this->name}]";
    }
}