 
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
                        <th>title</th>
                        <th>Comments</th>
                        <th>Status</th>
                        <th>Action</th>
                        </thead>
                        <tbody>
                       
                        @forelse($posts as $post)
                        <tr>
                        

                           <td>{{ $post->title }}</td>
                           <td>{{ $post->comments_count }}</td>
                           <td>{{ $post->status ? 'Published' : 'Not Published' }}</td>
                           <td>
                           <a href="{{ route('users.post.edit', $post->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                           <a href="javascript:void(0);" class="btn btn-sm btn-danger" onclick="if (confirm('Are you sure to delete this post?') ) { document.getElementById('post-delete-{{ $post->id }}').submit(); } else { return false; }"><i class="fa fa-trash"></i></a>
                           <form action="{{ route('users.post.destroy', $post->id) }}" method="post" id="post-delete-{{ $post->id }}" >
                           @csrf 
                           @method('DELETE')
                           </form>
                           </td>
                        </tr>

                        @empty
                        <tr>
                        <td colspan="4">No posts Found</td>
                        </tr> 
                        @endforelse 
                        </tbody>
                        <tfoot>
                        <tr>
                        <td cosplan="4">{!! $posts->links() !!}</td></tr></tfoot>
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

  