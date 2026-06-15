@extends('emails.layout')

@section('title', 'Your GOS MOMO Verification Code')

@section('content')
<h2>Hello!</h2>
<p>You requested a One-Time Password (OTP) to log in or register at GOS MOMO. Please use the following 6-digit code to verify your session:</p>

<div class="highlight">
    {{ $otp }}
</div>

<p>This code is valid for <strong>10 minutes</strong>. If you did not request this OTP, please ignore this email or contact support if you have concerns.</p>

<p>Warm regards,<br>Team GOS MOMO</p>
@endsection
