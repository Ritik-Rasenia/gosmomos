@extends('emails.layout')

@section('title', 'Contact Message — GOS MOMO')

@section('content')
@if($isAdmin)
    <h2>New Contact Form Message Received!</h2>
    <p>Hello Admin,</p>
    <p>A user has sent a message via the contact form. Details are below:</p>
@else
    <h2>Message Received — GOS MOMO</h2>
    <p>Hello {{ $lead['name'] }},</p>
    <p>Thank you for reaching out to us! We have received your message and will get back to you shortly. A copy of your message details:</p>
@endif

<div style="margin: 20px 0; padding: 15px; background-color: #f8f9fa; border-radius: 8px; border-left: 5px solid #FF7A00;">
    <strong>Name:</strong> {{ $lead['name'] }}<br>
    <strong>Email:</strong> {{ $lead['email'] }}<br>
    <strong>Phone:</strong> {{ $lead['phone'] }}<br>
    <strong>Message:</strong> {{ $lead['message'] }}
</div>

@if(!$isAdmin)
    <p>We usually reply to support queries within 24 business hours.</p>
@endif

<p>Best regards,<br>Support Team, GOS MOMO</p>
@endsection
