<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(CommentRequest $request,$id){
        Comment::create([
            'body' => $request->input('body'),
            'user_id' => Auth::id(),
            'product_id' => $id,
        ]);
        return redirect()->route('product.show',['id' => $id ]);
    }
}
