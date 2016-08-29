<?php

namespace jrmadsen67\MahanaScaffolding\Commands;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Console\Command;
use jrmadsen67\MahanaScaffolding\MahanaScaffolding;

class GenerateScaffoldingCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'mahana-scaffolding:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the Scaffolding';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire() {

        (new MahanaScaffolding)->generate();

    }
}