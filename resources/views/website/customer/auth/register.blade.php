@extends('website.layouts.app')
@section('title', 'Register')
@section('page_id', 'register_page')
@section('website_content')
    <main class="main__content_wrapper">

        <!-- Start breadcrumb section -->
        <section class="breadcrumb__section breadcrumb__bg">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <h1 class="breadcrumb__content--title text-white mb-25">Account Page</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items"><a class="text-white"
                                        href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb__content--menu__items"><span class="text-white">Account Page</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End breadcrumb section -->

        <!-- Start login section  -->
        <div class="login__section section--padding">
            <div class="container">
                <div class="login__section--inner">
                    <div class="row row-cols-md-2 row-cols-1">

                        <div class="col" style="margin: 0 auto">
                            <div class="account__login--inner">
                                    <form action="{{ route('signup.store') }}" method="POST">
                                        @csrf

                                    <input class="account__login--input @error('name') is-invalid @enderror"
                                        placeholder="Username" type="text" name="name" value="{{ old('name') }}">
                                    @error('name')
                                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                                    @enderror

                                    <input class="account__login--input @error('email') is-invalid @enderror"
                                        placeholder="Email Address" type="text" name="email"
                                        value="{{ old('email') }}">
                                    @error('email')
                                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                                    @enderror

                                    <input class="account__login--input @error('password') is-invalid @enderror"
                                        placeholder="Password" type="password" name="password">
                                    @error('password')
                                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                                    @enderror

                                    <input
                                        class="account__login--input @error('password_confirmation') is-invalid @enderror"
                                        placeholder="Confirm Password" type="password" name="password_confirmation">
                                    @error('password_confirmation')
                                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                                    @enderror

                                    <button class="account__login--btn primary__btn mb-10" type="submit">
                                        Submit & Register
                                    </button>

                                </form>
                                    <div class="account__login--remember position__relative">
                                        <p class="account__login--signup__text">
                                            If you have an Account?
                                            <a href="{{ route('customer.signin') }}" style="text-decoration: underline">Sign
                                                In</a>
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
            </div>
        </div>


    </main>
@endsection
