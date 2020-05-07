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
            $usulan->pod        = POD::find(rand(1,45))->nama;
            $usulan->kelurahan  = Kelurahan::find(rand(1,7))->nama;
            $usulan->alasan_usulan = $faker->sentence;
            $usulan->informasi_tambahan = $faker->sentence;
            $usulan->output = $faker->sentence;
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
            
            $jenis = ['fisik','nonfisik'];
            $selectedJenis = $jenis[rand(0,1)];
            if($selectedJenis == 'fisik'){
                $usulan->jenis = "Fisik";
                $usulan->usulan = ItemUsulan::find(rand(1,38))->nama;
                $usulan->volume = rand(10,100) . ' x  ' . rand(10,100);
                $usulan->satuan = 'm';
                $usulan->alamat = $faker->streetAddress;
                $usulan->rt = rand(1,10);
                $usulan->rw = rand(1,5);
                $foto1Name = date("Ymdhis")."-a".$i.".jpg";
                $foto2Name = date("Ymdhis")."-b".$i.".jpg";
                $file1Name = date("Ymdhis")."-a".$i.".pdf";
                $file2Name = date("Ymdhis")."-b".$i.".pdf";
                copy(public_path('images').'\default\a.jpg',public_path('images').'\\'.$foto1Name);
                copy(public_path('images').'\default\b.jpg',public_path('images').'\\'.$foto2Name);
                copy(public_path('files').'\default\a.pdf',public_path('files').'\\'.$file1Name);
                copy(public_path('files').'\default\b.pdf',public_path('files').'\\'.$file2Name);
                $usulan->foto1 = $foto1Name;
                $usulan->foto2 = $foto2Name;
                $usulan->file1 = $file1Name;
                $usulan->file2 = $file2Name;
            }else{
                $usulan->jenis = "Non Fisik";
                $usulan->usulan = $faker->sentence;
                $usulan->volume = "-";
                $usulan->satuan = '-';
                $usulan->alamat = "-";
                $usulan->rt = "-";
                $usulan->rw = "-";
                $usulan->foto1 = "-";
                $usulan->foto2 = "-";
                $usulan->file1 = "-";
                $usulan->file2 = "-";
            }
            $usulan->save();
        }
        echo "50 usulan berhasil disimpan!". "\n";
        echo "Inisiasi DB berhasil!". "\n";
    }
}
