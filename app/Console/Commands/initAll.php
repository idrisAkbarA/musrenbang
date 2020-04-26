<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class initAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'initAll';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Isi semua record penting seperti user, opd, kelurahan, usulan dll';

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
     * @return mixed
     */
    public function handle()
    {
        // \Artisan::call('migrate:fresh');
        // // sleep(3);
        //  \Artisan::call('initAll');
        $this->call('migrate:fresh');
        $this->call('initDB');
        $this->call('initUsulan');
    }
}
