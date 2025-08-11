<div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
    <div id="comments" class="comments-area style1 pl-55 res-1199-pl-0 res-1199-pt-30">
        <div class="comment-respond">
            <h3 class="comment-reply-title">Contact us</h3>

            <form action="{{ route('contact-us') }}" method="post" id="commentform" class="comment-form">
                @csrf

                {{-- Display general errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <p class="comment-form-author">
                    <input id="author" placeholder="Name*" name="name" type="text" value="{{ old('name') }}" size="30" aria-required="true">
                    {{-- Error message for name --}}
                    @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                </p>

                <p class="comment-form-email">
                    <input id="email" placeholder="Email *" name="email" type="text" value="{{ old('email') }}" size="30" aria-required="true">
                    {{-- Error message for email --}}
                    @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </p>

                <p class="comment-form-author">
                    <input id="phone" placeholder="Phone *" name="phone" type="text" value="{{ old('phone') }}" size="30" aria-required="true">
                    {{-- Error message for phone --}}
                    @if ($errors->has('phone'))
                        <span class="text-danger">{{ $errors->first('phone') }}</span>
                    @endif
                </p>

                <p class="comment-form-email">
                    <input id="subject" placeholder="Subject" name="subject" type="text" value="{{ old('subject') }}" size="30">
                </p>

                <p class="comment-form-comment">
                    <textarea id="comment" placeholder="Your message here*" name="message" cols="45" rows="4" aria-required="true">{{ old('message') }}</textarea>
                    {{-- Error message for message --}}
                    @if ($errors->has('message'))
                        <span class="text-danger">{{ $errors->first('message') }}</span>
                    @endif
                </p>

                <p class="form-submit cookies mb-0 headingfont-color d-flex align-items-center">
                    <button class="submit prt-btn prt-btn-size-md prt-btn-shape-round prt-btn-style-fill prt-btn-color-skincolor mr-25 res-575-mb-10" type="submit">
                        <span>Submit</span>
                    </button>
                </p>
            </form>
        </div>
    </div>
</div>
