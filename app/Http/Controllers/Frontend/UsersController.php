<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostMedia;
use App\Models\Comment;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\File;

use Stevebauman\Purify\Facades\Purify;
class UsersController extends Controller
{
    public function __counstruct(){
        $this->middleware(['auth','verified']);
    }
    public function index(){
        $posts = auth()->user()->posts()->with(['media','category','user'])
        ->withCount('comments')
        ->orderBy('id','desc')->paginate(10);
         return view('frontend.users.dashboard')->with('posts' , $posts);
    }
    
    public function edit_info(){
        return view('frontend.users.edit_info');
    }
    public function update_info(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'email'         => 'required|email',
            'mobile'        => 'required|numeric',
            'bio'           => 'nullable|min:10',
            'receive_email' => 'required',
            'user_image'    => 'nullable|image|max:20000,mimes:jpeg,jpg,png'
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data['name']           = $request->name;
        $data['email']          = $request->email;
        $data['mobile']         = $request->mobile;
        $data['bio']            = $request->bio;
        $data['recive_emails']  = $request->receive_email;

        if ($image = $request->file('user_image')) {
            if (auth()->user()->user_image != ''){
                if (File::exists('/assets/users/' . auth()->user()->user_image)){
                    unlink('/assets/users/' . auth()->user()->user_image);
                }
            }
            $filename = Str::slug(auth()->user()->username).'.'.$image->getClientOriginalExtension();
            $path = public_path('assets/users/' . $filename);
            Image::make($image->getRealPath())->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path, 100);

            $data['user_image'] = $filename;
        }

        $update = auth()->user()->update($data);

