<?php

class Contact{
    private $id;
    private $name;

    public function getId(): ?int{ 
        return $this->id;
    }

    public function getName(): ?string{ 
        return $this->name;
    }

    public function setId(?int $id): self{
        $this->id = $id;
        return $this;
    }

    public function setName(?string $name): self{
        $this->name = $name;
        return $this;
    }

    public function __toString(): string{                                             //Méthode permettant d'afficher les contacts sous la forme demandée
        return "Contact [ID : {$this->id}, Name : {$this->name}]";
    }
}