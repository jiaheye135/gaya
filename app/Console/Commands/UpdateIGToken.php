<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Services\InstagramService;

class UpdateIGToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cli:UpdateIGToken';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'UpdateIGToken';
    // php artisan cli:UpdateIGToken

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $ser = new InstagramService();
        $ser->getNewToken();
    }
}
