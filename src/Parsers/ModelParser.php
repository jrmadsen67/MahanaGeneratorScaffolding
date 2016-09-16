<?php
/**
 * Created by PhpStorm.
 * User: jmadsen
 * Date: 8/25/2016
 * Time: 5:25 PM
 */

namespace jrmadsen67\MahanaScaffolding\Parsers;

use Illuminate\Support\Collection;

class ModelParser extends BaseParser
{
    public $tableName;

    public $fields;

    public $primaryKey;

    public $fillable;

    public $dates;

    public $defaults;

    function __construct($itemArray)
    {
        parent::__construct($itemArray);

        $this->setTableName($this->itemArray->get('table', ''));
        $this->setPrimary($this->itemArray->get('primary_key', ''));

        $this->parseFields($this->itemArray->get('fields', []));

    }

    function includeMigration(){
        return $this->itemArray->get('migration', false);
    }

    function getTableName(){
        return $this->tableName;
    }

    function setTableName($item){
        $this->tableName = $item;
    }

    function getPrimary(){
        return $this->primaryKey;
    }

    function setPrimary($item){
        $this->primaryKey = $item;
    }

    function getFillable(){
        if (empty($this->fillable)){
            return '';
        }

        return implode(',', $this->fillable);
    }

    function setFillable($item){
        $this->fillable[] = $item;
    }

    function getDates(){
        if (empty($this->dates)){
            return '';
        }

        return implode(',', $this->dates);
    }

    function setDates($item){
        $this->dates[] = $item;
    }

    function getDefaults(){
        if (empty($this->defaults)){
            return '';
        }

        return implode(',', $this->defaults);
    }

    function setDefaults($item){
        $this->defaults[] = $item;
    }

    function getFields(){
        if (empty($this->fields)){
            return '';
        }

        // NOTE: the space between fields is required for Jeffrey Way gnerators
        return implode(', ', $this->fields);
    }

    public function parseFields($items)
    {
        (new Collection($items))->each(function($field, $key){
            if (!empty($field['fillable'])){
                $this->setFillable($key);
            }

            if (!empty($field['dates'])){
                $this->setDates($key);
            }

            if (!empty($field['default'])){
                $this->setDefaults($key);
            }

            $this->fields[$key] = $this->buildFieldString($key, $field);
        });
    }

    // Example return:
    // email:string:unique(:nullable)
    public function buildFieldString($key, $field){

        $build[] = $key;
        $build[] = $field['type'];

        if (!empty($field['unique'])){
            $build[] = 'unique';
        }

        if (!empty($field['nullable'])){
            $build[] = 'nullable';
        }

        if (!empty($field['default'])){
            $build[] = sprintf('default("%s")', $field['default']);
        }

        return implode(':', $build);
    }
}