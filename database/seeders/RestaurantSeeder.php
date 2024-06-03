<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $restaurant = new Restaurant();
        $restaurant->nama = 'Nasi Goreng';
        $restaurant->category = 'Makanan';
        $restaurant->harga = '22000';
        $restaurant->status = 'Tersedia';
        $restaurant->description = 'Keripik Singkong Mercon adalah keripik dengan citarasa super pedas yang terbuat dari singkong. Keripik ini cocok buat kamu yang doyan dengan cemilan pedas. Tak hanya pedas, keripik ini ada dalam dua varian rasa, rasa gurih dan rasa manis.';
        $slug = str_replace(' ','&',strtolower($restaurant->nama));
        $restaurant->slug = $slug;
        $restaurant->code = 0;

        
        $restaurant->save();
        if ($restaurant->category == 'Makanan') {
            DB::table('restaurants')->where('id', $restaurant->id)->update(['code' => 'MKN'.$restaurant->id]);
        }else{
            DB::table('restaurants')->where('id', $restaurant->id)->update(['code' => 'MNM'.$restaurant->id]);
        }

        $restaurant = new Restaurant();
        $restaurant->nama = 'Ayam Goreng';
        $restaurant->category = 'Makanan';
        $restaurant->harga = '18000';
        $restaurant->status = 'Tersedia';
        $restaurant->description = 'Ayam goreng (bahasa Inggris: fried chicken), atau ayam goreng tepung adalah hidangan yang dibuat dari potongan daging ayam yang';
        $slug = str_replace(' ','&',strtolower($restaurant->nama));
        $restaurant->slug = $slug;
        $restaurant->code = 0;

        $restaurant->save();
        if ($restaurant->category == 'Makanan') {
            DB::table('restaurants')->where('id', $restaurant->id)->update(['code' => 'MKN'.$restaurant->id]);
        }else{
            DB::table('restaurants')->where('id', $restaurant->id)->update(['code' => 'MNM'.$restaurant->id]);
        }

        $restaurant = new Restaurant();
        $restaurant->nama = 'Croffle';
        $restaurant->category = 'Makanan';
        $restaurant->harga = '18000';
        $restaurant->status = 'Tersedia';
        $restaurant->description = 'The croffle has been the trendy breakfast and brunch pastry for some years now! But what is it? If you haven’t noticed it by its name,';
        $slug = str_replace(' ','&',strtolower($restaurant->nama));
        $restaurant->slug = $slug;
        $restaurant->code = 0;

        $restaurant->save();
        if ($restaurant->category == 'Makanan') {
            DB::table('restaurants')->where('id', $restaurant->id)->update(['code' => 'MKN'.$restaurant->id]);
        }else{
            DB::table('restaurants')->where('id', $restaurant->id)->update(['code' => 'MNM'.$restaurant->id]);
        }

        
        $restaurant = new Restaurant();
        $restaurant->nama = 'Sandwiches';
        $restaurant->category = 'Makanan';
        $restaurant->harga = '15000';
        $restaurant->status = 'Tersedia';
        $restaurant->description = 'Roti yang diisi dengan berbagai macam bahan seperti daging ayam panggang, ham, keju, salad tuna, daging sapi panggang, dan sebagainya.';
        $slug = str_replace(' ','&',strtolower($restaurant->nama));
        $restaurant->slug = $slug;
        $restaurant->code = 0;

        $restaurant->save();
        if ($restaurant->category == 'Makanan') {
            DB::table('restaurants')->where('id', $restaurant->id)->update(['code' => 'MKN'.$restaurant->id]);
        }else{
            DB::table('restaurants')->where('id', $restaurant->id)->update(['code' => 'MNM'.$restaurant->id]);
        }
        $restaurant = new Restaurant();
        $restaurant->nama = 'Coffee Espresso';
        $restaurant->category = 'Minuman';
        $restaurant->harga = '20000';
        $restaurant->status = 'Tersedia';
        $restaurant->description = 'Espresso adalah minuman kopi yang dibuat dengan menyeduh biji kopi yang telah digiling halus dan dikompres dalam mesin espresso dengan tekanan tinggi dan air panas.';
        $slug = str_replace(' ','&',strtolower($restaurant->nama));
        $restaurant->slug = $slug;
        $restaurant->code = 0;

        $restaurant->save();
        if ($restaurant->category == 'Makanan') {
            DB::table('restaurants')->where('id', $restaurant->id)->update(['code' => 'MKN'.$restaurant->id]);
        }else{
            DB::table('restaurants')->where('id', $restaurant->id)->update(['code' => 'MNM'.$restaurant->id]);
        }

        $restaurant = new Restaurant();
        $restaurant->nama = 'Lychee tea';
        $restaurant->category = 'Minuman';
        $restaurant->harga = '25000';
        $restaurant->status = 'Tersedia';
        $restaurant->description = 'Lychee tea merupakan minuman teh yang diberi aroma buah lici (lychee) dan kadang-kadang diberi tambahan gula untuk memberikan rasa manis yang lezat.';
        $slug = str_replace(' ','&',strtolower($restaurant->nama));
        $restaurant->code = 0;

        $restaurant->save();
        if ($restaurant->category == 'Makanan') {
            DB::table('restaurants')->where('id', $restaurant->id)->update(['code' => 'MKN'.$restaurant->id]);
        }else{
            DB::table('restaurants')->where('id', $restaurant->id)->update(['code' => 'MNM'.$restaurant->id]);
        }
    }
}
