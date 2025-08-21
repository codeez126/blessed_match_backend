<?php
$headerInfo=\App\Models\HeaderInfo::select('*')->first();
?>
<x-guest-layout>
    <style>
        .login_two_image {
            background-image: url("{{ asset('assets/admin/theme/images/ProAdmin.webp') }}");
        }
        .for-light{
            width: 100px;
        }
        .for-dark{
            width: 100px;
        }
    </style>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="row">
        <div class="col-xl-5 login_two_image"></div>
        <div class="col-xl-7 p-0">
            <div class="login-card login-dark login-bg">
                <div>
                    <div>
                        <a class="logo text-center" href="{{url('admin/dashboard')}}">
                            <img class="img-fluid for-light" src="{{ asset($headerInfo->logo1) }}" alt="looginpage" >
                            <img class="for-dark m-auto" src="{{ asset($headerInfo->logo1) }}" alt="logo">
                        </a>
                    </div>
                    <div class="login-main">
                        <form class="theme-form needs-validation" method="POST" action="{{ route('adminloginpost') }}" novalidate>
                            @csrf
                            <h2 class="text-center">Sign in Now</h2>
                            <p class="text-center">Enter your email &amp; password to login</p>

                            <!-- Email Address -->
                            <div class="form-group">
                                <label class="col-form-label" for="email">Email Address</label>
                                <input id="email" class="form-control" type="email" name="email" :value="old('email')" required placeholder="Test@gmail.com">
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div class="form-group">
                                <label class="col-form-label" for="password">Password</label>
                                <div class="form-input position-relative">
                                    <input id="password" class="form-control" type="password" name="password" required placeholder="*********">
                                    <div class="show-hide"><span class="show"></span></div>
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Remember Me -->
                            <div class="form-group mb-0 checkbox-checked">
                                <div class="form-check checkbox-solid-info">
                                    <input class="form-check-input" id="remember_me" type="checkbox" name="remember">
                                    <label class="form-check-label" for="remember_me">Remember password</label>
                                </div>
                            </div>

                            <div class="text-end mt-3">
                                <button type="submit" class="btn btn-primary btn-block w-100 text-white ms-3">
                                    {{ __('Log in') }}
                                </button>
                            </div>
                        </form>

                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                // Show SweetAlert based on session messages
                                @if (session('status'))
                                Swal.fire({
                                    title: 'Success!',
                                    text: '{{ session('status') }}',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                });
                                @endif

                                @if (session('error'))
                                Swal.fire({
                                    title: 'Error!',
                                    text: '{{ session('error') }}',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                                @endif

                                (function() {
                                    'use strict';
                                    window.addEventListener('load', function() {
                                        var forms = document.getElementsByClassName('needs-validation');
                                        var validation = Array.prototype.filter.call(forms, function(form) {
                                            form.addEventListener('submit', function(event) {
                                                if (form.checkValidity() === false) {
                                                    event.preventDefault();
                                                    event.stopPropagation();
                                                }
                                                form.classList.add('was-validated');
                                            }, false);
                                        });
                                    }, false);
                                })();
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
