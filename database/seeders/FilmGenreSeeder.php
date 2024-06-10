<?php

namespace Database\Seeders;

use App\Models\Film;
use App\Models\Genre;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FilmGenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $films = Film::all();
        $genres = Genre::all();
        foreach ($films as $film) {
            // Verifica se il film ha già dei generi associati
            if ($film->genres()->exists()) {
                continue; // Passa al prossimo film
            }
            // Scegliamo casualmente un numero di generi da associare al film
            $numGenres = rand(1, 3);
            // Scegliamo casualmente alcuni generi
            $selectedGenres = $genres->random($numGenres);
            // Associamo il film ai generi selezionati
            foreach ($selectedGenres as $genre) {
                $film->genres()->attach(
                    $genre->id,
                    [
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]
                );
            }
        }
    }
}
