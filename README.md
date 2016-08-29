# Mahana Generator Scaffolding
Generator Scaffolding for Laravel 5

####READ ME FIRST

PLEASE understand before commenting that this is working Proof of Concept code; it *does* work, but it is limited in the
 features it supports, still lacks testing, solid documentation, the code is overly simple, etc. This is put out to 
 provide solid examples of how it will work in the end in order to solicit feedback.
 
If you have thoughts to share, please do so here: https://github.com/jrmadsen67/MahanaGeneratorScaffolding/issues/1
  
If you have definite "I will use this when it has feature X" comments, please go ahead and open a feature request.
  
Thank you for your time in helping to make this a great tool for everyone!   

####What this is 
I intend to follow up with a blog post where I can get much wordier about how I imagine this being used and who I think 
it will most benefit. Essentially, it is a library that will convert a .yaml file into an array, then build out the 
various commandlines you would use with `artisan` to create boilerplate classes and migrations.
 
Unlike what exists in Laravel now, however, it is being designed to work with a variety of enhanced Generators and 
 stubs to give you a much more customized and complete output than what can currently be achieved.
 
At the moment, it supports:
 
    https://github.com/laracasts/Laravel-5-Generators-Extended (partial implementation for migrations)
    
    https://github.com/jrmadsen67/mahana-laravel5-generators (enhanced Model generation)
     
    native Laravel Controller generator 

Additional features are really little more than string parsing, so virtually anything that would be helpful can be added.
I'm working furiously on them.

####Installation

    composer require jrmadsen67/mahana-generator-scaffolding

    
Afterwards, in your `AppServiceProvider`, add:

    public function register() {
    
		if ($this->app->environment() == 'local') {
            $this->app->register('jrmadsen67\MahanaScaffolding\MahanaScaffoldingServiceProvider');
			$this->app->register('jrmadsen67\MahanaGenerators\GeneratorsServiceProvider');
            $this->app->register('Laracasts\Generators\GeneratorsServiceProvider');
		}
    }    

The default for your generator configuration files is /scaffolding/genscaffolding.yml. You may run:

    artisan vendor:publish --provider="jrmadsen67\MahanaScaffolding\MahanaScaffoldingServiceProvider" --tag="mahana-scaffolding"
    
to create a package config file called `mahana-scaffolding.php`, where you will see:
     
         return [
             'base_dir' => 'scaffolding',
             'files' => [
                 'genscaffolding' => 'genscaffolding.yml'
             ]
         ];
         
The `base_dir` refers to the directory where you put all your own files; the `files` array is a list of those files, 
which will ALL be run (a future enhancement will allow you to specify a subset by key). 

####Usage

More complete documentation will be provided later. For the moment, because of the limited functionality, use the 
genscaffolding.yaml file in this repo as a working example file.

From the commandline, 

    `artisan mahana-scaffolding:generate`
    
will run the actual command to generate everything.    
 
NOTE: There is no rollback functionality, and existing files will not be overwritten. For that reason, you may find it
 easiest to first commit your basic Laravel project to git, then run the generator. This way you can clean up by simply
doing a `git checkout .`   

NOTE: There is a known issue with not being able to customize increment fields or turn off timestamps in the migration
files that I simply haven't had time to look into very deeply yet. It is an issue with Jeffrey Way's Generators and may 
require that I fork that package to fix.