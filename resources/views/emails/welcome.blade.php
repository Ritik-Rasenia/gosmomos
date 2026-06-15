@extends('emails.layout')

@section('title', 'Welcome to GOS MOMO!')

@section('content')
<h2>Welcome to GOS MOMO, {{ $user->name }}!</h2>
<p>Thank you for registering an account with us. We are absolutely thrilled to have you as part of our momo-loving family!</p>

<p>Here is what you can do next:</p>
<ul>
    <li>Explore our delicious range of street-style crispy momos on our <a href="{{ route('menu.index') }}">online menu</a>.</li>
    <li>Enjoy instant ordering with our fast checkout.</li>
    <li>Track your active order delivery directly on our web application.</li>
    <li>Add funds to your secure wallet to pay with a single click.</li>
</ul>

<p>Your referral code is: <strong style="color: #FF7A00;">{{ $user->referral_code }}</strong>. Share this code with friends and family to earn rewards!</p>

<div style="text-align: center;">
    <a href="{{ route('menu.index') }}" class="btn-action">Order Now</a>
</div>

<p>If you have any questions or feedback, our support team is always ready to assist you.</p>

<p>Get ready to taste the momos that India queues for!</p>

<p>Warm regards,<br>Team GOS MOMO</p>
@endsection
