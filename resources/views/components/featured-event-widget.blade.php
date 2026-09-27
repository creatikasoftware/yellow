@props(['event', 'content'])

<section class="ya-event-registration">
    <div class="container">

        <div class="ya-event-heading text-center">
            <div class="ya-event-eyebrow"><span></span> {{ $content['registration_eyebrow'] }} <span></span></div>
            <h2>{{ $content['registration_title_line1'] }} <em>{{ $content['registration_title_highlight'] }}</em></h2>
            <p>{{ $content['registration_subtitle'] }}</p>
        </div>

        @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <div class="row g-4 g-xl-5 align-items-stretch">

            <div class="col-lg-6">
                <div class="ya-event-card"@if($event->featured_image) style="background-image:linear-gradient(90deg, rgba(2,8,18,.96) 0%, rgba(5,17,32,.90) 55%, rgba(5,13,25,.55) 100%), radial-gradient(circle at 70% 30%, rgba(214,166,62,.25), transparent 30%), url('{{ \Illuminate\Support\Facades\Storage::url($event->featured_image) }}');background-size:cover;background-position:center"@endif>
                    <div class="ya-event-overlay"></div>
                    <div class="ya-event-content">
                        @if($event->registration_open)
                            <div class="ya-registration-badge">REGISTRATIONS OPEN</div>
                        @endif

                        <h3><strong>{{ $event->title }}</strong></h3>

                        <div class="ya-event-details">
                            <div class="ya-event-detail">
                                <div class="ya-event-icon"><i class="bi bi-calendar3"></i></div>
                                <div><strong>{{ $event->starts_at->format('l, d F Y') }}</strong></div>
                            </div>

                            @if($event->start_time)
                                <div class="ya-event-detail">
                                    <div class="ya-event-icon"><i class="bi bi-clock"></i></div>
                                    <div><strong>{{ $event->start_time }} &ndash; {{ $event->end_time }}</strong></div>
                                </div>
                            @endif

                            <div class="ya-event-detail">
                                <div class="ya-event-icon"><i class="bi bi-geo-alt"></i></div>
                                <div><strong>{{ $event->location }}</strong></div>
                            </div>

                            @if($event->expected_attendees)
                                <div class="ya-event-detail">
                                    <div class="ya-event-icon"><i class="bi bi-people"></i></div>
                                    <div><strong>{{ $event->expected_attendees }}</strong></div>
                                </div>
                            @endif
                        </div>

                        <div class="ya-event-actions">
                            <a href="#" class="ya-btn ya-btn-gold"><i class="bi bi-download"></i> Download Brochure</a>
                            <a href="{{ route('events.show', $event->slug) }}" class="ya-btn ya-btn-outline"><i class="bi bi-arrow-right"></i> Event Details</a>
                        </div>

                        <div class="ya-countdown" data-countdown="{{ $event->starts_at_with_time->toIso8601String() }}">
                            <div class="ya-countdown-title"><i class="bi bi-hourglass-split"></i> Event Starts In</div>
                            <div class="ya-countdown-items">
                                <div class="ya-countdown-item"><strong data-countdown-days>00</strong><span>DAYS</span></div>
                                <div class="ya-countdown-item"><strong data-countdown-hours>00</strong><span>HOURS</span></div>
                                <div class="ya-countdown-item"><strong data-countdown-mins>00</strong><span>MINS</span></div>
                                <div class="ya-countdown-item"><strong data-countdown-secs>00</strong><span>SECS</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="ya-registration-card">
                    <div class="ya-form-heading">
                        <div class="ya-form-line"></div>
                        <h3>Reserve Your Seat</h3>
                        <p>Fill in your details. Our team will confirm your registration within 24 hours.</p>
                    </div>

                    <form method="POST" action="{{ route('registration.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="event_slug" value="{{ $event->slug }}">
                        <input type="hidden" name="cv_required" value="1">

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="ya-form-label">Profile Photo <small>(Optional)</small></label>
                                <input type="file" name="photo" accept="image/*" class="form-control ya-form-control @error('photo') is-invalid @enderror">
                                @error('photo')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12">
                                <label class="ya-form-label">Upload CV <span>*</span></label>
                                <input type="file" name="cv" accept=".pdf,.doc,.docx" required class="form-control ya-form-control @error('cv') is-invalid @enderror">
                                @error('cv')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="ya-form-label">First Name <span>*</span></label>
                                <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control ya-form-control @error('first_name') is-invalid @enderror" placeholder="Rahul">
                                @error('first_name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="ya-form-label">Last Name <span>*</span></label>
                                <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control ya-form-control @error('last_name') is-invalid @enderror" placeholder="Sharma">
                                @error('last_name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12">
                                <label class="ya-form-label">Email Address <span>*</span></label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control ya-form-control @error('email') is-invalid @enderror" placeholder="rahul@company.com">
                                @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="ya-form-label">Phone Number <span>*</span></label>
                                <div class="ya-phone-input">
                                    <span class="ya-country-code">&#127470;&#127475;</span>
                                    <input type="text" name="phone" value="{{ old('phone') }}" class="form-control ya-form-control @error('phone') is-invalid @enderror" placeholder="+91 98765 43210">
                                </div>
                                @error('phone')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="ya-form-label">Company</label>
                                <input type="text" name="organization" value="{{ old('organization') }}" class="form-control ya-form-control" placeholder="Acme Corp">
                            </div>

                            <div class="col-md-6">
                                <label class="ya-form-label">Industry</label>
                                <select name="industry" class="form-select ya-form-control">
                                    <option selected disabled value="">Select Industry</option>
                                    <option>Technology</option>
                                    <option>Finance</option>
                                    <option>Healthcare</option>
                                    <option>Education</option>
                                    <option>Manufacturing</option>
                                    <option>Retail</option>
                                    <option>Other</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="ya-form-label">Registration Type</label>
                                <select name="registration_type" class="form-select ya-form-control">
                                    <option selected disabled value="">Select Type</option>
                                    <option>Delegate</option>
                                    <option>Speaker</option>
                                    <option>Sponsor</option>
                                    <option>Partner</option>
                                    <option>Nominee</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="ya-form-label">Message <small>(Optional)</small></label>
                                <textarea name="message" class="form-control ya-form-control ya-textarea" rows="4" placeholder="Any specific requirements?">{{ old('message') }}</textarea>
                            </div>

                            <div class="col-12">
                                <div class="ya-terms">
                                    <input type="checkbox" id="yaTerms" name="agreed_terms" value="1">
                                    <label for="yaTerms">I agree to the <a href="#">Terms &amp; Conditions</a> and <a href="#">Privacy Policy</a> <span>*</span></label>
                                </div>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="ya-submit-btn">Confirm Registration <i class="bi bi-arrow-right"></i></button>
                            </div>
                        </div>
                    </form>

                    <div class="ya-secure"><i class="bi bi-lock-fill"></i> Your information is secure and confidential.</div>
                </div>
            </div>
        </div>

        <div class="ya-event-benefits">
            <div class="ya-benefit">
                <div class="ya-benefit-icon"><i class="bi bi-people"></i></div>
                <div><strong>Network</strong><span>Connect with industry leaders</span></div>
            </div>
            <div class="ya-benefit">
                <div class="ya-benefit-icon"><i class="bi bi-lightbulb"></i></div>
                <div><strong>Learn</strong><span>Gain valuable insights</span></div>
            </div>
            <div class="ya-benefit">
                <div class="ya-benefit-icon"><i class="bi bi-graph-up-arrow"></i></div>
                <div><strong>Grow</strong><span>Explore new opportunities</span></div>
            </div>
            <div class="ya-benefit">
                <div class="ya-benefit-icon"><i class="bi bi-award"></i></div>
                <div><strong>Be Recognized</strong><span>Celebrate achievements</span></div>
            </div>
        </div>
    </div>
</section>
