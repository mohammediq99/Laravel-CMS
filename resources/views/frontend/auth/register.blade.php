@extends('layouts.app')

@section('content')
<section class="my_account_area pt--80  col-9 pb--55 bg--white">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 offset-md-3">
						<div class="my__account__wrapper">
                            <h3 class="account__title">Register</h3>
                            {!! Form::open(['route' => 'frontend.register' , 'method'=>'POST' , 'files'=> true]) !!}
								<div class="account__form">
									<div class="input__box">
                                        {!! Form::label('name' , 'name *') !!}
                                        {!! Form::text('name', old('name')) !!}
                                        @error('username') <span class="text-danger">{{$message }}</span>@enderror
									</div>
									<div class="input__box">
                                        {!! Form::label('username' , 'username *') !!}
                                        {!! Form::text('username', old('username')) !!}
                                        @error('username') <span class="text-danger">{{$message }}</span>@enderror
									</div>
									<div class="input__box">
                                        {!! Form::label('email' , 'Email *') !!}
                                        {!! Form::email('email', old('email')) !!}
                                        @error('email') <span class="text-danger">{{$message }}</span>@enderror
									</div>
									<div class="input__box">
                                        {!! Form::label('mobile' , 'Mobile *') !!}
                                        {!! Form::text('mobile', old('mobile')) !!}
                                        @error('mobile') <span class="text-danger">{{$message }}</span>@enderror
									</div>
									<div class="input__box">
                                        {!! Form::label('password' , 'Password *') !!}
                                        {!! Form::password('password' ) !!} 
                                        @error('password') <span class="text-danger">{{$message }}</span>@enderror
									</div>
									<div class="input__box">
                                        {!! Form::label('password_confirmation' , 'Re-password *') !!}
                                        {!! Form::password('password_confirmation' ) !!} 
                                        @error('password_confirmation') <span class="text-danger">{{$message }}</span>@enderror
									</div>
									<div class="input__box">
                                        {!! Form::label('user_image' , 'User Image') !!}
                                        {!! Form::file('user_image' , ['class' => 'cutom-file'] ) !!} 
                                        @error('user_image') <span class="text-danger">{{$message }}</span>@enderror
									</div>
									<div class="form__btn">
                                        {!! Form::button('Creat New Account',['type' => 'submit']) !!}
										 
                                    </div>
                                     
 								</div>
							{!! Form::close() !!}
						</div>
					</div> 
				</div>
			</div>
		</section> 

 
@endsection
