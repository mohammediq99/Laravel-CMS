 
@extends('layouts.app')
@section('content')


  <!-- Start Blog Area -->
  <div class="page-blog bg--white section-padding--lg  col-9 blog-sidebar right-sidebar">
        	<div class="container">
        		<div class="row">
        			<div class="col-lg-9 col-12">
        				<div class="blog-page"> 
                        <table>
                        <thead>
                        <th>name</th>
                        <th>Post</th>
                        <th>Status</th>
                        <th>Action</th>
                        </thead>
                        <tbody>
                       
                        @forelse($comments as $comment)
                        <tr>
                        

                           <td>{{ $comment->name }}</td>
                           <td>{{ $comment->post->title }}</td>
                           <td>{{ $comment->status ? 'Published' : 'Not Published' }}</td>
                           <td>
                           <a href="{{ route('users.comment.edit', $comment->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                           <a href="javascript:void(0);" class="btn btn-sm btn-danger" onclick="if (confirm('Are you sure to delete this Comment?') ) { document.getElementById('comment-delete-{{ $comment->id }}').submit(); } else { return false; }"><i class="fa fa-trash"></i></a>
                           <form action="{{ route('users.comment.destroy', $comment->id) }}" method="post" id="comment-delete-{{ $comment->id }}" >
                           @csrf 
                           @method('DELETE')
                           </form>
                           </td>
                        </tr>

                        @empty
                        <tr>
                        <td colspan="4">No comments Found</td>
                        </tr> 
                        @endforelse 
                        </tbody>
                        <tfoot>
                        <tr>
                        <td cosplan="4">{!! $comments->links() !!}</td></tr></tfoot>
                        </table>
        			 
        				</div>
					 
        			</div>
        			<div class="col-lg-3 col-12 md-mt-40 sm-mt-40">
        			@include('partial.frontend.users.sidebar')
        			</div>
        		</div>
        	</div>
        </div>
        </div>
        <!-- End Blog Area -->

@endsection

  