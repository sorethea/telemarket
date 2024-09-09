<?php

namespace App\Console\Commands;



use Telegram\Bot\Commands\Command;

class Telegram extends Command
{

    public function __construct(){
        $this->telegram->setCommandBus(config('telegram.command_list'));
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
