<?php namespace jrmadsen67\MahanaScaffolding;

use jrmadsen67\MahanaScaffolding\Parsers\ModelParser;
use Symfony\Component\Yaml\Parser;
//use Illuminate\Filesystem\Filesystem;

class MahanaScaffolding
{

    protected $yaml;

    protected $yamlFilePath;

    protected $yamlFileName;

    protected $yamlContentsArray = [];

    protected $modelsArray = [];

    protected $controllersArray = [];

    protected $commandsArray = [];

    protected $consolesArray = [];

    protected $eventsArray = [];

    protected $jobsArray = [];

    protected $listenersArray = [];

    protected $middlewaresArray = [];

    protected $policiesArray = [];

    protected $providersArray = [];

    protected $requestsArray = [];

    protected $seedersArray = [];

    protected $testsArray = [];


    public function __construct($filepath = '', $filename = 'genscaffolding.yml')
    {
        $this->yaml = new Parser();

        $this->setYamlFilePath($filepath);

        $this->setYamlFileName($filename);
    }

    public function generate()
    {

        $this->parseYaml();

        $this->setModelsArray();
        $this->setControllersArray();

        $this->generateModels();
        $this->generateControllers();

    }

    public function setYamlFilePath($filepath)
    {
        if (empty($filepath))
        {
            $filepath = base_path();
        }    
        $this->yamlFilePath = $filepath;
    }

    public function setYamlFileName($filename)
    {

        $this->yamlFileName = $filename;
    }

    public function getYamlFileContents()
    {
        return file_get_contents($this->yamlFilePath . '/' . $this->yamlFileName);
    }

    public function parseYaml()
    {

        $yamlFileContents = $this->getYamlFileContents();

        $this->yamlContentsArray = $this->yaml->parse($yamlFileContents);

    }

    public function setModelsArray()
    {
        if (isset($this->yamlContentsArray['models']))
        {
            $this->modelsArray = $this->yamlContentsArray['models'];
        }                
    }

    // NOTE: has --migration flag, but we won't use I think
    public function generateModels()
    {
        foreach ($this->modelsArray as $item){

            $modelParser = new ModelParser($item);

            $args['name'] = $modelParser->getName();
            $args['--table'] = $modelParser->getTableName();
            $args['--primary'] = $modelParser->getPrimary();
            $args['--fillable'] = $modelParser->getFillable();
            $args['--dates'] = $modelParser->getDates();

            $args = array_filter($args);

            \Artisan::call('mahana:model', $args);

            // Migrations -
            // TODO: add a flag to include or no
            // TODO: allow turning off increments, timestamps
            $migration['name'] = 'create_' . strtolower($args['name']) . '_table';
            $migration['--schema'] = $modelParser->getFields();
            $migration['--model'] = false;
            \Artisan::call('make:migration:schema', $migration);

        }
    }


    public function setControllersArray()
    {
        if (isset($this->yamlContentsArray['controllers']))
        {
            $this->controllersArray = $this->yamlContentsArray['controllers'];
        }                
    }

    public function generateControllers()
    {
        foreach ($this->controllersArray as $item){

            // do necessary cleanup
            $name = $item['name'];

            \Artisan::call('make:controller', ['name'=> $name]);
        }
    }

//    public function generateMigrations()
//    {
//        # code...
//    }


    public function setCommandsArray()
    {
        if (isset($this->yamlContentsArray['commands']))
        {
            $this->commandsArray = $this->yamlContentsArray['commands'];
        }                
    }

    public function generateCommands()
    {
        foreach ($this->commandsArray as $item){

            // do necessary cleanup
            $name = $item['name'];

            \Artisan::call('make:command', ['name'=>   $name]); // handler, queued
        }
    }

    public function setConsolesArray()
    {
        if (isset($this->yamlContentsArray['consoles']))
        {
            $this->consolesArray = $this->yamlContentsArray['consoles'];
        }                
    }

    public function generateConsoles()
    {
        foreach ($this->consolesArray as $item){

            // do necessary cleanup
            $name = $item['name'];

            \Artisan::call('make:console', ['name'=>   $name]); //command
        }
    }

    public function setEventsArray()
    {
        if (isset($this->yamlContentsArray['events']))
        {
            $this->eventsArray = $this->yamlContentsArray['events'];
        }                
    }

    public function generateEvents()
    {
        foreach ($this->eventsArray as $item){

            // do necessary cleanup
            $name = $item['name'];

            \Artisan::call('make:event', ['name' => $name]); // handler, queued
        }
    }

    public function setJobsArray()
    {
        if (isset($this->yamlContentsArray['jobs']))
        {
            $this->jobsArray = $this->yamlContentsArray['jobs'];
        }                
    }

    public function generateJobs()
    {
        foreach ($this->jobsArray as $item){

            // do necessary cleanup
            $name = $item['name'];

            \Artisan::call('make:job', ['name' => $name]);
        }
    }

    public function setListenersArray()
    {
        if (isset($this->yamlContentsArray['listeners']))
        {
            $this->listenersArray = $this->yamlContentsArray['listeners'];
        }                
    }

    public function generateListeners()
    {
        foreach ($this->listenersArray as $item){

            // do necessary cleanup
            $name = $item['name'];

            \Artisan::call('make:listener', ['name' => $name]); 
        }
    }

    public function setMiddlewareArray()
    {
        if (isset($this->yamlContentsArray['middleware']))
        {
            $this->middlewareArray = $this->yamlContentsArray['middleware'];
        }                
    }

    public function generateMiddleware()
    {
        foreach ($this->middlewareArray as $item){

            // do necessary cleanup
            $name = $item['name'];

            \Artisan::call('make:middleware', ['name' => $name]); 
        }
    }

    public function setPoliciesArray()
    {
        if (isset($this->yamlContentsArray['policies']))
        {
            $this->policiesArray = $this->yamlContentsArray['policies'];
        }                
    }

    public function generatePolicies()
    {
        foreach ($this->policysArray as $item){

            // do necessary cleanup
            $name = $item['name'];

            \Artisan::call('make:policy', ['name' => $name]); 
        }
    }


    
}