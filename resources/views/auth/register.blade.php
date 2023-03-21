<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register | GUB Alumni Portal</title>

    <link rel="stylesheet" href="{{ asset('css/adminlte/adminlte.min.css') }}">
</head>
<body>
{{--<x-slot name="logo">--}}
{{--        <x-application-logo class="w-20 h-20 fill-current text-gray-500"/>--}}
{{--</x-slot>--}}

<!-- Validation Errors -->
{{--<x-auth-validation-errors class="mb-4" :errors="$errors"/>--}}


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3 class="mt-2 text-center">Register | Gub Alumni Portal</h3>

            @if(session()->get('success'))
            <p class="text-center alert alert-success">{{ session()->get('success') }} </p>
            @endif

            <div class="form-area">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->

                    <div class="row">
                        <div class="form-group col-md-6 mt-1">
                            <x-label for="name" :value="__('Name')"/>

                            <input id="name" class="form-control" type="text" name="name"
                                   :value="old('name')" required
                                   autofocus placeholder="Full Name"/>
                        </div>

                        <!-- Email Address -->
                        <div class="form-group col-md-6 mt-1">
                            <x-label for="email" :value="__('Email')"/>

                            <input id="email" class="form-control" type="email" name="email"
                                   :value="old('email')"
                                   required placeholder="yourname@gmail.com"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6 mt-1">
                            <x-label for="password" :value="__('Password')"/>

                            <input id="password" class="form-control"
                                   type="password"
                                   name="password"
                                   required autocomplete="new-password"
                                   placeholder="Your Password"/>
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group col-md-6 mt-1">
                            <x-label for="password_confirmation" :value="__('Confirm Password')"/>

                            <input id="password_confirmation" class="form-control"
                                   type="password"
                                   name="password_confirmation" required
                                   placeholder="Confirm Your Password"/>
                        </div>
                    </div>


                    <!-- Password -->

                    <div class="row">
                        <div class="form-group col-md-6 mt-1">
                            <label for="batch_number">Batch No.</label>

                            <select style="width: 100%;" class="form-control" name="batch_number" id="batch_number">
                                <option>--Select--</option>
                                @foreach(generateBatchNumbers() as $key => $batchNumber)
                                    <option value="{{ $key }}">{{ $batchNumber }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6 mt-1">
                            <label for="passing_year">Passing Year.</label>

                            <select style="width: 100%;" class="form-control" name="passing_year" id="passing_year">
                                <option>--Select--</option>
                                @foreach(generatePassingYears() as $key => $passingYear)
                                    <option value="{{ $key }}">{{ $passingYear }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="row">
                        <div class="form-group col-md-6 mt-1">
                            <label for="department_id">Department</label>

                            <select style="width: 100%;" class="form-control" name="department_id" id="department_id">
                                <option>--Select--</option>
                                @foreach(getDepartments() as $key => $department)
                                    <option value="{{ $key }}">{{ $department }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6 mt-1">
                            <label for="student_id_number">Student ID</label>

                            <input style="width: 100%;" class="form-control" type="text"
                                   name="student_id_number" id="student_id_number"
                                   placeholder="Eg. 1791015123">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6 mt-1">
                            <label for="phone">Phone</label>

                            <input style="width: 100%;" class="form-control" type="text"
                                   name="phone" id="phone"
                                   placeholder="Eg. 01711111111">
                        </div>

                        <div class="form-group col-md-6 mt-1">
                            <label for="address">Address</label>

                            <input style="width: 100%;" class="form-control" type="text"
                                   name="address" id="address"
                                   placeholder="Eg. Shewrapara, Mirpur, Dhaka">
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            {{--                            <div class="flex items-center justify-end mt-1">--}}


                            <div class="btn" style="width: 100%;">
                                <button class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>

                            <a style="text-align: center; display: block;" class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                                {{ __('Already registered?') }}
                            </a>
                            {{--                            </div>--}}
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>

{{--<x-guest-layout>--}}
{{--    <x-auth-card>--}}

{{--    </x-auth-card>--}}
{{--</x-guest-layout>--}}
