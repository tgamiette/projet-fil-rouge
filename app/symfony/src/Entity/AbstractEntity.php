<?php

namespace App\Entity;

class AbstractEntity {

    public function __construct(array $array = null) {
        if ($array) {
            $this->hydrate($array);
        }
    }

    public function hydrate(array $donnees): void {
        foreach ($donnees as $key => $value) {
            // On récupère le nom du setter correspondant à l'attribut
            $method = 'set' . ucfirst($key);

            // Si le setter correspondant existe.
            if (method_exists($this, $method)) {
                // On appelle le setter
                $this->$method($value);
            }
        }
    }
}
