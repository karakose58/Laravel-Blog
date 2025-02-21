<?php

namespace App\Http\Controllers;

use App\Models\Post; 
use Illuminate\Http\Request; 
use App\Models\comment;
use App\Models\Category;
use App\Models\User;
use App\Models\Kvkk;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommentMail;
class PostController extends Controller
{

    
    //yorum ekleme
    public function addcomment(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required|string',
        ]);
    
        $post = Post::findOrFail($postId);//yorum yapılan postu çeker
    
        $comment = new comment();//yorumu kaydeder
        
        $comment->author = auth()->user()->name; //yorum yapan kullanıcının adını çeker
        $comment->content = $request->content;  //yorum içeriğini çeker
        $comment->user_id = auth()->id(); //yorum yapan kullanıcının id sini çeker

        $post->comments()->save($comment); 
        
        $admins = User::role('admin')->get(); //admin kullanıcılarını çeker

        foreach ($admins as $admin) {
            $to = $admin->email; 
            $msg = $comment->content;
            $subject = auth()->user()->name;
            Mail::to($to)->send(new CommentMail($msg, $subject));//admin kullanıcılarına mail atar
        }
    
        return response()->json($comment, 201);
    }




    public function listProducts()//birbiriyle ilişki kurulmuş kategori post ve commentleri 
    {                             //çağıriyor ve aktif olup olmadıklarını kontrol ediyor


        $posts = Post::with(['category' => function ($query) {
            $query->where('status', 1); 
        }, 'comments' => function ($query) {
            $query->where('is_active', 1);
        }])
        ->where('is_active', 1) 
        ->whereHas('category', function ($query) {
            $query->where('status', 1); 
        })
        ->get();
    
        return response()->json($posts);
    }
    


    public function alphabetic(){// burda postları alfabetik sıralıyor
        $posts = Post::with(['category' => function ($query) {
            $query->where('status', 1); 
        }, 'comments' => function ($query) {
            $query->where('is_active', 1);
        }])
        ->where('is_active', 1) 
        ->whereHas('category', function ($query) {
            $query->where('status', 1); 
        })
        ->orderBy('title')
        ->get();
    
        return response()->json($posts);


    }

    public function new(){//burda en yenileri sıralıyor
        $posts = Post::with(['category' => function ($query) {
            $query->where('status', 1); 
        }, 'comments' => function ($query) { 
            $query->where('is_active', 1);
        }])
        ->where('is_active', 1) 
        ->whereHas('category', function ($query) {
            $query->where('status', 1); 
        })
        ->orderBy('created_at','desc')
        ->get();
    
        return response()->json($posts);
    }

    public function old(){//burda en eskileri sıralıyor
        $posts = Post::with(['category' => function ($query) {
            $query->where('status', 1); 
        }, 'comments' => function ($query) {
            $query->where('is_active', 1);
        }])
        ->where('is_active', 1) 
        ->whereHas('category', function ($query) {
            $query->where('status', 1); 
        })
        ->orderBy('created_at','asc')
        ->get();
    
        return response()->json($posts);
    }

    public function popular()// burda yorum sayısı en fazla olan kullanıcıları sıralıyor
    {
        $posts = Post::withCount(['comments' => function ($query) {
            $query->where('is_active', 1);
        }])
        ->where('is_active', 1)  
        ->whereHas('category', function ($query) {
            $query->where('status', 1); 
        })
        ->orderBy('comments_count', 'desc')  
        ->get();
        
        return response()->json($posts);
    }
    
    
    
public function getProduct($id)
{
    $post = Post::with(['comments' => function ($query) {
          $query->where('is_active', 1);//id ile post çağırma
    }])->findOrFail($id);

    return response()->json($post);
}


public function getTags($tag)
{
    $posts = Post::with(['comments' => function ($query) {
        $query->where('is_active', 1);//tag ile post çağırma
    }])
    ->whereJsonContains('tags', $tag)
    ->get()
    ->map(function ($post) {
        $post->comments = $post->comments->filter(function ($comment) {
            return $comment->is_active == 1;
        });
        return $post;
    });

    return response()->json($posts);
}




    


    


    





    public function Category($categoryName)
    {
        $category = Category::where('name', $categoryName)
                            ->where('status', 1) //kategori ile post çağırma
                            ->with('posts')  
                            ->firstOrFail();
            
        return response()->json($category->posts);
    }
    
    



public function ListCategory() //kategorileri listeleme
{
    $categories = Category::where('status', 1)->with(['posts' => function ($query) {
        $query->where('is_active', 1);
    }])->get();

    return response()->json($categories);
}




public function kvkk() //kvkk metnini çağırma
{
    $kvkk = Kvkk::all();
    return response()->json($kvkk);
}









    
}
