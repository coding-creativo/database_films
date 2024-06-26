<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class HomeController extends Controller
{
    protected $genres;

    public function __construct()
    {
        $this->genres = Genre::all();
    }

    public function index()
    {
        $films = Film::inRandomOrder()->paginate(8);
        return view('welcome', ['films' => $films, 'genres' => $this->genres]);
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $films = Film::where('title', 'like', '%' . $search . '%')->get();
        return view('films.search',  ['films' => $films, 'genres' => $this->genres]);
    }

    public function genre($genre)
    {
        try {
            $genre = Genre::where('name', $genre)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        $films = $genre->films()->get(); // Utilizza get() per recuperare tutti i film associati al genere

        // dd($films); // Controlla i risultati prima di passarli alla vista
        return view('films.genre', ['films' => $films, 'genre' => $genre, 'genres' => $this->genres]);
    }

    public function contatti(Request $request)
    {
        return view('contact', ['genres' => $this->genres]);
    }
}
