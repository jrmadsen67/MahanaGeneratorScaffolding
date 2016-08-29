<?php
namespace jrmadsen67\MahanaScaffolding\FileParsers;

use Symfony\Component\Yaml\Parser;

class YamlParser extends Parser{

    public function parseFile($yamlFileContents)
    {
        return $this->parse($yamlFileContents);
    }

}