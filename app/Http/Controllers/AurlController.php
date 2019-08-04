<?php

namespace App\Http\Controllers;

use App\Models\LocalArticle;
use App\Models\URL;

class AurlController extends Controller
{
    public function index($id)
    {
        $article = LocalArticle::query()
            ->where('id', $id)
            ->first();
        if (!empty($article->right_now)) { //立即跳转
            return redirect($article->right_now);
        }
        $url = URL::query()
            ->where('user_id', $article->user_id)
            ->where('type', URL::B)
            ->inRandomOrder()
            ->first()
            ->url;
        return view('articles.AJump', [
            'host' => $url,
            'id' => $id,
            'timestampUrl' => time(),
            'article' => $article
        ]);
    }
}
