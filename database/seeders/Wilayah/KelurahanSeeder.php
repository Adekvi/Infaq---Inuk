<?php

namespace Database\Seeders\Wilayah;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelurahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // Kecamatan Kaliwungu
            ['id' => 3319012001, 'id_kecamatan' => 331901, 'nama_kelurahan' => 'BAKALAN KRAPYAK'],
            ['id' => 3319012002, 'id_kecamatan' => 331901, 'nama_kelurahan' => 'PRAMBATAN KIDUL'],
            ['id' => 3319012003, 'id_kecamatan' => 331901, 'nama_kelurahan' => 'PRAMBATAN LOR'],
            ['id' => 3319012004, 'id_kecamatan' => 331901, 'nama_kelurahan' => 'GARUNG KIDUL'],
            ['id' => 3319012005, 'id_kecamatan' => 331901, 'nama_kelurahan' => 'SETROKALANGAN'],
            ['id' => 3319012006, 'id_kecamatan' => 331901, 'nama_kelurahan' => 'BANGET'],
            ['id' => 3319012007, 'id_kecamatan' => 331901, 'nama_kelurahan' => 'BLIMBING KIDUL'],
            ['id' => 3319012008, 'id_kecamatan' => 331901, 'nama_kelurahan' => 'SIDOREKSO'],
            ['id' => 3319012009, 'id_kecamatan' => 331901, 'nama_kelurahan' => 'GAMONG'],
            ['id' => 3319012010, 'id_kecamatan' => 331901, 'nama_kelurahan' => 'KEDUNGDOWO'],
            ['id' => 3319012011, 'id_kecamatan' => 331901, 'nama_kelurahan' => 'GARUNG LOR'],
            ['id' => 3319012012, 'id_kecamatan' => 331901, 'nama_kelurahan' => 'KARANGAMPEL'],
            ['id' => 3319012013, 'id_kecamatan' => 331901, 'nama_kelurahan' => 'MIJEN'],
            ['id' => 3319012014, 'id_kecamatan' => 331901, 'nama_kelurahan' => 'KALIWUNGU'],
            ['id' => 3319012015, 'id_kecamatan' => 331901, 'nama_kelurahan' => 'PAPRINGAN'],

            // Kecamatan Kota Kudus
            ['id' => 3319021001, 'id_kecamatan' => 331902, 'nama_kelurahan' => 'PURWOSARI'],
            ['id' => 3319021004, 'id_kecamatan' => 331902, 'nama_kelurahan' => 'SUNGGINGAN'],
            ['id' => 3319021005, 'id_kecamatan' => 331902, 'nama_kelurahan' => 'PANJUNAN'],
            ['id' => 3319021006, 'id_kecamatan' => 331902, 'nama_kelurahan' => 'WERGU WETAN'],
            ['id' => 3319021007, 'id_kecamatan' => 331902, 'nama_kelurahan' => 'WERGU KULON'],
            ['id' => 3319021008, 'id_kecamatan' => 331902, 'nama_kelurahan' => 'MLATI KIDUL'],
            ['id' => 3319021009, 'id_kecamatan' => 331902, 'nama_kelurahan' => 'MLATI NOROWITO'],
            ['id' => 3319021017, 'id_kecamatan' => 331902, 'nama_kelurahan' => 'KERJASAN'],
            ['id' => 3319021018, 'id_kecamatan' => 331902, 'nama_kelurahan' => 'KAJEKSAN'],
            ['id' => 3319022002, 'id_kecamatan' => 331902, 'nama_kelurahan' => 'JANGGALAN'],
            ['id' => 3319022003, 'id_kecamatan' => 331902, 'nama_kelurahan' => 'DEMANGAN'],
            ['id' => 3319022010, 'id_kecamatan' => 331902, 'nama_kelurahan' => 'MLATI LOR'],
            ['id' => 3319022011, 'id_kecamatan' => 331902, 'nama_kelurahan' => 'NGANGUK'],
            ['id' => 3319022012, 'id_kecamatan' => 331902, 'nama_kelurahan' => 'KRAMAT'],
            ['id' => 3319022013, 'id_kecamatan' => 331902, 'nama_kelurahan' => 'DEMAAN'],
            ['id' => 3319022014, 'id_kecamatan' => 331902, 'nama_kelurahan' => 'LANGGARDALEM'],
            ['id' => 3319022015, 'id_kecamatan' => 331902, 'nama_kelurahan' => 'KAUMAN'],
            ['id' => 3319022016, 'id_kecamatan' => 331902, 'nama_kelurahan' => 'DAMARAN'],
            ['id' => 3319022019, 'id_kecamatan' => 331902, 'nama_kelurahan' => 'KRANDON'],
            ['id' => 3319022020, 'id_kecamatan' => 331902, 'nama_kelurahan' => 'SINGOCANDI'],
            ['id' => 3319022021, 'id_kecamatan' => 331902, 'nama_kelurahan' => 'GLANTENGAN'],
            ['id' => 3319022022, 'id_kecamatan' => 331902, 'nama_kelurahan' => 'KALIPUTU'],
            ['id' => 3319022023, 'id_kecamatan' => 331902, 'nama_kelurahan' => 'BARONGAN'],
            ['id' => 3319022024, 'id_kecamatan' => 331902, 'nama_kelurahan' => 'BURIKAN'],
            ['id' => 3319022025, 'id_kecamatan' => 331902, 'nama_kelurahan' => 'RENDENG'],

            // Kecamatan Jati
            ['id' => 3319032001, 'id_kecamatan' => 331903, 'nama_kelurahan' => 'JETIS KAPUAN (JETIS KAPUAN)'],
            ['id' => 3319032002, 'id_kecamatan' => 331903, 'nama_kelurahan' => 'TANJUN GKARANG (TANJUNG KARANG)'],
            ['id' => 3319032003, 'id_kecamatan' => 331903, 'nama_kelurahan' => 'JATI WETAN'],
            ['id' => 3319032004, 'id_kecamatan' => 331903, 'nama_kelurahan' => 'PASURUHAN KIDUL'],
            ['id' => 3319032005, 'id_kecamatan' => 331903, 'nama_kelurahan' => 'PASURUHAN LOR'],
            ['id' => 3319032006, 'id_kecamatan' => 331903, 'nama_kelurahan' => 'PLOSO'],
            ['id' => 3319032007, 'id_kecamatan' => 331903, 'nama_kelurahan' => 'JATI KULON'],
            ['id' => 3319032008, 'id_kecamatan' => 331903, 'nama_kelurahan' => 'GETAS PEJATEN (GETAS PEJATEN)'],
            ['id' => 3319032009, 'id_kecamatan' => 331903, 'nama_kelurahan' => 'LORAM KULON'],
            ['id' => 3319032010, 'id_kecamatan' => 331903, 'nama_kelurahan' => 'LORAM WETAN'],
            ['id' => 3319032011, 'id_kecamatan' => 331903, 'nama_kelurahan' => 'JEPANGPAKIS'],
            ['id' => 3319032012, 'id_kecamatan' => 331903, 'nama_kelurahan' => 'MEGAWON'],
            ['id' => 3319032013, 'id_kecamatan' => 331903, 'nama_kelurahan' => 'NGEMBAL KULON'],
            ['id' => 3319032014, 'id_kecamatan' => 331903, 'nama_kelurahan' => 'TUMPANG KRASAK (TUMPANG KRASAK)'],

            // Kecamatan Undaan
            ['id' => 3319042001, 'id_kecamatan' => 331904, 'nama_kelurahan' => 'WONOSOCO'],
            ['id' => 3319042002, 'id_kecamatan' => 331904, 'nama_kelurahan' => 'LAMBANGAN'],
            ['id' => 3319042003, 'id_kecamatan' => 331904, 'nama_kelurahan' => 'KALIREJO'],
            ['id' => 3319042004, 'id_kecamatan' => 331904, 'nama_kelurahan' => 'MEDINI'],
            ['id' => 3319042005, 'id_kecamatan' => 331904, 'nama_kelurahan' => 'SAMBUNG'],
            ['id' => 3319042006, 'id_kecamatan' => 331904, 'nama_kelurahan' => 'GLAGAHWARU'],
            ['id' => 3319042007, 'id_kecamatan' => 331904, 'nama_kelurahan' => 'KUTUK'],
            ['id' => 3319042008, 'id_kecamatan' => 331904, 'nama_kelurahan' => 'UNDAAN KIDUL'],
            ['id' => 3319042009, 'id_kecamatan' => 331904, 'nama_kelurahan' => 'UNDAAN TENGAH'],
            ['id' => 3319042010, 'id_kecamatan' => 331904, 'nama_kelurahan' => 'KARANGROWO'],
            ['id' => 3319042011, 'id_kecamatan' => 331904, 'nama_kelurahan' => 'LARIKREJO'],
            ['id' => 3319042012, 'id_kecamatan' => 331904, 'nama_kelurahan' => 'UNDAAN LOR'],
            ['id' => 3319042013, 'id_kecamatan' => 331904, 'nama_kelurahan' => 'WATES'],
            ['id' => 3319042014, 'id_kecamatan' => 331904, 'nama_kelurahan' => 'NGEMPLAK'],
            ['id' => 3319042015, 'id_kecamatan' => 331904, 'nama_kelurahan' => 'TERANGMAS'],
            ['id' => 3319042016, 'id_kecamatan' => 331904, 'nama_kelurahan' => 'BERUGENJANG'],

            // Kecamatan Mejobo
            ['id' => 3319052001, 'id_kecamatan' => 331905, 'nama_kelurahan' => 'GULANG'],
            ['id' => 3319052002, 'id_kecamatan' => 331905, 'nama_kelurahan' => 'JEPANG'],
            ['id' => 3319052003, 'id_kecamatan' => 331905, 'nama_kelurahan' => 'PAYAMAN'],
            ['id' => 3319052004, 'id_kecamatan' => 331905, 'nama_kelurahan' => 'KIRIG'],
            ['id' => 3319052005, 'id_kecamatan' => 331905, 'nama_kelurahan' => 'TEMULUS'],
            ['id' => 3319052006, 'id_kecamatan' => 331905, 'nama_kelurahan' => 'KESAMBI'],
            ['id' => 3319052007, 'id_kecamatan' => 331905, 'nama_kelurahan' => 'JOJO'],
            ['id' => 3319052008, 'id_kecamatan' => 331905, 'nama_kelurahan' => 'HADIWARNO'],
            ['id' => 3319052009, 'id_kecamatan' => 331905, 'nama_kelurahan' => 'MEJOBO'],
            ['id' => 3319052010, 'id_kecamatan' => 331905, 'nama_kelurahan' => 'GOLANTEPUS'],
            ['id' => 3319052011, 'id_kecamatan' => 331905, 'nama_kelurahan' => 'TENGGELES'],

            // Kecamatan Jekulo
            ['id' => 3319062001, 'id_kecamatan' => 331906, 'nama_kelurahan' => 'SADANG'],
            ['id' => 3319062002, 'id_kecamatan' => 331906, 'nama_kelurahan' => 'BULUNG CANGKRING'],
            ['id' => 3319062003, 'id_kecamatan' => 331906, 'nama_kelurahan' => 'BULUNG KULON'],
            ['id' => 3319062004, 'id_kecamatan' => 331906, 'nama_kelurahan' => 'SIDOMULYO'],
            ['id' => 3319062005, 'id_kecamatan' => 331906, 'nama_kelurahan' => 'GONDOHARUM'],
            ['id' => 3319062006, 'id_kecamatan' => 331906, 'nama_kelurahan' => 'TERBAN'],
            ['id' => 3319062007, 'id_kecamatan' => 331906, 'nama_kelurahan' => 'PLADEN'],
            ['id' => 3319062008, 'id_kecamatan' => 331906, 'nama_kelurahan' => 'KLALING'],
            ['id' => 3319062009, 'id_kecamatan' => 331906, 'nama_kelurahan' => 'JEKULO'],
            ['id' => 3319062010, 'id_kecamatan' => 331906, 'nama_kelurahan' => 'HADIPOLO'],
            ['id' => 3319062011, 'id_kecamatan' => 331906, 'nama_kelurahan' => 'HONGGOSOCO'],
            ['id' => 3319062012, 'id_kecamatan' => 331906, 'nama_kelurahan' => 'TANJUNGREJO'],

            // Kecamatan Bae
            ['id' => 3319072001, 'id_kecamatan' => 331907, 'nama_kelurahan' => 'DERSALAM'],
            ['id' => 3319072002, 'id_kecamatan' => 331907, 'nama_kelurahan' => 'NGEMBALREJO'],
            ['id' => 3319072003, 'id_kecamatan' => 331907, 'nama_kelurahan' => 'KARANG BENER'],
            ['id' => 3319072004, 'id_kecamatan' => 331907, 'nama_kelurahan' => 'GONDANG MANIS'],
            ['id' => 3319072005, 'id_kecamatan' => 331907, 'nama_kelurahan' => 'PEDAWANG'],
            ['id' => 3319072006, 'id_kecamatan' => 331907, 'nama_kelurahan' => 'BACIN'],
            ['id' => 3319072007, 'id_kecamatan' => 331907, 'nama_kelurahan' => 'PANJANG'],
            ['id' => 3319072008, 'id_kecamatan' => 331907, 'nama_kelurahan' => 'PEGANJARAN'],
            ['id' => 3319072009, 'id_kecamatan' => 331907, 'nama_kelurahan' => 'PURWOREJO'],
            ['id' => 3319072010, 'id_kecamatan' => 331907, 'nama_kelurahan' => 'BAE'],

            // Kecamatan Gebog
            ['id' => 3319082001, 'id_kecamatan' => 331908, 'nama_kelurahan' => 'GRIBIG'],
            ['id' => 3319082002, 'id_kecamatan' => 331908, 'nama_kelurahan' => 'KLUMPIT'],
            ['id' => 3319082003, 'id_kecamatan' => 331908, 'nama_kelurahan' => 'GETASSRABI (GETASRABI)'],
            ['id' => 3319082004, 'id_kecamatan' => 331908, 'nama_kelurahan' => 'PADURENAN'],
            ['id' => 3319082005, 'id_kecamatan' => 331908, 'nama_kelurahan' => 'KARANG MALANG'],
            ['id' => 3319082006, 'id_kecamatan' => 331908, 'nama_kelurahan' => 'BESITO'],
            ['id' => 3319082007, 'id_kecamatan' => 331908, 'nama_kelurahan' => 'JURANG'],
            ['id' => 3319082008, 'id_kecamatan' => 331908, 'nama_kelurahan' => 'GONDOSARI'],
            ['id' => 3319082009, 'id_kecamatan' => 331908, 'nama_kelurahan' => 'KEDUNGSARI'],
            ['id' => 3319082010, 'id_kecamatan' => 331908, 'nama_kelurahan' => 'MENAWAN'],
            ['id' => 3319082011, 'id_kecamatan' => 331908, 'nama_kelurahan' => 'RAHTAWU'],

            // Kecamatan Dawe
            ['id' => 3319092001, 'id_kecamatan' => 331909, 'nama_kelurahan' => 'SAMIREJO'],
            ['id' => 3319092002, 'id_kecamatan' => 331909, 'nama_kelurahan' => 'CENDONO'],
            ['id' => 3319092003, 'id_kecamatan' => 331909, 'nama_kelurahan' => 'MARGOREJO'],
            ['id' => 3319092004, 'id_kecamatan' => 331909, 'nama_kelurahan' => 'REJOSARI'],
            ['id' => 3319092005, 'id_kecamatan' => 331909, 'nama_kelurahan' => 'KANDANGMAS'],
            ['id' => 3319092006, 'id_kecamatan' => 331909, 'nama_kelurahan' => 'GLAGAH KULON'],
            ['id' => 3319092007, 'id_kecamatan' => 331909, 'nama_kelurahan' => 'TERGO'],
            ['id' => 3319092008, 'id_kecamatan' => 331909, 'nama_kelurahan' => 'CRANGGANG'],
            ['id' => 3319092009, 'id_kecamatan' => 331909, 'nama_kelurahan' => 'LAU'],
            ['id' => 3319092010, 'id_kecamatan' => 331909, 'nama_kelurahan' => 'PIJI'],
            ['id' => 3319092011, 'id_kecamatan' => 331909, 'nama_kelurahan' => 'PUYOH'],
            ['id' => 3319092012, 'id_kecamatan' => 331909, 'nama_kelurahan' => 'SOCO'],
            ['id' => 3319092013, 'id_kecamatan' => 331909, 'nama_kelurahan' => 'TERNADI'],
            ['id' => 3319092014, 'id_kecamatan' => 331909, 'nama_kelurahan' => 'KAJAR'],
            ['id' => 3319092015, 'id_kecamatan' => 331909, 'nama_kelurahan' => 'KUWUKAN'],
            ['id' => 3319092016, 'id_kecamatan' => 331909, 'nama_kelurahan' => 'DUKUH WARINGIN'],
            ['id' => 3319092017, 'id_kecamatan' => 331909, 'nama_kelurahan' => 'JAPAN'],
            ['id' => 3319092018, 'id_kecamatan' => 331909, 'nama_kelurahan' => 'COLO'],
        ];

        DB::table('db_kelurahans')->insert($data);
    }
}
