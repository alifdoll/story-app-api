<?php

namespace App\Http\Controllers;

use App\Http\Resources\StoryResource;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $story = Story::all();
        return response()
            ->json([
                'status' => 'success',
                'data' => StoryResource::collection($story)
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'required',
        ]);

        try {

            $image = $request->file('image');
            if ($image) {
                $image_name = Str::slug($image->getClientOriginalName()) . ".png";
                $file_name = auth()->user()->id . '_' . time() . $image_name;
                $file_path = $image->storeAs('images', $file_name, 'public');
            }




            $story = Story::create([
                'title' => request('title'),
                'description' => request('description'),
                'image' => $file_path ?? null
            ]);

            if ($story) {
                return response()->json([
                    'status' => "success"
                ]);
            } else {
                return response()->json([
                    'status' => "fail"
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' =>  $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function show(Story $story)
    {
        return response()->json([
            'status' => 'success',
            'data' => new StoryResource($story)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Story $story)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function destroy(Story $story)
    {
        //
    }
}
