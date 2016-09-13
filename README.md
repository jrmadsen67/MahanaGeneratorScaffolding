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

https://github.com/jrmadsen67/MahanaGeneratorScaffolding/wiki/installation

####Usage

https://github.com/jrmadsen67/MahanaGeneratorScaffolding/wiki/usage

####Example Usage

https://github.com/jrmadsen67/MahanaGeneratorScaffolding/wiki/Example-Usage
