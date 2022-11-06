<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="author" content="Kodinger">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>My Login Page &mdash; Bootstrap 4 Login Page Snippet</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/my-login.css">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="js/my-login.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

</head>

<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper">
					<div class="brand">
						<img src="img/logo.jpg" alt="bootstrap 4 login page">
					</div>
					<div class="card fat">
						<div class="card-body">
							<h4 class="card-title">Register</h4>
							@if (count($errors) > 0)

							<div class="alert alert-danger">

								<strong>Whoops!</strong> There were some problems with your input.

								<ul>

									@foreach ($errors->all() as $error)

									<li>{{ $error }}</li>

									@endforeach

								</ul>

							</div>

							@endif
							<form method="POST" class="my-login-validation" action="{{url('/signUp')}}" enctype="multipart/form-data">
								@csrf
								<div class="form-group">
									<label for="name">Name</label>
									<input id="name" type="text" class="form-control" name="name" required autofocus>
									<div class="invalid-feedback">
										What's your name?
									</div>
								</div>

								<div class="form-group">
									<label for="email">Email</label>
									<input id="email" type="email" class="form-control" name="email" required>
									<div class="invalid-feedback">
										Your email is invalid
									</div>
								</div>
								<div class="form-group">
									<label for="phone">Phone Number</label>
									<input id="phone" type="number" class="form-control" name="phone" required autofocus>
									<div class="invalid-feedback">
										What's your phone number?
									</div>
								</div>
								<div class="form-group">
									<label for="birthdate">Birthdate</label>
									<input id="birthdate" type="date" class="form-control" name="birthdate" autofocus>
								</div>
								<div class="form-group">
									<label for="password">Password</label>
									<input id="password" type="password" class="form-control" name="password" minlength="8" required data-eye>
									<div class="invalid-feedback">
										Password is required and it contains at least 8 characters
									</div>
								</div>
								<div class="form-group">
									<label for="User_image">Your Image</label>
									<input id="User_image" type="file" class="form-control" name="User_image" accept="image/*" required autofocus>
									<div class="invalid-feedback">
										Image is required and there size not more than 5 MB
									</div>
								</div>
								<input type="hidden" name="role" value="user">
								<div class="form-group m-0">
									<button type="submit" class="btn btn-primary btn-block">
										Register
									</button>
								</div>
								<div class="mt-4 text-center">
									Already have an account? <a href="{{url('/')}}">Login</a>
								</div>
								@if(isset($_GET['registeredBy']))
								<input type="hidden" name="registeredBy" value="{{$_GET['registeredBy']}}">
								@endif
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</body>
<script>
	window.onload = function() {

		var urlParams = new URLSearchParams(window.location.search);
		if (urlParams.has('registeredBy')) {
			$.ajax({
			type: 'get',
			url: "{{url('incrementVisit')}}".concat('/', urlParams.get('registeredBy')),
		});
		}
	};
	
</script>

</html>