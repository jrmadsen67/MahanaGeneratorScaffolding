<?php namespace jrmadsen67\MahanaScaffolding;

use jrmadsen67\MahanaScaffolding\FileParsers\YamlParser;

use jrmadsen67\MahanaScaffolding\Parsers\ModelParser;

//use Illuminate\Filesystem\Filesystem;

class MahanaScaffolding
{

    protected $parser;

    protected $filePath;

    protected $fileName;

    protected $fileContentsArray = [];

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


    public function __construct($format = 'yaml')
    {
        if ($format == 'yaml'){
            $this->parser = new YamlParser();
        }
    }

    public function generate()
    {
        $this->setFilePath();

        collect($this->getFileArray())->each(function($filename){
            $this->setFileName($filename);
            $this->parseFile($this->getFileContents());

            $this->setModelsArray();
            $this->setControllersArray();

            $this->generateModels();
            $this->generateControllers();
        });


    }

    public function setFilePath()
    {
        $this->filePath = base_path(config('mahana-scaffolding.base_dir'));
    }

    public function getFileArray(){
        return config('mahana-scaffolding.files');
    }

    public function setFileName($filename)
    {
        $this->fileName = $filename;
    }

    public function getFileContents()
    {
        return file_get_contents($this->filePath . '/' . $this->fileName);
    }

    public function parseFile($fileContents)
    {
        $this->fileContentsArray = $this->parser->parseFile($fileContents);
    }

    public function setModelsArray()
    {
        if (isset($this->fileContentsArray['models']))
        {
            $this->modelsArray = $this->fileContentsArray['models'];
        }                
    }

    // NOTE: has --migration flag, but we won't use
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
            // TODO: allow turning off increments, timestamps
            if ($modelParser->includeMigration()){
                $migration['name'] = 'create_' . strtolower($args['name']) . '_table';
                $migration['--schema'] = $modelParser->getFields();
                $migration['--model'] = false;
                \Artisan::call('make:migration:schema', $migration);
            }


        }
    }


    public function setControllersArray()
    {
        if (isset($this->fileContentsArray['controllers']))
        {
            $this->controllersArray = $this->fileContentsArray['controllers'];
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
        if (isset($this->fileContentsArray['commands']))
        {
            $this->commandsArray = $this->fileContentsArray['commands'];
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
        if (isset($this->fileContentsArray['consoles']))
        {
            $this->consolesArray = $this->fileContentsArray['consoles'];
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
        if (isset($this->fileContentsArray['events']))
        {
            $this->eventsArray = $this->fileContentsArray['events'];
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
        if (isset($this->fileContentsArray['jobs']))
        {
            $this->jobsArray = $this->fileContentsArray['jobs'];
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
        if (isset($this->fileContentsArray['listeners']))
        {
            $this->listenersArray = $this->fileContentsArray['listeners'];
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
        if (isset($this->fileContentsArray['middleware']))
        {
            $this->middlewareArray = $this->fileContentsArray['middleware'];
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
        if (isset($this->fileContentsArray['policies']))
        {
            $this->policiesArray = $this->fileContentsArray['policies'];
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