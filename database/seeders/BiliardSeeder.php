<?php

namespace Database\Seeders;

use App\Models\Biliard;
use Illuminate\Database\Seeder;

class BiliardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new Biliard();
        $user->nama = 'Meja B1';
        $user->no_meja = '1';
        $user->harga = '100000';
        $user->status = 'Tersedia';
        $user->description = 'billiards, any of various games played on a rectangular table with a designated number of small balls and a long stick called a cue. The table and the cushioned rail bordering the table are topped with a feltlike tight-fitting cloth. Carom, or French,';
        $slug = str_replace(' ','&',strtolower($user->nama));
        $user->slug = $slug;

        $user->save();

        $user = new Biliard();
        $user->nama = 'Meja B2';
        $user->no_meja = '2';
        $user->harga = '100000';
        $user->status = 'Tersedia';
        $user->description = 'billiards, any of various games played on a rectangular table with a designated number of small balls and a long stick called a cue. The table and the cushioned rail bordering the table are topped with a feltlike tight-fitting cloth. Carom, or French,';
        $slug = str_replace(' ','&',strtolower($user->nama));
        $user->slug = $slug;

        $user->save();

        $user = new Biliard();
        $user->nama = 'Meja B3';
        $user->no_meja = '3';
        $user->harga = '100000';
        $user->status = 'Tersedia';
        $user->description = 'billiards, any of various games played on a rectangular table with a designated number of small balls and a long stick called a cue. The table and the cushioned rail bordering the table are topped with a feltlike tight-fitting cloth. Carom, or French,,';
        $slug = str_replace(' ','&',strtolower($user->nama));
        $user->slug = $slug;

        $user->save();

        $user = new Biliard();
        $user->nama = 'Meja B4';
        $user->no_meja = '1';
        $user->harga = '100000';
        $user->status = 'Tersedia';
        $user->description = 'billiards, any of various games played on a rectangular table with a designated number of small balls and a long stick called a cue. The table and the cushioned rail bordering the table are topped with a feltlike tight-fitting cloth. Carom, or French,';
        $slug = str_replace(' ','&',strtolower($user->nama));
        $user->slug = $slug;

        $user->save();

        $user = new Biliard();
        $user->nama = 'Meja B5';
        $user->no_meja = '2';
        $user->harga = '100000';
        $user->status = 'Tersedia';
        $user->description = 'billiards, any of various games played on a rectangular table with a designated number of small balls and a long stick called a cue. The table and the cushioned rail bordering the table are topped with a feltlike tight-fitting cloth. Carom, or French,';
        $slug = str_replace(' ','&',strtolower($user->nama));
        $user->slug = $slug;

        $user->save();

        $user = new Biliard();
        $user->nama = 'Meja B6';
        $user->no_meja = '3';
        $user->harga = '100000';
        $user->status = 'Tersedia';
        $user->description = 'billiards, any of various games played on a rectangular table with a designated number of small balls and a long stick called a cue. The table and the cushioned rail bordering the table are topped with a feltlike tight-fitting cloth. Carom, or French,,';
        $slug = str_replace(' ','&',strtolower($user->nama));
        $user->slug = $slug;

        $user->save();
    }
}
