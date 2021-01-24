<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;;
use App\Models\Post;
use App\Models\Contact;
use App\Models\Category;
use App\Models\User;
use App\Notifications\NewCommentForPostOwnerNotify;
use Stevebauman\Purify\Facades\Purify;
class IndexController extends Controller
{
    public function index(){
        $posts  = Post::with(['category' , 'media','comments','user'])
        ->whereHas('category',function ($query){
            $query->whereStatus(1);
        })
        ->whereHas('user',function($query){
            $query->whereStatus(1);
        })
        ->wherePostType('post')->whereStatus(1)->orderBy('id','desc')->paginate(5);
        return view('frontend.index')
        ->with('posts', $posts );
    }
    public function post_show($slug){
        $post = Post::with(['category' , 'user','media',
        'approved_comments' => function ($query){
            $query->orderBy('id','desc');
        }]);
        $post = $post->whereHas('category', function($query){
            $query->whereStatus(1);
        })
        ->whereHas('user',function($query){
            $query->whereStatus(1);
        }) 
        ->whereStatus(1);
        $post = $post->whereSlug($slug)->first();
        if($post){
           $blade =  ($post->post_type == 'post') ? 'post' : 'page';
            return view('frontend.'. $blade )->with(''.$blade , $post);
        }else{
            return redirect()->route('frontend.index');
        }
    } 
    public function store_comment( Request $request , $slug){
      $validation = Validator::make($request->all(), [
          'name' => 'required',
          'email' => 'required|email',
          'url' => 'nullable|url',
          'comment' => 'required|min:10'
      ]);
      if($validation->fails()){
          return redirect()->back()->withErrors($validation)->withInput();
      }
      $post = Post::whereSlug($slug)->wherePostType('post')->whereStatus(1)->first();
      if($post){
          $userId = auth()->check() ? auth()->id : null;
              $data['name'] = $request->name;
              $data['email'] = $request->email;
              $data['url'] = $request->url != '' ? $request->url  : '';
              $data['ip_address'] = $request->ip();
              $data['comment'] = Purify::clean($request->comment);
              $data['post_id'] = $post->id;
              $data['user_id'] = $userId;
              $comment = $post->comments()->create($data);
              if((auth()->guest() || (auth()->id() != $post->user_id)) && $comment ){
                  $post->user->notify(new NewCommentForPostOwnerNotify($comment));
              }
            //   Comment::create($data);
            return redirect()->back()->with([
                'message' => 'comment added successfully',
                'alert-type' => 'success'
            ]);
      }
      return redirect()->back()->with([
        'message' => 'Something wrong',
        'alert-type' => 'danger'
    ]);
    }
    public function contact(){
        return view('frontend.contact');
    }
    public function do_contact(Request $request){
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'nullable|numeric',
            'title' => 'required|min:5',
            'message' => 'required|min:10'
        ]); 
        if($validation->fails()){
            return redirect()->back()->withErrors($validation)->withInput();
        }
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['mobile'] = $request->mobile;
        $data['title'] = $request->title;
        $data['message'] = Purify::clean($request->message);
        Contact::create($data);
        return redirect()->back()->with([
            'message' => 'Message sent successfully',
            'alert-type' => 'success'
        ]);
 
    }
    public function search(Request $request){

        $keyword = isset($request->keyword) && $request->keyword  != '' ? $request->keyword : null;
        $posts  = Post::with(['category' , 'media','comments','user'])
        ->whereHas('category',function ($query){
            $query->whereStatus(1);
        })
        ->whereHas('user',function($query){
            $query->whereStatus(1);
        });
        if($keyword != null){
            $posts = $posts->search($keyword,null , true);
        }

        $posts = $posts->wherePostType('post')->whereStatus(1)->orderBy('id','desc')->paginate(10);
        return view('frontend.index')->with('posts' , $posts);
    }
    public function category($slug){
        $category = Category::whereSlug($slug)->orWhere('id',$slug)->whereStatus(1)->first()->id;
        if($category){
            $posts = Post::with(['media','user','category'])
            ->withCount('approved_comments')
            ->whereCategoryId($category)
            ->wherePostType('post')
            ->whereStatus(1)
            ->orderBy('id','desc')
            ->paginate(5);
            return view('frontend.index')->with('posts' , $posts);
        }
        return redirect()->route('frontend.index');

    }
    public function archive($date){
        // Month-Year 01-2021
        $exploded_date = explode('-',$date);
        $month = $exploded_date[0];
        $year = $exploded_date[1];
        $posts = Post::with(['media','user','category'])
        ->withCount('approved_comments') 
        ->whereMonth('created_at' , $month)
        ->whereYear('created_at' , $year)
        ->wherePostType('post')
        ->whereStatus(1)
        ->orderBy('id','desc')
        ->paginate(5);
        return view('frontend.index')->with('posts' , $posts);

    }
    
    public function auther($username){
        $user = User::whereUsername($username)->whereStatus(1)->first()->id;
        if($user){
            $posts = Post::with(['media','user','category'])
            ->withCount('approved_comments')
            ->whereUserId($user)
            ->wherePostType('post')
            ->whereStatus(1)
            ->orderBy('id','desc')
            ->paginate(5);
            return view('frontend.index')->with('posts' , $posts);
        }
        return redirect()->route('frontend.index');
    }
}
