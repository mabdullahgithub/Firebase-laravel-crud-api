<?php

namespace App\Http\Controllers;
use App\Services\FirebaseService;
use Illuminate\Http\Request;

class TestController extends Controller
{
    private $database;

public function __construct()
{
    $this->database = FirebaseService::connect();
}

public function create(Request $request) 
{
    $this->database
        ->getReference('test/blogs/' . $request['title'])
        ->set([
            'title' => $request['title'] ,
            'content' => $request['content']
        ]);

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Blog has been created',
            'blog' => [
            'title' => $request['title'] ,
            'content' => $request['content']
            ]
        ], 200);
}

public function index() 
{
    return response()->json($this->database->getReference('test/blogs')->getValue());
}

public function edit(Request $request) 
{
    $this->database->getReference('test/blogs/' . $request['title'])
        ->update([
            'content/' => $request['content']
        ]);

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Blog has been updated',
            'blog' => [
            'title' => $request['title'] ,
            'content' => $request['content']
            ]
        ], 200);
}

public function delete(Request $request)
{
    $this->database
        ->getReference('test/blogs/' . $request['title'])
        ->remove();

        return response()->json([
            'status' => 'success', 
            'code' => 200,
            'message' => 'Blog has been deleted',
            'title' => $request['title']
        ], 200);
}

}
