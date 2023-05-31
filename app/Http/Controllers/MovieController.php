<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
    public function index()
    {
        $movieCount = Movie::all()->count();
        return view('dashboard', compact('movieCount'));
    }

    public function movie_index(Request $request)
    {
        $data['movies'] = Movie::all();
        return view('movie.movie_page', $data);
    }

    public function store_movie(Request $request)
    {
        try {
            $input = $request->all();
            // dd($input);
            $input['title'] = $request->title;
            $input['release_date'] = $request->release_date;
            $input['director'] = $request->director;
            $input['genre'] = $request->genre;
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->post('https://movie-api.olalinktech.com/api/store_movies', $input);
            $start = $response->json();
            if ($start['status'] == 200) {
                return redirect()->back()->with(['success' => "Movie Created Sucessfully"]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(["exception" => $e->getMessage()])->withInput($request->all());
        }
    }

    public function getmovieInfor( Request $request ) {
        $movie = Movie::where( 'id', $request->id )->first();
        return response()->json($movie);
    }

    public function update_movie( Request $request ) {
        $movie = Movie::find( $request->id );
        if ( $movie ) {
            $this->validate( $request, [
                'title' => 'required',
                'release_date' => 'required',
                'director' => 'required',
                'genre' => 'required',
            ] );

            $input = $request->all();
            $movie->fill( $input )->save();

            return redirect()->back()->with( 'message', 'Movie updated successfully' );
        }
    }

    public function destroy_movie(Request $request)
    {
        $id = $request->id;
        Movie::find($id)->delete();
        return redirect()->back()
            ->with('success', 'movie deleted successfully');
    }
}
