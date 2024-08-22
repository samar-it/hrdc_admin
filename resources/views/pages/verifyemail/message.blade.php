<?php 
	$user_id = $id ?? request()->id;
?>
@extends('layouts.info')
@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card card-body my-5">
				<div class="card-header"><i class="icon dripicons-mail"></i> {{ __('Verify Your Email Address') }}</div>
				<div class="card-body">
					
					<?php Html::display_page_errors($errors); ?>
				
					@if (!empty($message))
					<div class="alert alert-success animated bounce" role="alert">
						{{ $message }}
					</div>
					@endif
					
					Please verify your email address by following the link in your mailbox

					<hr />
					<div class="text-center">
						<a class="btn btn-sm btn-info" href="{{ route('verification.resend', ['id' => $user_id]) }}">
							<i class="icon dripicons-mail"></i> Resend Email
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection