<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\POD;
class initDB extends Controller
{
    public function pod(){
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
        for ($i=0; $i < \sizeof($listPOD) ; $i++) { 
            $pod = new pod;
            $pod->nama = $listPOD[$i];
            $pod->save();
        }
    }
}