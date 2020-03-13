<?php

namespace App\Console\Commands;
use App\POD;
use App\ItemUsulan;
use App\Kelurahan;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class initDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'initDB';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Isi data POD, Kelurahan dan item kegiatan di db';

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
        $listPOD =[
            'BADAN KEPEGAWAIAN DAN PENGEMBANGAN SUMBER DAYA MANUSIA',
            'BADAN KESATUAN BANGSA DAN POLITIK',
            'BADAN PENANGGULANGAN BENCANA DAERAH',
            'BADAN PENDAPATAN DAERAH',
            'BADAN PENELITIAN DAN PENGEMBANGAN',
            'BADAN PENGELOLA KEUANGAN DAN ASET DAERAH',
            'BADAN PERENCANAAN PEMBANGUNAN DAERAH',
            'DINAS KEBUDAYAAN DAN PARIWISATA',
            'DINAS KEPEMUDAAN DAN OLAHRAGA',
            'DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL',
            'DINAS KESEHATAN',
            'DINAS KETAHANAN PANGAN',
            'DINAS KOMUNIKASI, INFORMATIKA, STATISTIK DAN PERSANDIAN',
            'DINAS KOPERASI, USAHA KECIL DAN MENENGAH',
            'DINAS LINGKUNGAN HIDUP DAN KEBERSIHAN',
            'DINAS PEKERJAAN UMUM DAN PENATAAN RUANG',
            'DINAS PEMADAM KEBAKARAN DAN PENYELAMATAN',
            'DINAS PEMBERDAYAAN PEREMPUAN DAN PERLINDUNGAN ANAK',
            'DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU',
            'DINAS PENDIDIKAN',
            'DINAS PENGENDALIAN PENDUDUK DAN KELUARGA BERENCANA',
            'DINAS PERDAGANGAN DAN PERINDUSTRIAN',
            'DINAS PERHUBUNGAN',
            'DINAS PERPUSTAKAAN DAN KEARSIPAN',
            'DINAS PERTANAHAN',
            'DINAS PERTANIAN DAN PERIKANAN',
            'DINAS PERUMAHAN RAKYAT DAN KAWASAN PERMUKIMAN',
            'DINAS SOSIAL',
            'DINAS TENAGA KERJA',
            'INSPEKTORAT DAERAH',
            'KECAMATAN BUKIT RAYA',
            'KECAMATAN LIMAPULUH',
            'KECAMATAN MARPOYAN DAMAI',
            'KECAMATAN PAYUNG SEKAKI',
            'KECAMATAN PEKANBARU KOTA',
            'KECAMATAN RUMBAI',
            'KECAMATAN RUMBAI PESISIR',
            'KECAMATAN SAIL',
            'KECAMATAN SENAPELAN',
            'KECAMATAN SUKAJADI',
            'KECAMATAN TAMPAN',
            'KECAMATAN TENAYAN RAYA',
            'SATUAN POLISI PAMONG PRAJA',
            'SEKRETARIAT DAERAH',
            'SEKRETARIAT DPRD',
    ];

    $listItemUsulan = [
        'Box culvert',
        'Drainase',
        'Jalan Lingkungan / Semenisasi',
        'Jembatan',
        'Kolam retensi',
        'Lampu jalan',
        'Leoning',
        'Normalisasi Sungai',
        'Overlay Hotmix',
        'Pelatihan Industri',
        'Pelatihan pertanian',
        'Pembangunan Gedung PAUD',
        'Pembangunan Gedung SD',
        'Pembangunan Gedung SMP',
        'Pembangunan Gedung SMU/SMK',
        'Pembangunan Jembatan',
        'Pembangunan poskamling/ linmas',
        'Pembangunan posyandu',
        'Pembangunan prasarana olahraga',
        'Pembangunan Puskesmas',
        'Pembangunan Puskesmas Pembantu',
        'Pembangunan TPS',
        'Pembukaan Jalan Baru',
        'Pengadaan Bibit',
        'Pengaspalan Hotmix',
        'Pengerasan',
        'Peralatan dan Perlengkapan posyandu',
        'Perbaikan kualitas rumah',
        'Rehap prasarana olahraga',
        'Rehap puskesmas',
        'Rehap puskesmas pembantu',
        'Rumah Layak huni',
        'Saluran Lingkungan',
        'Saluran Lingkungan',
        'Sumur Artesis',
        'Sumur Dalam/ Deep well',
        'Trotoar',
        'Turap',
    ];
    $listKelurahan=[
        'Air Hitam',
        'Bandar Raya',
        'Labuh Baru Barat',
        'Labuh Baru Timur',
        'Sungai Sibam',
        'Tampan',
        'Tirtasiak',
    ];
        for ($i=0; $i < \sizeof($listPOD) ; $i++) { 
            $pod = new POD;
            $pod->nama = $listPOD[$i];
            $pod->save();
        }
        for ($i=0; $i < \sizeof($listItemUsulan) ; $i++) { 
            $pod = new ItemUsulan;
            $pod->nama = $listItemUsulan[$i];
            $pod->save();
        }
        $user = new User;
        $user->name = "admin";
        $user->id_kel = '-';
        $user->password = Hash::make('admin123');
        $user->save();
        for ($i=0; $i < \sizeof($listKelurahan) ; $i++) { 
            $pod = new Kelurahan;
            $user = new User;
            $pod->nama = $listKelurahan[$i];
            $pod->save();
            $user->name = strtolower(str_replace(' ', '', $listKelurahan[$i]));
            $user->id_kel = $i+1;
            $user->password = Hash::make(strtolower(str_replace(' ', '', $listKelurahan[$i].'123')));
            $user->save();
        }
    }
}
