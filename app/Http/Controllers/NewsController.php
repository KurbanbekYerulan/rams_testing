<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->only(['store', 'update', 'destroy']);
    }


    public function index()
    {
        $news = News::whereNotNull('publication_date')->orderByDesc('publication_date')->get();
        return $this->sendResponse($news, 'News retrieved successfully.');
    }

    public function top()
    {
        $news = News::whereNotNull('publication_date')->orderByDesc('views')->orderByDesc('publication_date')->limit(10)->get();
        return $this->sendResponse($news, 'News retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $input = $request->all();
        $validator = Validator::make($input, [
            'category_id' => 'required',
            'title' => 'required',
            'news_text' => 'required',
            'news_preview' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $news = News::create([
            'category_id' => $input['category_id'],
            'title' => $input['title'],
            'news_text' => $input['news_text'],
            'news_preview' => $input['news_preview'],
            'publication_date' => $input['publication_date'] ?? null,
            'views' => 0
        ]);

        return $this->sendResponse($news, 'News created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        $news = News::find($id);
        if (is_null($news)) {
            return $this->sendError('News not found.');
        }

        if (is_null($news->views)) {
            $news->views = 1;
        } else {
            $news->views = $news->views + 1;
        }
        $news->save();
        return $this->sendResponse($news, 'News retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();

        if ($user->roles->contains('name', 'admin')) {
            $input = $request->all();
            $news = News::find($id);
            $validator = Validator::make($input, [
                'category_id' => 'required',
                'title' => 'required',
                'news_text' => 'required',
                'news_preview' => 'required'
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }
            $news->category_id = $input['category_id'];
            $news->title = $input['title'];
            $news->news_text = $input['news_text'];
            $news->news_preview = $input['news_preview'];
            $news->publication_date = $input['publication_date'] ?? $news->publication_date;
            $news->views = $input['views'] ?? $news->views ?? 0;
            $news->save();

            return $this->sendResponse($news, 'News updated successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news): JsonResponse
    {
        $news->delete();

        return $this->sendResponse([], 'News deleted successfully.');
    }

}
