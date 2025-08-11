@extends('layouts.app')
@push('styles')
    <?php

    if(isset($_GET['gclid'])){
        $gclid=$_GET['gclid'];

    }else{
        $gclid='';

    }
    ?>
    <?php

    if(isset($_GET['MSCLKID'])){
        $MSCLKID=$_GET['MSCLKID'];

    }else{
        $MSCLKID='';

    }

    ?>
@endpush


@section('contents')
    <section>
        <div class="container">
            <div class="register_form">
                <h2>Forgot Account</h2>

                <div class="register_form">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="post" action="{{route('forget.password')}}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label class="d-none" for="email">Email</label>
                            <input id="email" class="form-control" type="email" name="email" placeholder="Email" value="{{ old('email') }}" required/>
                        </div>

                        <div class="description">
                            Forgot your password? No problem! <br>
                            Just let us know your email address and we will email you a new password.  </div>

                        <div class="form-button">
                            <input type="submit" class="btn btn-primary" value="Send Password Now"/>
                        </div>

                        <div class="login-account">
                            <a href="{{route('user.register')}}">Register Now</a>
                        </div>
                    </form>



                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')

@endpush
