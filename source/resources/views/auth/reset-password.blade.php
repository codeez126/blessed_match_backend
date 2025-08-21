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
                <h2>Reset Password</h2>

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

                    <form method="POST" action="{{ route('reset.password') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="email" value="{{ $email }}">

                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input id="password" class="form-control" type="password" name="password" required/>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required/>
                        </div>

                        <div class="form-button">
                            <input type="submit" class="btn btn-primary" value="Reset Password"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')

@endpush
