<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Pengumumans;
use Faker\Factory as Faker;
class initPengumuman extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'initPengumuman';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $faker = Faker::create("id_ID");
        for ($i=0; $i < 10 ; $i++) { 
            $pengumuman = new pengumumans;
            $pengumuman->nama = $faker->sentence;
            $pengumuman->isi = $faker->text;
            $pengumuman->save();
            # code...
        }
        echo "Inisiasi pengumuman berhasil!". "\n";
    }
}
