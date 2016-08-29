<?php

namespace jrmadsen67\MahanaScaffolding\Parsers;

use Illuminate\Support\Collection;

class BaseParser{

    public $itemArray;

    public $name;

    public $stub;

    function __construct($itemArray)
    {
        $this->itemArray = new Collection($itemArray);

        $this->setName();

        $this->setStub();
    }

    function getName(){
        return $this->name;
    }

    function setName(){
        $this->name = $this->itemArray->get('name', '');
    }

    function getStub(){
        return $this->stub;
    }

    function setStub(){
        $this->stub = $this->itemArray->get('stub', '');
    }
}