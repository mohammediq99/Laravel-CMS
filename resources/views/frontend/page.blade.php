@extends('layouts.app')
@section('content')


<div class="page-blog-details section-padding--lg  col-9 bg--white">
			<div class="container">
				<div class="row">
					<div class="col-lg-9 col-12">
						<div class="blog-details content">
							<article class="blog-post-details">
                                @if($page->media->count() > 0 )

                                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                   <ol class="carousel-indicators">
                                       @foreach($page->media as $media)
                                     <li data-target="#carouselExampleIndicators" data-slide-to="{{ $loop->index }}" class="{{ $loop->index == 0 ? 'active' : '' }}"></li> 
                                     @endforeach
                                   </ol>
                                   <div class="carousel-inner">
                                   @foreach($page->media as $media)
                                     <div class="carousel-item {{ $loop->index == 0 ? 'active' : '' }}">
                                       <img class="d-block w-100" src="{{ asset('assets/posts/'. $page->media->file_name) }}" alt="{{ $page->title }}">
                                     </div>
                                   @endforeach  
                                   </div>
                                  @if($page->media->count() > 1 )

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
										<h2>{{ $page->title }} </h2>
										<div class="blog-date-categori">
											 
										</div>
									</div>
									<div class="post_content"> 
                                        <p>
                                            {!! $page->description !!}
                                        </p>
                                    </div>
								</div>
							</article>
							  
						</div>
					</div>
				</div>
			</div>
		</div>
@endsection