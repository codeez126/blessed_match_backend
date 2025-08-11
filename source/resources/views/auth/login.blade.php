@extends('layouts.app')
@push('styles')
    <style>
        .theme-bg{
            background: linear-gradient(to right, #EAFBFC 0%, #F9EEF2 50%, #F9EEF2 100%);;
        }
        .form-bg{
            background: white;
            backdrop-filter: blur(35px);
            box-shadow: 0 0 80px rgba(0, 0, 0, 0.25) !important;
            border-radius: 20px !important;
        }
        #navbar{
            display: none;
        }
        .password-container {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            user-select: none;
        }

        .my-form-control {
            padding-right: 30px; /* Make space for the eye icon */
        }
        .footer{
            display: none;
        }
    </style>
    <style>
        .password-container {
            position: relative;
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            user-select: none;
        }
        /* Reduce width of the form container */
        .log-reg-inner {
            max-width: 500px; /* Adjust this value (400px-600px recommended) */
            margin: 0 auto; /* Keeps it centered */
            padding: 2rem;
        }


        .sep-line {
            border: none;
            border-top: 1px solid #ccc;
        }

        .sep-text {
            color: #333;
            font-weight: 500;
            white-space: nowrap;
            font-size: 14px;
        }

        .btn-social {
            display: inline-flex;
            border-radius: 50%;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.2s ease-in-out;
            background-color: white;
            color: white;
        }



        .btn-social:hover {
            opacity: 0.9;
        }
        .form-bottom-text {
            position: absolute;
            bottom: 15px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 14px;
            color: #333;
        }
        .log-reg .log-reg-inner{
            height: auto;
        }


        /* For even narrower forms on mobile */
        @media (max-width: 576px) {
            .log-reg-inner {
                max-width: 100%;
                padding: 1.5rem;
            }
        }
    </style>
@endpush


@section('contents')
    <section class="log-reg theme-bg">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="log-reg-inner form-bg p-4 p-md-5 rounded-3 shadow-sm mx-auto">
                        <div class="section-header text-center mb-4">
                            <div class="logo">
                                <a href="{{url('/')}}"><img src="{{$headerInfo->logo1}}" alt="logo" style="    width: 140px;"></a>
                            </div>
                        </div>
                        <form action="#">
                            <div class="row g-3">
                                <!-- Email -->
                                <div class="col-md-12" style="margin-top: 5px;">
                                    <div class="form-group">
                                        <label for="email">Email / Phone <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="email">

                                    </div>
                                </div>
                                <!-- Password -->
                                <div class="col-md-12" style="margin-top: 5px;">
                                    <div class=" password-container">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" id="password" >
                                        {{--                                        <span class="toggle-password" data-target="password">👁</span>--}}
                                    </div>
                                </div>
                            </div>
                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-theme w-100 mt-4 py-2">
                                Login
                            </button>
                        </form>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="social-separator d-flex align-items-center text-center">
                                    <hr class="sep-line flex-grow-1"><span class="sep-text px-2">OR</span><hr class="sep-line flex-grow-1">
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-center gap-3 mt-3 flex-wrap">
                                <a href="#" class="btn btn-social btn-google p-2">
                                    <img src="https://cdn-icons-png.flaticon.com/24/281/281764.png" alt="Google" style="width: 24px; height: 24px;">
                                </a>
                                <a href="#" class="btn btn-social btn-apple p-2">
                                    <img src="https://cdn-icons-png.flaticon.com/512/179/179309.png" alt="Apple" style="width: 24px; height: 24px; filter: grayscale(100%) brightness(0);">
                                </a>
                            </div>

                        </div>

                        <div class="form-bottom-text">
                            Don't have an account? <a href="#">Sign in</a>
                        </div>


                    </div>
                </div>
            </div>
        </div>




    </section>@endsection
@push('scripts')
    <script>
        // phone no setting
        let lastAlertTime = 0;

        document.getElementById('phone').addEventListener('input', function(e) {
            const input = e.target;
            let value = input.value;
            const now = Date.now();

            // Filter invalid characters
            if (/[^0-9+]/.test(value)) {
                value = value.replace(/[^0-9+]/g, '');
                input.value = value;
            }

            // If user starts typing without +, add it
            if (value.length > 0 && !value.startsWith('+')) {
                value = '+' + value.replace(/\+/g, '');
                input.value = value;

                // Show alert but rate-limited
                if (now - lastAlertTime > 2000) { // 2 seconds between alerts
                    alert('Phone number must start with +92');
                    lastAlertTime = now;
                }
                return;
            }

            // If starts with + but not +92, and has more than 2 digits
            if (value.startsWith('+') && !value.startsWith('+92') && value.length > 2) {
                if (now - lastAlertTime > 2000) {
                    alert('Pakistan numbers must start with +92');
                    lastAlertTime = now;
                }
                input.value = '+92' + value.substring(3).replace(/[^0-9]/g, '');
            }

            // Limit length
            if (value.length > 13) {
                input.value = value.substring(0, 13);
            }
        });

        // password and confirm password
        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(icon => {
            icon.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const passwordInput = document.getElementById(targetId);
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Optional: Change eye icon when toggled
                this.textContent = type === 'password' ? '👁' : '🔒';
            });
        });

        // Password match validation
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirm-password');
        const errorMessage = document.querySelector('.error-message');

        function validatePasswordMatch() {
            if (passwordInput.value !== confirmPasswordInput.value) {
                errorMessage.textContent = 'Passwords do not match!';
                errorMessage.style.display = 'block';
                confirmPasswordInput.style.borderColor = 'red';
                return false;
            } else {
                errorMessage.style.display = 'none';
                confirmPasswordInput.style.borderColor = '';
                return true;
            }
        }

        // Validate on input change
        confirmPasswordInput.addEventListener('input', validatePasswordMatch);
        passwordInput.addEventListener('input', validatePasswordMatch);

        // Validate before form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            if (!validatePasswordMatch()) {
                e.preventDefault(); // Prevent form submission
                // Scroll to error message
                errorMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
    </script>
@endpush
