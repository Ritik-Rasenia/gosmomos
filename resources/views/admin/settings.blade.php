@extends('layouts.admin')
@section('title', 'System Settings & Tools — GOS MOMO')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">System Settings & Utilities</h4>
        <p class="text-muted mb-0">Configure branding parameters, contact options, SEO defaults, and run maintenance tasks.</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <!-- Tab Navigation -->
        <ul class="nav nav-pills mb-4 gap-2" id="settingsTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active rounded-pill px-4" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab"><i class="bi bi-shop me-2"></i>General & Branding</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill px-4" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab"><i class="bi bi-chat-left-text me-2"></i>Contact & Socials</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill px-4" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo" type="button" role="tab"><i class="bi bi-search me-2"></i>SEO Metadata</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill px-4 bg-orange-subtle text-orange" id="system-tab" data-bs-toggle="tab" data-bs-target="#system" type="button" role="tab"><i class="bi bi-sliders me-2"></i>Advanced System Tools</button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="settingsTabContent">
            
            <!-- GENERAL SETTINGS -->
            <div class="tab-pane fade show active" id="general" role="tabpanel">
                <div class="admin-card p-4">
                    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <h5 class="fw-bold text-orange border-bottom pb-2 mb-3">Brand Identity</h5>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Site/Brand Name</label>
                                <input type="text" name="site_name" class="form-control rounded-3" value="{{ old('site_name', setting('site_name', 'GOS MOMO')) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Tagline</label>
                                <input type="text" name="tagline" class="form-control rounded-3" value="{{ old('tagline', setting('tagline', 'The Taste India Will Queue For')) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Brand Owner / Legal entity</label>
                                <input type="text" name="brand_owner" class="form-control rounded-3" value="{{ old('brand_owner', setting('brand_owner', 'Mahoksh Core')) }}">
                            </div>

                            <h5 class="fw-bold text-orange border-bottom pb-2 mt-4 mb-3">Branding Media Assets</h5>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold small">Logo (Light Theme)</label>
                                <input type="file" name="logo" class="form-control rounded-3">
                                @if(setting('logo'))
                                    <div class="mt-2 p-2 bg-light rounded text-center border">
                                        <img src="{{ asset(setting('logo')) }}" alt="Logo Light" style="max-height: 40px; object-fit: contain;">
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold small">Logo (Dark Theme)</label>
                                <input type="file" name="logo_dark" class="form-control rounded-3">
                                @if(setting('logo_dark'))
                                    <div class="mt-2 p-2 bg-dark rounded text-center border">
                                        <img src="{{ asset(setting('logo_dark')) }}" alt="Logo Dark" style="max-height: 40px; object-fit: contain;">
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold small">Favicon (ICO / PNG)</label>
                                <input type="file" name="favicon" class="form-control rounded-3">
                                @if(setting('favicon'))
                                    <div class="mt-2 p-2 bg-light rounded text-center border">
                                        <img src="{{ asset(setting('favicon')) }}" alt="Favicon" style="max-height: 30px; object-fit: contain;">
                                    </div>
                                @endif
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-orange rounded-pill px-5">Save Brand Config</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- CONTACT & SOCIALS -->
            <div class="tab-pane fade" id="contact" role="tabpanel">
                <div class="admin-card p-4">
                    <form action="{{ route('admin.settings.update') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <h5 class="fw-bold text-orange border-bottom pb-2 mb-3">Contact Information</h5>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Support Email</label>
                                <input type="email" name="contact_email" class="form-control rounded-3" value="{{ old('contact_email', setting('contact_email', 'info@gosmomo.com')) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Support Phone</label>
                                <input type="text" name="contact_phone" class="form-control rounded-3" value="{{ old('contact_phone', setting('contact_phone', '+91 88888 77777')) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">WhatsApp Contact Number (Without country code prefix)</label>
                                <input type="text" name="whatsapp_number" class="form-control rounded-3" placeholder="e.g. 918888877777" value="{{ old('whatsapp_number', setting('whatsapp_number', '918888877777')) }}">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-semibold small">Head Office Address</label>
                                <textarea name="head_office_address" class="form-control rounded-3" rows="3">{{ old('head_office_address', setting('head_office_address', 'Noida, Uttar Pradesh, India')) }}</textarea>
                            </div>

                            <h5 class="fw-bold text-orange border-bottom pb-2 mt-4 mb-3">Social Profiles</h5>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold small">Facebook Page Link</label>
                                <input type="url" name="facebook_url" class="form-control rounded-3" value="{{ old('facebook_url', setting('facebook_url', 'https://facebook.com/gosmomo')) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold small">Instagram Handle Link</label>
                                <input type="url" name="instagram_url" class="form-control rounded-3" value="{{ old('instagram_url', setting('instagram_url', 'https://instagram.com/gosmomo')) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold small">Twitter/X Profile Link</label>
                                <input type="url" name="twitter_url" class="form-control rounded-3" value="{{ old('twitter_url', setting('twitter_url', 'https://twitter.com/gosmomo')) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">YouTube Channel Link</label>
                                <input type="url" name="youtube_url" class="form-control rounded-3" value="{{ old('youtube_url', setting('youtube_url')) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">LinkedIn Page Link</label>
                                <input type="url" name="linkedin_url" class="form-control rounded-3" value="{{ old('linkedin_url', setting('linkedin_url')) }}">
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-orange rounded-pill px-5">Save Contact & Socials</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- SEO METADATA -->
            <div class="tab-pane fade" id="seo" role="tabpanel">
                <div class="admin-card p-4">
                    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <h5 class="fw-bold text-orange border-bottom pb-2 mb-3">Global Search Engine Optimization</h5>
                            <div class="col-md-12">
                                <label class="form-label fw-semibold small">Default SEO Meta Title</label>
                                <input type="text" name="seo_meta_title" class="form-control rounded-3" value="{{ old('seo_meta_title', setting('seo_meta_title', 'GOS MOMO — Premium Hygienic Street Momos')) }}" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-semibold small">Default SEO Meta Keywords</label>
                                <input type="text" name="seo_meta_keywords" class="form-control rounded-3" value="{{ old('seo_meta_keywords', setting('seo_meta_keywords', 'gos momo, street momos, hygiene food')) }}">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-semibold small">Default SEO Meta Description</label>
                                <textarea name="seo_meta_description" class="form-control rounded-3" rows="3">{{ old('seo_meta_description', setting('seo_meta_description')) }}</textarea>
                            </div>
                            
                            <div class="col-md-6 mt-3">
                                <label class="form-label fw-semibold small">Open Graph Image (Social Sharing Preview)</label>
                                <input type="file" name="og_image" class="form-control rounded-3">
                                @if(setting('og_image'))
                                    <div class="mt-2 p-2 bg-light rounded text-center border">
                                        <img src="{{ asset(setting('og_image')) }}" alt="OG Sharing Image" style="max-height: 100px; object-fit: contain;">
                                    </div>
                                @endif
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-orange rounded-pill px-5">Save SEO Configurations</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- SYSTEM TOOLS -->
            <div class="tab-pane fade" id="system" role="tabpanel">
                <div class="row g-4">
                    <!-- Cache clear and backup -->
                    <div class="col-md-6">
                        <div class="admin-card p-4 h-100">
                            <h5 class="fw-bold text-orange border-bottom pb-2 mb-3"><i class="bi bi-trash3 me-2"></i>Performance & Cache</h5>
                            <p class="small text-muted mb-4">Clearing config and routes compiled caches updates any changes to settings or routing parameters immediately. Highly recommended after manual env changes.</p>
                            
                            <form action="{{ route('admin.system.cache.clear') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="button" class="btn btn-orange rounded-pill px-4 w-100 py-2 fw-semibold" onclick="confirmCacheClear(this)">
                                    <i class="bi bi-lightning-charge me-1"></i> Flush Application Cache
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="admin-card p-4 h-100">
                            <h5 class="fw-bold text-orange border-bottom pb-2 mb-3"><i class="bi bi-database-down me-2"></i>Database Backups</h5>
                            <p class="small text-muted mb-4">Export a raw, standards-compliant SQL dump containing tables structure, schemas, and all user/order records. Highly portable and can be directly re-imported in phpMyAdmin.</p>
                            
                            <a href="{{ route('admin.system.backup.export') }}" class="btn btn-dark rounded-pill px-4 w-100 py-2 fw-semibold">
                                <i class="bi bi-cloud-arrow-down me-1"></i> Export SQL Database Dump
                            </a>
                        </div>
                    </div>

                    <!-- Maintenance Mode -->
                    <div class="col-md-12">
                        <div class="admin-card p-4 bg-dark text-white">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                <div>
                                    <h5 class="fw-bold text-orange mb-1"><i class="bi bi-shield-slash me-2"></i>Emergency Maintenance Mode</h5>
                                    <p class="small text-light-50 mb-0">Toggle maintenance mode. Frontend users will see a "Service Temporarily Unavailable" layout, while administrators can still bypass if using the secret key.</p>
                                </div>
                                <div>
                                    <form action="{{ route('admin.system.maintenance.toggle') }}" method="POST">
                                        @csrf
                                        @if(app()->isDownForMaintenance())
                                            <button type="button" class="btn btn-success rounded-pill px-4 py-2 fw-semibold" onclick="confirmMaintenance(this, 'DISABLE')">
                                                <i class="bi bi-play-fill me-1"></i> Disable Maintenance Mode
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-danger rounded-pill px-4 py-2 fw-semibold" onclick="confirmMaintenance(this, 'ENABLE')">
                                                <i class="bi bi-pause-fill me-1"></i> Enable Maintenance Mode
                                            </button>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function confirmCacheClear(button) {
    Swal.fire({
        title: 'Clear System Cache?',
        text: "This will regenerate route, view, and config caches. Page load might be slightly slower for the first request.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#FF7A00',
        cancelButtonColor: '#0E101A',
        confirmButtonText: 'Yes, clear cache!'
    }).then((result) => {
        if (result.isConfirmed) {
            button.closest('form').submit();
        }
    });
}

function confirmMaintenance(button, action) {
    Swal.fire({
        title: `${action} Maintenance Mode?`,
        text: action === 'ENABLE' 
            ? "This will lock down public pages with a 503 maintenance page. Only admins with secret bypass can access!"
            : "This will open the site for public customers again.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#FF7A00',
        cancelButtonColor: '#0E101A',
        confirmButtonText: `Yes, ${action.toLowerCase()} it!`
    }).then((result) => {
        if (result.isConfirmed) {
            button.closest('form').submit();
        }
    });
}
</script>
@endsection
