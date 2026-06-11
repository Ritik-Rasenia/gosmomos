@extends('layouts.app')

@section('title', 'Contact Us — GOS MOMO')

@section('styles')
<style>
.contact-hero {
    background: linear-gradient(135deg, #0a3620 0%, #0F5132 100%);
    padding: 80px 0 40px;
    color: white;
}
.contact-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.05);
    border: none;
}
</style>
@endsection

@section('content')
<div class="contact-hero text-center">
    <div class="container">
        <h1 class="fw-bold">Contact Us</h1>
        <p class="text-white-75 mb-0">Have questions, feedback, or suggestions? Reach out to us!</p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-5">
        <div class="col-lg-5" data-aos="fade-right">
            <h3 class="fw-bold text-primary-color mb-4">Get In Touch</h3>
            <p class="text-muted">Feel free to contact us via email, phone, or simply by filling out the form on the right. We value your feedback and will get back to you as soon as possible.</p>
            
            <div class="mt-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div style="width:48px; height:48px; border-radius:12px; background:rgba(15,81,50,0.1); color:#0F5132; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <i class="bi bi-geo-alt-fill fs-5"></i>
                    </div>
                    <div>
                        <div class="fw-bold">Head Office</div>
                        <div class="text-muted small">Noida, Uttar Pradesh, India</div>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div style="width:48px; height:48px; border-radius:12px; background:rgba(15,81,50,0.1); color:#0F5132; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <i class="bi bi-telephone-fill fs-5"></i>
                    </div>
                    <div>
                        <div class="fw-bold">Phone Number</div>
                        <div class="text-muted small">+91 88888 77777</div>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div style="width:48px; height:48px; border-radius:12px; background:rgba(15,81,50,0.1); color:#0F5132; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <i class="bi bi-envelope-fill fs-5"></i>
                    </div>
                    <div>
                        <div class="fw-bold">Email Address</div>
                        <div class="text-muted small">info@gosmomo.com</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7" data-aos="fade-left">
            <div class="contact-card p-4 p-md-5">
                <h4 class="fw-bold mb-4"><i class="bi bi-chat-dots me-2 text-success"></i>Send a Message</h4>

                @if(session('success'))
                    <div class="alert alert-success rounded-3 mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('contact.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Your Name *</label>
                            <input type="text" name="name" class="form-control rounded-3" placeholder="Aarav Sharma" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Email Address *</label>
                            <input type="email" name="email" class="form-control rounded-3" placeholder="aarav@gmail.com" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Phone Number *</label>
                            <input type="tel" name="phone" class="form-control rounded-3" placeholder="9876543210" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Message *</label>
                            <textarea name="message" class="form-control rounded-3" rows="4" placeholder="Your message here..." required></textarea>
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-premium w-100 py-3">Send Message</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
