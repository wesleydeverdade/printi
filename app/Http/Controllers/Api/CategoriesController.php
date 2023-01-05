<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CategoriesRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Js;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(Category::paginate(5),200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoriesRequest $request
     * @return JsonResponse
     */
    public function store(CategoriesRequest $request): JsonResponse
    {
        try {
            $category = Category::create($request->all());
        }catch(\Exception $e){
            return response()->json(['message' => 'Service Unavailable.'], 503);
        }

        return response()->json($category,201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $category
     * @return Category|JsonResponse
     */
    public function show(int $category): Category|JsonResponse
    {
        $categoryModel = Category::find($category);

        if($categoryModel === NULL){
            return response()->json(['message' => 'Category not found'], 404);
        }

        return $categoryModel;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $category
     * @param CategoriesRequest $request
     * @return Category|JsonResponse
     */
    public function update(int $category, CategoriesRequest $request): Category|JsonResponse
    {
        $categoryModel = Category::find($category);

        if($categoryModel === NULL){
            return response()->json(['message' => 'Category not found'], 404);
        }

        try {
            $categoryModel->name = $request->name;
            $categoryModel->save();
        }catch(\Exception $e){
            return response()->json(['message' => 'Service Unavailable.'], 503);
        }

        return $categoryModel;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $category
     * @return Response|JsonResponse
     */
    public function destroy(int $category): Response|JsonResponse
    {
        $categoryModel = Category::find($category);

        if($categoryModel === NULL){
            return response()->json(['message' => 'Category not found'], 404);
        }

        try {
            Category::destroy($category);
        }catch(\Exception $e){
            return response()->json(['message' => 'Service Unavailable.'], 503);
        }

        return response()->noContent();
    }
}
