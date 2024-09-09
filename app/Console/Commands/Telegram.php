<?php

namespace App\Console\Commands;



use Telegram\Bot\Commands\Command;

class Telegram extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected string $name = '';

    public function __construct($name){
        $this->name = $name;
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
