  
<!-- Header -->
<header id="wn__header" class="oth-page header__area header__absolute sticky__header">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-4 col-sm-4 col-7 col-lg-2">
						<div class="logo">
							<a href="{{ route('frontend.index') }}">
								<img src="{{ asset('frontend/images/logo/logo.png') }}" alt="logo images">
							</a>
						</div>
					</div>
					<div class="col-lg-8 d-none d-lg-block">
						<nav class="mainmenu__nav">
							<ul class="meninmenu d-flex justify-content-start">
								<li class="drop with--one--item"><a href="{{ route('frontend.index') }}">Home</a></li>
								<li class="drop with--one--item"><a href="{{ route('post.show' , 'about-us') }}">about us</a></li>
								<li class="drop with--one--item"><a href="{{ route('post.show' , 'our-vision') }}">our Vision</a></li>
							    
								<li class="drop"><a href="javascript:void(0);">Blog</a>
									<div class="megamenu dropdown">
										<ul class="item item01">
 
								        @foreach($global_categories as $category)
        					        		<li><a href="{{ route('frontend.category.posts', $category->slug ) }}">{{ $category->name }}</a></li>
        					            @endforeach
										</ul>
									</div>
								</li>
								<li><a href="{{ route('frontend.contact') }}">Contact</a></li>
							</ul>
						</nav>
					</div>
					<div class="col-md-8 col-sm-8 col-5 col-lg-2">
						<ul class="header__sidebar__right d-flex justify-content-end align-items-center">
							<li class="shop_search"><a class="search__active" href="#"></a></li>

 							<li class="shopcart"><a class="cartbox_active" href="#"><span class="product_qun">3</span></a>
								<!-- Start Shopping Cart -->
								<div class="block-minicart minicart__active">
									<div class="minicart-content-wrapper">
										<div class="micart__close">
											<span>close</span>
										</div>
										<!-- <div class="items-total d-flex justify-content-between">
											<span>3 items</span>
											<span>Cart Subtotal</span>
										</div> -->
										<!-- <div class="total_amount text-right">
											<span>$66.00</span>
										</div> -->
										<!-- <div class="mini_action checkout">
											<a class="checkout__btn" href="cart.html">Go to Checkout</a>
										</div> -->
										<div class="single__items">
											<div class="miniproduct">

												<div class="item01 d-flex">
													<div class="thumb">
														<a href="product-details.html"><img src=" {{ asset('assets/posts/default_small.jpg') }}" width="50px" height="50px" alt="product images"></a>
													</div>
													<div class="content">
														<h6><a href="product-details.html">Voyage Yoga Bag</a></h6>
														<span class="prize">$30.00</span>
														<div class="product_prize d-flex justify-content-between">
															<span class="qun">Qty: 01</span>
															<ul class="d-flex justify-content-end">
																<li><a href="#"><i class="zmdi zmdi-settings"></i></a></li>
																<li><a href="#"><i class="zmdi zmdi-delete"></i></a></li>
															</ul>
														</div>
													</div>
												</div>
												
 											</div>
										</div>
										<!-- <div class="mini_action cart">
											<a class="cart__btn" href="cart.html">View and edit cart</a>
										</div> -->
									</div>
								</div>
								<!-- End Shopping Cart -->
							</li>
							<li class="setting__bar__icon"><a class="setting__active" href="#"></a>
								<div class="searchbar__content setting__block">
									<div class="content-inner"> 
											 
											 
										<div class="switcher-currency">
											<strong class="label switcher-label">
												<span>My Account</span>
											</strong>
											<div class="switcher-options">
												<div class="switcher-currency-trigger">
													<div class="setting__menu">
														 @guest
														 <span><a href="{{ route('frontend.show_login_form') }}">{{ __('Login')}}</a></span>
													     <span><a href="{{ route('frontend.show_register_form') }}">{{ __('Register')}}</a></span>
 														@else
													     <span><a href="{{ route('frontend.dashboard') }}">Dashboard</a></span>
														<span><a href="" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></span>
														<form action="{{ route('frontend.logout') }}" method="POST" style="display:none;" id="logout-form"> @csrf </form>
														@endif
 													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<!-- Start Mobile Menu -->
				<div class="row d-none">
					<div class="col-lg-12 d-none">
						<nav class="mobilemenu__nav">
							<ul class="meninmenu">
								<li><a href="{{ route('frontend.index') }}">Home</a></li>
								
								<li><a href="{{ route('post.show' , 'about-us') }}">About Page</a></li>
								<li><a href="{{ route('post.show' , 'our-vision') }}">Portfolio</a>
										
							  
								<li><a href="javascript:void(0)">Blog</a>
									<ul>
										<li><a href="blog.html">Blog Page</a></li>
									</ul>
								</li>
								<li><a href="{{ route('frontend.contact') }}">Contact</a></li>
							</ul>
						</nav>
					</div>
				</div>
				<!-- End Mobile Menu -->
	            <div class="mobile-menu d-block d-lg-none">
	            </div>
	            <!-- Mobile Menu -->	
			</div>		
		</header>
		<!-- //Header -->
		<!-- Start Search Popup -->
		<div class="box-search-content search_active block-bg close__top">
			<form id="search_mini_form" class="minisearch" action="#">
				<div class="field__search">
					<input type="text" placeholder="Search entire store here...">
					<div class="action">
						<a href="#"><i class="zmdi zmdi-search"></i></a>
					</div>
				</div>
			</form>
			<div class="close__wrap">
				<span>close</span>
			</div>
		</div>
		<!-- End Search Popup -->
        <!-- Start Bradcaump area -->
        <div class="ht__bradcaump__area bg-image--4">
			
		
        </div>
        <!-- End Bradcaump area -->

