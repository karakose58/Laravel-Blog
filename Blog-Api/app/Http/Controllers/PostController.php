<?php

namespace App\Http\Controllers;

use App\Models\Post; 
use Illuminate\Http\Request; 
use App\Models\Comment;
use App\Models\Category;
use App\Models\User;
use App\Models\Kvkk;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommentMail;
Use App\Http\Requests\CommentRequest;
use App\Traits\ApiResponse;

class PostController extends Controller
{

    use ApiResponse;

    //yorum ekleme
    public function addcomment(CommentRequest $request, $postId)
    {
        $post = Post::find($postId);

        if (!$post) {
            return $this->error('Post bulunamadı', 404);
        }

        $comment = new Comment($request->validated());
        $comment->author = auth()->user()->name;
        $comment->content = $request->content;
        $comment->user_id = auth()->id();

        $post->comments()->save($comment);

        $admins = User::role('admin')->get();

        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new CommentMail($comment->content, auth()->user()->name));
        }

        return $this->success($comment, 'Yorum başarıyla eklendi.', 201);
    }





    public function listProducts()
    {
        $posts = Post::with(['category' => fn($q) => $q->active(), 'comments' => fn($q) => $q->active()])
            ->active()
            ->whereHas('category', fn($q) => $q->active())
            ->get();

        return $this->success($posts, 'Postlar başarıyla listelendi.');
    }

    


    public function alphabetic() // burda postları alfabetik sıralıyor
    {
        $posts = Post::with(['category' => fn($q) => $q->active(), 'comments' => fn($q) => $q->active()])
            ->active()
            ->whereHas('category', fn($q) => $q->active())
            ->orderBy('title')
            ->get();



        return $this->success($posts, 'Postlar alfabetik olarak sıralandı.');


    }

    public function new(){//burda en yenileri sıralıyor
        $posts = Post::with(['category' => fn($q) => $q->active(), 'comments' => fn($q) => $q->active()])
            ->active()
            ->whereHas('category', fn($q) => $q->active())
            ->orderBy('created_at', 'desc')
            ->get();

        return $this->success($posts, 'En yeni postlar listelendi.');
    }


    public function old(){//burda en eskileri sıralıyor
        $posts = Post::with(['category' => fn($q) => $q->active(), 'comments' => fn($q) => $q->active()])
            ->active()
            ->whereHas('category', fn($q) => $q->active())
            ->orderBy('created_at', 'asc')
            ->get();

        return $this->success($posts, 'En eski postlar listelendi.');
    }

    public function popular()// burda yorum sayısı en fazla olan kullanıcıları sıralıyor
    {
        $posts = Post::withCount(['comments' => fn($q) => $q->active()])
            ->active()
            ->whereHas('category', fn($q) => $q->active())
            ->orderBy('comments_count', 'desc')
            ->get();

        return $this->success($posts, 'Popüler postlar listelendi.');
    }
    
    
public function getProduct($id)
{
        $post = Post::with(['comments' => fn($q) => $q->active()])->find($id);

        if (!$post) {
            return $this->error('Post bulunamadı', 404); 
        }

        return $this->success($post, 'Post başarıyla getirildi'); 
}



public function getTags($tag)//tag ile post çağırma
{
        $posts = Post::with(['comments' => fn($q) => $q->active()])
            ->whereJsonContains('tags', $tag)
            ->get()
            ->map(function ($post) {
                $post->comments = $post->comments->filter(fn($c) => $c->status == 1);
                return $post;
            });

        return $this->success($posts, 'Etikete göre postlar getirildi.');
}




    


    


    




















    
}
