<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\POD;
use App\ItemUsulan;
use App\Usulan;
use App\Kelurahan;
use Faker\Factory as Faker;
class initUsulan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'initUsulan';

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
        echo ItemUsulan::find(rand(1,38))->nama;
        echo POD::find(rand(1,45))->nama;
        echo Kelurahan::find(rand(1,7))->nama;
        for ($i=0; $i < 50 ; $i++) { 
            $faker = Faker::create();
            $usulan = new Usulan;
            $usulan->usulan     = ItemUsulan::find(rand(1,38))->nama;
            $usulan->pod        = POD::find(rand(1,45))->nama;
            $usulan->kelurahan  = Kelurahan::find(rand(1,7))->nama;
            $usulan->volume = rand(10,100) . ' x ' . rand(10,100);
            $usulan->satuan = 'm';
            $usulan->alamat = $faker->streetAddress;
            $usulan->alasan_usulan = $faker->sentence;
            $usulan->informasi_tambahan = $faker->sentence;
            $usulan->output = $faker->sentence;
            $usulan->rt = rand(1,10);
            $usulan->rw = rand(1,5);
            $usulan->foto1 = "-";
            $usulan->foto2 = "-";
            $usulan->foto3 = "-";
            $usulan->foto4 = "-";
            $usulan->nama_pengusul = $faker->name;
            $usulan->hp_pengusul = $faker->phoneNumber;
            $usulan->alamat_pengusul = $faker->address;
            $usulan->validasi = "tidak";
            $usulan->verifikasi = "tidak";
            $usulan->prioritas = "tidak";
            $usulan->loading_verif = false;
            $usulan->loading_valid = false;
            $usulan->loading_prioritas = false;
            $usulan->save();
        }
    }
}
