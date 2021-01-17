<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;;
use App\Models\Post;
use App\Models\Contact;
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
              $data['url'] = $request->url;
              $data['ip_address'] = $request->ip();
              $data['comment'] = $request->comment;
              $data['post_id'] = $post->id;
              $data['user_id'] = $userId;
              $post->comments()->create($data);
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
        $data['message'] = $request->message;
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
}
