<?php

namespace jrmadsen67\MahanaScaffolding\Parsers;

use Illuminate\Support\Collection;

class BaseParser{

    public $itemArray;

    public $name;

    function __construct($itemArray)
    {
        $this->itemArray = new Collection($itemArray);

        $this->setName();
    }

    function getName(){
        return $this->name;
    }

    function setName(){
        $this->name = $this->itemArray->get('name', '');
    }
}