<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>DH</title>
		<link rel="stylesheet" href="{{ asset('/css/plugins.css') }}"/>
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
	</head>
	<body id="page-top">
			<h5 class="alert alert-info text-center">After Five minutes Page will be expired</h5>
		<div class="container" style="margin-top: 250px !important">
			<div class="card o-hidden border-0 shadow-lg my-5">
				<div class="card-body p-0">
					<!-- Nested Row within Card Body -->
					<div class="row">
						<div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
						<div class="col-lg-7">
							<div class="p-5">
								<div class="text-center">
									<h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
								</div>
								<form class="user" method="post" action="{{ route('forgotPass') }}">
									 @csrf
									<div class="form-group">
										<input type="email" class="form-control form-control-user" id="exampleInputEmail" placeholder="Email Address" name="email">
										<!-- @error('email')<span style="color: red;font-style: italic;">{{$message}}</span>@enderror -->
										@if($errors->has('email'))
										    <div class="error">{{ $errors->first('email') }}</div>
										@endif
									</div>
									<div class="form-group row">
										<div class="col-sm-6 mb-3 mb-sm-0">
											<input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" name="password">
											<!-- @error('password')<span style="color: red;font-style: italic;">{{$message}}</span>@enderror -->
											@if($errors->has('password'))
										      <div class="error">{{ $errors->first('password') }}</div>
										    @endif
										</div>
										<div class="col-sm-6">
											<input type="password" class="form-control form-control-user" id="exampleRepeatPassword" placeholder="Repeat Password" name="c_password">
											<!-- @error('c_password')<span style="color: red;font-style: italic;">{{$message}}</span>@enderror -->
											@if($errors->has('c_password'))
										      <div class="error">{{ $errors->first('c_password') }}</div>
										    @endif
										</div>
									</div>
									<button type="submit" class=" btn btn-primary">Update Password</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
