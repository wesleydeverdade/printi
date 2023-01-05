<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\MoviesRequest;
use App\Models\Category;
use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(Movie::with('categories')->paginate(5),200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MoviesRequest $request
     * @return JsonResponse
     */
    public function store(MoviesRequest $request, Category $category): JsonResponse
    {
        $categoryModel = Category::find($request->category_id);

        if($categoryModel === NULL){
            return response()->json(['message' => 'Category not found'], 404);
        }

        try {
            $movie = Movie::create($request->all());
        }catch(\Exception $e){
            return response()->json(['message' => 'Service Unavailable.'], 503);
        }

        return response()->json($movie,201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $movie
     * @return Movie|JsonResponse
     */
    public function show(int $movie): Movie|JsonResponse
    {
        $movieModel = Movie::find($movie);

        if($movieModel === NULL){
            return response()->json(['message' => 'Movie not found'], 404);
        }

        return $movieModel;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $movie
     * @param MoviesRequest $request
     * @return Movie|JsonResponse
     */
    public function update(int $movie, MoviesRequest $request): Movie|JsonResponse
    {
        $movieModel = Movie::find($movie);

        if($movieModel === NULL){
            return response()->json(['message' => 'Movie not found'], 404);
        }

        $categoryModel = Category::find($request->category_id);

        if($categoryModel === NULL){
            return response()->json(['message' => 'Category not found'], 404);
        }

        try {
            $movieModel->name = $request->name;
            $movieModel->category_id = $request->category_id;
            $movieModel->save();

        }catch(\Exception $e){
            return response()->json(['message' => 'Service Unavailable.'], 503);
        }

        return $movieModel;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $movie
     * @return Response|JsonResponse
     */
    public function destroy(int $movie): Response|JsonResponse
    {
        $movieModel = Movie::find($movie);

        if($movieModel === NULL){
            return response()->json(['message' => 'Movie not found'], 404);
        }

        try {
            Movie::destroy($movie);
        }catch(\Exception $e){
            return response()->json(['message' => 'Service Unavailable.'], 503);
        }

        return response()->noContent();
    }
}
