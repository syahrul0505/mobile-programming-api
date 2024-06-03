<?php

namespace App\Console\Commands;

use App\Models\Restaurant;
use Illuminate\Console\Command;

class ResetStokPerhari extends Command
{
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stok:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset stok_perhari to 0 every day at 00:00';

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
     * @return int
     */
    public function handle()
    {
        // Reset stok_perhari menjadi 0 di sini
        Restaurant::query()->update(['stok_perhari' => 0]);

        $this->info('Stok_perhari reset to 0 successfully.');
    }
}
