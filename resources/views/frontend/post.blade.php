@extends('layouts.app')
@section('content')


<div class="page-blog-details section-padding--lg  col-9 bg--white">
			<div class="container">
				<div class="row">
					<div class="col-lg-9 col-12">
						<div class="blog-details content">
							<article class="blog-post-details">
                                @if($post->media->count() > 0 )

                                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                   <ol class="carousel-indicators">
                                       @foreach($post->media as $media)
                                     <li data-target="#carouselExampleIndicators" data-slide-to="{{ $loop->index }}" class="{{ $loop->index == 0 ? 'active' : '' }}"></li> 
                                     @endforeach
                                   </ol>
                                   <div class="carousel-inner">
                                   @foreach($post->media as $media)
                                     <div class="carousel-item {{ $loop->index == 0 ? 'active' : '' }}">
                                       <img class="d-block w-100" src="{{ asset('assets/posts/'. $post->media->file_name) }}" alt="{{ $post->title }}">
                                     </div>
                                   @endforeach  
                                   </div>
                                  @if($post->media->count() > 1 )

                                       <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                         <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                         <span class="sr-only">Previous</span>
                                       </a>
                                       <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                         <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                         <span class="sr-only">Next</span>
                                       </a>
                                     </div>

                                   @endif
                                @endif
                                
								<div class="post_wrapper">
									<div class="post_header">
										<h2>{{ $post->title }} </h2>
										<div class="blog-date-categori">
											<ul>
												<li>{{ $post->created_at->format('M d, Y')  }} </li>
												<li><a href="{{ route('frontend.auther.posts', $post->user->username)  }}" title="Posts by {{ $post->user->name }}" rel="author">{{ $post->user->name }}</a></li>
											</ul>
										</div>
									</div>
									<div class="post_content"> 
                                        <p>
                                            {!! $post->description !!}
                                        </p>
                                    </div>
                                    
									<ul class="blog_meta">
										<li><a href="#">{{ $post->approved_comments->count() }} comment(s)</a></li>
										<li> / </li>
										<li> Category:<span>{{ $post->category->name }}</span> <span>t-shirt</span> <span>white</span></li>
									</ul>
								</div>
							</article>
							<div class="comments_area">
								<h3 class="comment__title">{{ $post->approved_comments->count() }}</h3>
								<ul class="comment__list">
                                    @forelse($post->approved_comments as $comment)
                                    
									<li>
										<div class="wn__comment">
											<div class="thumb">
												<img src="{{ get_gravatar($comment->email, 46) }}" alt="comment images">
											</div>
											<div class="content">
												<div class="comnt__author d-block d-sm-flex">
													<span><a href="{{ $comment->url ? $comment->url : '#'}}">{{ $comment->name }}</a>  </span>
													<span> {{ $comment->created_at->format('M d Y h:i a')}}  </span>
												</div>
												<p>{!! $comment->comment !!}</p>
											</div>
										</div>
                                    </li>
                                    @empty
 										<div class="wn__comment">
											<div class="content">
												<p> No Comments Found</p>
											</div>
										</div>
                                    @endforelse
									<li>
										<div class="wn__comment">
											<div class="thumb">
												<img src="{{ asset('frontend/images/blog/comment/1.jpeg') }}" alt="comment images">
											</div>
											<!-- <div class="content">
												<div class="comnt__author d-block d-sm-flex">
													<span><a href="#">admin</a> Post author</span>
													<span>October 6, 2014 at 9:26 am</span>
													<div class="reply__btn">
														<a href="#">Reply</a>
													</div>
												</div>
												<p>Sed interdum at justo in efficitur. Vivamus gravida volutpat sodales. Fusce ornare sit</p>
											</div> -->
										</div>
                                    </li>
                                     
								</ul>
							</div>
							<div class="comment_respond">
                                <h3 class="reply_title">Leave a Reply <small></small></h3>
                                {!! Form::open(['route' =>[ 'posts.add_comments', $post->slug ], 'method' => 'post' , 'class' => 'comment__form']) !!}

 									<p>Your email address will not be published.Required fields are marked </p>
									<div class="input__box">
                                        {!! Form::textarea('comment' ,old('comment') ,['placeholder' => 'Your Comment here ']) !!}
                                        @error('comment') <span class="text-danger">{{ $message  }} </span>@enderror

 									</div>
									<div class="input__wrapper clearfix">
										<div class="input__box name one--third">
                                        {!! Form::text('name' ,old('name') ,['placeholder' => 'Your name here ']) !!}
                                        @error('name') <span class="text-danger">{{ $message  }} </span>@enderror
											 
										</div>
										<div class="input__box email one--third">
                                        {!! Form::email('email' ,old('email') ,['placeholder' => 'Your email here ']) !!}
                                        @error('email') <span class="text-danger">{{ $message  }} </span>@enderror

 										</div>
										<div class="input__box website one--third">
                                        {!! Form::text('url' ,old('url') ,['placeholder' => 'Your url here ']) !!}
                                        @error('url') <span class="text-danger">{{ $message  }} </span>@enderror

 										</div>
									</div>
									<div class="submite__btn">
                                        {!! Form::submit('Post comment ' , ['class' => 'btnbtn-primary']) !!}

 									</div>
                                 {!! Form::close() !!}
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-12 md-mt-40 sm-mt-40">
        			@include('partial.frontend.sidebar')

					</div>
				</div>
			</div>
		</div>
@endsection