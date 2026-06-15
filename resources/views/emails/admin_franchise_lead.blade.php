@extends('emails.layout')

@section('title', 'GOS MOMO Franchise Application Notification')

@section('content')
@if($isAdmin)
    <h2>New Franchise Application Received!</h2>
    <p>Hello Admin,</p>
    <p>A new franchise inquiry has been submitted. Here are the details:</p>
@else
    <h2>Franchise Application Received — GOS MOMO</h2>
    <p>Hello {{ $lead->name }},</p>
    <p>Thank you for your interest in partnering with GOS MOMO! We have successfully received your franchise application. Here is a copy of your submission:</p>
@endif

<div style="margin: 20px 0; padding: 15px; background-color: #f8f9fa; border-radius: 8px; border-left: 5px solid #FF7A00;">
    <strong>Name:</strong> {{ $lead->name }}<br>
    <strong>Email:</strong> {{ $lead->email }}<br>
    <strong>Phone:</strong> {{ $lead->phone }}<br>
    <strong>City:</strong> {{ $lead->city }}<br>
    <strong>State:</strong> {{ $lead->state }}<br>
    <strong>Investment Budget:</strong> {{ $lead->investment_budget }}<br>
    <strong>Franchise Type:</strong> {{ ucfirst($lead->franchise_type) }}<br>
    <strong>Experience:</strong> {{ $lead->experience ?? 'None' }}<br>
    <strong>Message:</strong> {{ $lead->message ?? 'No message provided' }}
</div>

@if($isAdmin)
    <div style="text-align: center; margin-top: 30px;">
        <a href="{{ route('admin.franchise-leads.show', $lead->id) }}" class="btn-action">View Application details</a>
    </div>
@else
    <p>Our expansion manager will review your application and get in touch with you shortly (usually within 2-3 business days).</p>
@endif

<p>Best regards,<br>Expansion Team, GOS MOMO</p>
@endsection