        if ($update) {
            return redirect()->back()->with([
                'message' => 'Information updated successfully',
                'alert-type' => 'success',
            ]);
        } else {
            return redirect()->back()->with([
                'message' => 'Something was wrong',
                'alert-type' => 'danger',
            ]);
        }
    }
    public function update_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password'  => 'required',
            'password'          => 'required|confirmed'
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = auth()->user();
        if (Hash::check($request->current_password, $user->password)) {
            $update = $user->update([
                'password' => bcrypt($request->password),
            ]);

            if ($update) {
                return redirect()->back()->with([
                    'message' => 'Password updated successfully',
                    'alert-type' => 'success',
                ]);
            } else {
                return redirect()->back()->with([
                    'message' => 'Something was wrong',
                    'alert-type' => 'danger',
                ]);
            }

        } else {
            return redirect()->back()->with([
                'message' => 'Something was wrong',
                'alert-type' => 'danger',
            ]);
        }
    }

    public function create_post(){
        $categories = Category::whereStatus(1)->pluck('name' , 'id');
        return view('frontend.users.create_post')->with('categories' , $categories);
    }
    public function store_post(Request $request){
        // validate 
        $validateor =  Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description'=> 'required|min:50',
            'status' => 'required',
            'comment_able' => 'required',
            'category_id' => 'required',
        ]);

        if($validateor->fails()){
            return redirect()->back()->withErrors($validateor)->withInput();
        }
        $data =[
            'title'=> $request->title,
            'description'=> Purify::clean($request->description),
            'status'=> $request->status,
            'comment_able'=> $request->comment_able,
            'category_id'=> $request->category_id,
            // 'user_id' => auth()->user()->id,
        ];
        // insert to DB 
        $post= auth()->user()->posts()->create($data);
        if($request->images && count($request->images) > 0 ){
            $i = 1;
            foreach($request->images as $file){
                $ldate = date('Y-m-d H:i:s');

                $filename =    $post->slug .'-'. time() . '-' . $i . '.' . $file->getClientOriginalExtension();
                $file_size =  $file->getSize();
                $file_type  =  $file->getMimeType();
                $path = public_path('assets/posts/' . explode("-",$ldate)[0] .'/' . explode("-",$ldate)[1]  . '/'  );
                if (!file_exists($path)) {
                    mkdir($path, 666, true);
                }
                $path .=   $filename ;
                $filename  =  explode("-",$ldate)[0] .'/' . explode("-",$ldate)[1]  . '/' . $filename ;
                Image::make($file->getRealPath())->resize(800,null, function($cons){ $cons->aspectRatio();})->save($path,100);
                $post->media()->create([
                    'file_name' => $filename,
                    'file_size'=> $file_size,
                    'file_type' => $file_type,
                ]);
                $i++;
            }
        }
        if ($request->status == 1){
            Cache::forget('recent_posts');
        }

        return redirect()->back()->with([
            'message' => 'Post created successfully ',
            'alert-type' => 'success',
        ]);
    }
    public function edit_post($id){

        $post = Post::whereSlug($id)->orWhere('id' , $id)->whereUserId(auth()->id())->first();
        if($post){
            $categories = Category::whereStatus(1)->pluck('name' , 'id');
            return view('frontend.users.edit_post')->with('categories' , $categories)->with('post',$post);
        }
        return redirect()->route('frontend.index');
    }
    public function update_post(Request $request , $id){
          // validate 
          $validateor =  Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description'=> 'required|min:50',
            'status' => 'required',
            'comment_able' => 'required',
            'category_id' => 'required',
        ]);

        if($validateor->fails()){
            return redirect()->back()->withErrors($validateor)->withInput();
        }
        $post = Post::whereSlug($id)->orWhere('id' , $id)->whereUserId(auth()->id())->first();
        if($post){ 
        $data =[
            'title'=> $request->title,
            'description'=> Purify::clean($request->description),
            'status'=> $request->status,
            'comment_able'=> $request->comment_able,
            'category_id'=> $request->category_id,
        ]; ;
        $post->update($data);
        if($request->images && count($request->images) > 0 ){
            $i = 1;
            foreach($request->images as $file){
                $ldate = date('Y-m-d H:i:s');
                $filename =    $post->slug .'-'. time() . '-' . $i . '.' . $file->getClientOriginalExtension();
                $file_size =  $file->getSize();
                $file_type  =  $file->getMimeType();
                $path = public_path('assets/posts/' . explode("-",$ldate)[0] .'/' . explode("-",$ldate)[1]  . '/'  );
                if (!file_exists($path)) {
                    mkdir($path, 666, true);
                }
                $path .=   $filename ;
                $filename  =  explode("-",$ldate)[0] .'/' . explode("-",$ldate)[1]  . '/' . $filename ;
                Image::make($file->getRealPath())->resize(800,null, function($cons){ $cons->aspectRatio();})->save($path,100);
                $post->media()->create([
                    'file_name' => $filename,
                    'file_size'=> $file_size,
                    'file_type' => $file_type,
                ]);
                $i++;
            }
         }
         return redirect()->back()->with([
             'message' => 'Post updated successfully',
             'alert-type' => 'success'
         ]);
        }
        return redirect()->back()->with([
            'message' => 'Some thing was wrong',
            'alert-type' => 'anger'
        ]);
    }
    public function destroy_post( $id ){
        $post = Post::whereSlug($id)->orWhere('id' , $id)->whereUserId(auth()->id())->first();
        if($post){
            if($post->media->count() > 0 ){
                foreach($post->media as $media){
                    if($media){
                        if(File::exists('assets/posts/'. $media->file_name)){
                            unlink('assets/posts/' . $media->file_name);
                        } 
                }
                
            }
        }
        $post->delete();
        return redirect()->back()->with([
            'message' => 'Sccessfully delete post ',
            'alert-type' => 'success'
        ]);
    }
    return redirect()->back()->with([
        'message' => 'Something was wrong',
        'alert-type' => 'danger'
    ]);
  }
    public function destroy_post_media($id){
        $media = PostMedia::whereId($id)->first();
        if($media){
            if(File::exists('assets/posts/'. $media->file_name)){
                unlink('assets/posts/' . $media->file_name);
            }
            $media->delete();
            return true;
        }else{
            return false;
         }
    }


    public function show_comments(){
        $posts_id = auth()->user()->posts->pluck('id')->toArray();
        $comments =  Comment::whereIn('post_id', $posts_id)->paginate(10);
        return view('frontend.users.comments')->with('comments' , $comments)        ;
    }
    
    
    public function edit_comment($id){
        $comment =  Comment::whereId($id)->whereHas('post',function($query){
            $query->where('posts.user_id' , auth()->id());
        })->first(); 
         if($comment){
            return view('frontend.users.edit_comment')->with('comment' ,$comment);
        }
        return redirect()->back()->with([
            'message' => 'Something was wrong',
            'alert-type' => 'danger'
        ]);
 
    }
    
    public function update_comment(Request $request , $id){
           // validate 
           $validateor =  Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email'=> 'required|email',
            'url' => 'nullable|url',
            'status' => 'required',
            'comment' => 'required',
        ]);

        if($validateor->fails()){
            return redirect()->back()->withErrors($validateor)->withInput();
        }
        $comment =  Comment::whereId($id)->whereHas('post',function($query){
            $query->where('posts.user_id' , auth()->id());
        })->first(); 
         if($comment){
           $data =[
            'name'=> $request->name,
            'email'=> $request->email,
            'url'=> ($request->url != '') ?  $request->url  : null,
             'status'=> $request->status,
            'comment'=> Purify::clean($request->comment),
           ];
             $comment->update($data);
             
        if ($request->status == 1){
            Cache::forget('recent_comments');
        }
            return  redirect()->back()->with([
                'message' => 'comment updated successfully',
                'alert-type' => 'success'
            ]);
        }
        
        return redirect()->back()->with([
            'message' => 'Something was wrong',
            'alert-type' => 'danger'
        ]);
    }
    
    public function destroy_comment($id){
        $comment =  Comment::whereId($id)->whereHas('post',function($query){
            $query->where('posts.user_id' , auth()->id());
        })->first();
        if($comment){
            $comment->delete();
            
        if ($request->status == 1){
            Cache::forget('recent_comments');
        }
        return  redirect()->back()->with([
            'message' => 'comment deleted successfully',
            'alrt-type' => 'danger'
        ]);
        }
        
        return redirect()->back()->with([
            'message' => 'Something was wrong',
            'alert-type' => 'danger'
        ]);
    }

}