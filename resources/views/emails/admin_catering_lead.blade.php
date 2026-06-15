@extends('emails.layout')

@section('title', 'Catering Inquiry — GOS MOMO')

@section('content')
@if($isAdmin)
    <h2>New Catering Inquiry Received!</h2>
    <p>Hello Admin,</p>
    <p>A new catering/event inquiry has been submitted. Details are below:</p>
@else
    <h2>Catering Inquiry Received — GOS MOMO</h2>
    <p>Hello {{ $lead->name }},</p>
    <p>Thank you for inquiring about GOS MOMO catering for your upcoming event! We have received your inquiry. Details of your request:</p>
@endif

<div style="margin: 20px 0; padding: 15px; background-color: #f8f9fa; border-radius: 8px; border-left: 5px solid #FF7A00;">
    <strong>Name:</strong> {{ $lead->name }}<br>
    <strong>Email:</strong> {{ $lead->email }}<br>
    <strong>Phone:</strong> {{ $lead->phone }}<br>
    <strong>Event Type:</strong> {{ $lead->event_type }}<br>
    <strong>Event Date:</strong> {{ date('d M Y', strtotime($lead->event_date)) }}<br>
    <strong>Guest Count:</strong> {{ $lead->guest_count }} guests<br>
    <strong>City:</strong> {{ $lead->city }}<br>
    <strong>Estimated Budget:</strong> {{ $lead->budget ? '₹' . number_format($lead->budget, 2) : 'Not specified' }}<br>
    <strong>Message:</strong> {{ $lead->message ?? 'No special requests' }}
</div>

@if($isAdmin)
    <div style="text-align: center; margin-top: 30px;">
        <a href="{{ route('admin.event-leads.show', $lead->id) }}" class="btn-action">View Event Lead details</a>
    </div>
@else
    <p>Our catering team will review your requirements and reach out to you within 24 hours to design a customized menu for your guests.</p>
@endif

<p>Best regards,<br>Catering Events Team, GOS MOMO</p>
@endsection
