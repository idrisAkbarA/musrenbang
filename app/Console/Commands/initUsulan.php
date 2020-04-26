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
        echo "\n";
        for ($i=0; $i < 50 ; $i++) { 
            $faker = Faker::create("id_ID");
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
            $usulan->foto1 = "1584957616155-IMG_20191010_122526_1.jpg";
            $usulan->foto2 = "1584957616146-21 bg.png";
            $usulan->file1 = "1584957622588-fc.pdf";
            $usulan->file2 = "1584957622593-flowchart.pdf";
            $usulan->nama_pengusul = $faker->name;
            $usulan->hp_pengusul = $faker->phoneNumber;
            $usulan->alamat_pengusul = $faker->address;
            $arrCho=["tidak","iya"];
            $usulan->validasi = $arrCho[rand(0,1)];
            $usulan->verifikasi = $arrCho[rand(0,1)];
            $usulan->prioritas = $arrCho[rand(0,1)];
            $usulan->loading_verifikasi = false;
            $usulan->loading_validasi = false;
            $usulan->loading_prioritas = false;
            $usulan->save();
        }
        echo "50 usulan berhasil disimpan!". "\n";
        echo "Inisiasi DB berhasil!". "\n";
    }
}
