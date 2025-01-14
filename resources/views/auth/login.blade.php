<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin Login</title>

    {{--    Favicon --}}
    {{-- <link rel="icon" href="{{ asset('images/logo.ico') }}"> --}}

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome-free/css/all.min.css') }}">
    {{-- Theme css --}}
    {{-- <link rel="stylesheet" href="{{ mix('css/theme.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

</head>
<style>
    .pos-background {
        background-image: url('https://images.unsplash.com/photo-1612153018787-4899c6e056d7?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTF8fGdyZWVuJTIwYmFja2dyb3VuZHxlbnwwfHwwfHx8MA%3D%3D');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        backdrop-filter: blur(15px);
        height: 100vh;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .box-alignment {
        height: 100vh;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        justify-content: center;
        /* align-items: center; */
        display: flex;
        flex-direction: column;
    }

    .login-container {
        background: rgba(255, 255, 255, 0.4);
        /* Semi-transparent white */
        border: 2px solid rgba(255, 255, 255, 0.41);
        /* Border for glassy effect */
        border-radius: 15px;
        backdrop-filter: blur(15px);
        /* Glassmorphism Effect */
        -webkit-backdrop-filter: blur(10px);
        /* Safari Support */
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        /* Subtle shadow-sm */
        padding: 3rem;
        width: 25vw;
    }

    .heading-desc {
        color: #0a901a;
    }

    label {
        font-size: 1rem !important;
        font-weight: normal !important;
    }

    .btn {
        position: relative;
        overflow: hidden;
        transition: transform 0.5s ease-in-out, box-shadow-sm 0.5s ease-in-out;
    }

    .btn:hover {
        transform: scale(1.02);
        box-shadow-sm: 0 8px 15px rgba(0, 0, 0, 0.7);
    }

    .btn:active {
        transform: scale(1);
    }

    label {
        margin-bottom: 0 !important;
    }

    .error,
    .passwordError,
    .signUpError {
        color: red;
        font-size: 0.8rem;
    }

    sup {
        color: red;
        /* Change color to red */

    }

    .btn .ripple {
        position: absolute;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.5);
        border-radius: 50%;
        pointer-events: none;
        animation: ripple-animation 1s ease-out;
        transform: scale(0);
    }

    #sageBuddyImg {
        position: relative;
        transform: translateX(-100vw);
        /* Start off-screen to the right */
        transition: transform 1.7s ease-out;
        /* Smooth transition */
    }

    /* input {
        border-color: blue !important;
    } */

    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
</style>

<body>

    <main role="main" class="pos-background pr-5" id="app">
        <div class="row">
            <div class="col-lg-6">
                <div class="box-alignment align-items-center">
                    <img id="sageBuddyImg" src="images/saggebuddy-logo.png" width="600px" />
                    <div class="text-center px-5 w-75">
                        <h5 class="text-muted font-weight-normal"><q>
                                {{ config('theme.loginMessage') }}</q>
                        </h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 box-alignment">
                <div class="login-container">
                    <div class="">
                        <div id="signInForm" class="">
                            <div class="text-center mb-5">
                                <h4 class="mb-1">Sign In Account</h4>
                                @if (config('theme.isshowSignUp'))
                                    <small>Don't have an account?
                                        <a href="#" id="showSignUp" class="">Sign Up</a>
                                    </small>
                                @endif
                            </div>
                            <form role="form" method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group mb-4">
                                    <label for="exampleInputEmail1">Email address</label>
                                    <input type="email" class="form-control shadow-sm" id="email" name="email">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password" name="password" class="form-control shadow-sm"
                                        id="signInPassword">
                                </div>
                                <button type="submit" class="btn btn-success btn-block mt-5">Sign In</button>
                            </form>
                            <div id="error"></div>
                            @if ($errors->all())
                                <div class="alert alert-danger mt-2 p-3">{{ $errors->first() }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if (session()->has('message'))
                                <div class="alert alert-success mt-2">{{ session()->get('message') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>

                        <div id="signUpForm" class=" d-none">
                            <div class="text-center mb-5">
                                <h4 class="mb-1">Create a New Account</h4>
                                <small>Already have an account?
                                    <a href="#" id="showSignIn">Sign In</a>
                                </small>
                            </div>
                            <form role="form" method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="mb-2">
                                    <label for="name">First Name</label>
                                    <input name="first_name" type="text" class="form-control shadow-sm"
                                        id="name">
                                </div>
                                <div class="mb-2">
                                    <label for="lastName">Last Name</label>
                                    <input name="last_name" type="text" class="form-control shadow-sm"
                                        id="lastName">
                                </div>
                                <div class="mb-2">
                                    <label for="phoneNumber">Phone</label>
                                    <input name="mobile" type="number" class="form-control shadow-sm"
                                        id="phoneNumber">
                                </div>
                                <div class="mb-2">
                                    <label for="signUpEmail">Email address</label>
                                    <input name="email" type="email" class="form-control shadow-sm"
                                        id="signUpEmail">
                                </div>
                                <div class="form-group mb-2">
                                    <label for="signUpPassword">Password</label>
                                    <input name="password" type="password" class="form-control shadow-sm"
                                        id="signUpPassword">
                                </div>
                                <div class="form-group mb-1">
                                    <label for="confirmPassword">Confirm Password</label>
                                    <input type="password" class="form-control shadow-sm" id="confirmPassword">
                                </div>
                                <div id="passwordError"></div>

                                <button type="submit" class="btn btn-success btn-block mt-5">Sign Up</button>
                            </form>
                            <div id="signUpError"></div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </main>
    <script>
        //error handeling for form submission if empty 
        document.addEventListener("DOMContentLoaded", function() {
            const name = document.getElementById('name');
            const lastName = document.getElementById('lastName');
            const email = document.getElementById('email');
            const signInPassword = document.getElementById('signInPassword');
            const password = document.getElementById('password');
            const phoneNumber = document.getElementById('phoneNumber');
            const signUpEmail = document.getElementById('signUpEmail');
            const signUpPassword = document.getElementById('signUpPassword');
            const confirmPassword = document.getElementById('confirmPassword');
            const signInForm = document.getElementById('signInForm');
            const signUpForm = document.getElementById('signUpForm');
            const errorElement = document.getElementById('error');
            const signUpErrorElement = document.getElementById("signUpError");
            const passwordErrorElement = document.getElementById("passwordError");

            // Add input event listeners for each input field
            const allInputs = [
                name,
                lastName,
                email,
                signInPassword,
                password,
                phoneNumber,
                signUpEmail,
                signUpPassword,

            ];
            //chagne the input color to red if seelcted empty and not filled 
            allInputs.forEach(input => {
                if (input) { // Check if the input element exists to avoid errors
                    input.addEventListener('focus', () => {
                        if (input.value.trim() === '') {
                            input.style.borderColor =
                                'red'; // Highlight in red when clicked and empty
                        }
                    });

                    // Handle input event (when user types)
                    input.addEventListener('input', () => {
                        if (input.value.trim() === '') {
                            input.style.borderColor = 'red';
                        } else {
                            input.style.borderColor = 'blue';
                        }
                    });
                }
            });

            // Validate sign-in form
            signInForm.addEventListener('submit', (e) => {
                let messages = "One or More input fields are Empty";
                if (email.value === '' || signInPassword.value === '') {
                    e.preventDefault();
                    if (errorElement) {
                        errorElement.innerText = messages;
                        errorElement.classList.add("error", 'd-block');
                        errorElement.classList.remove('d-none');
                    }
                } else {
                    if (errorElement) {
                        errorElement.classList.remove('d-block'); // Hide error message
                        errorElement.classList.add('d-none');
                    }
                }
            });

            // Validate sign-up form
            signUpForm.addEventListener('submit', (e) => {
                let messages = "One or more input fields are empty";
                let passwordCheck = "Password does not match";
                let isError = false; // Flag to check if there's any error
                let isPasswordError = false; // Flag to check if there's any error
                //check password == confiremdPassword

                if (
                    name.value === '' ||
                    lastName.value === '' ||
                    signUpPassword.value === '' ||
                    phoneNumber.value === '' ||
                    signUpEmail.value === ''
                ) {
                    e.preventDefault();
                    isError = true;
                    if (signUpErrorElement) {
                        signUpErrorElement.innerText = messages;
                        signUpErrorElement.classList.add("signUpError", 'd-block');
                        signUpErrorElement.classList.remove('d-none');
                    }
                }

                // Check if password and confirm password match
                if (signUpPassword.value !== confirmPassword.value) {
                    e.preventDefault();
                    isPasswordError = true;
                    if (passwordErrorElement) {
                        passwordErrorElement.innerText = passwordCheck;
                        passwordErrorElement.classList.add("passwordError", 'd-block');
                        passwordErrorElement.classList.remove('d-none');
                    }
                }

                // Clear error messages if there are no issues
                if (!isError) {
                    // Handle clearing signUpErrorElement styles if there's no error in input fields
                    if (signUpErrorElement) {
                        signUpErrorElement.innerText = ''; // Clear text
                        signUpErrorElement.classList.remove('d-block');
                        signUpErrorElement.classList.add('d-none');
                    }
                }

                if (!isPasswordError) {
                    // Handle clearing passwordErrorElement styles if passwords match
                    if (passwordErrorElement) {
                        passwordErrorElement.innerText = ''; // Clear text
                        passwordErrorElement.classList.remove('d-block');
                        passwordErrorElement.classList.add('d-none');
                    }
                }
            });
        });


        //Append * to the Labels 
        const labels = document.querySelectorAll("label");

        // Loop through each label and append the <sup>*</sup>
        labels.forEach(label => {
            const sup = document.createElement("sup");
            sup.textContent = "*"; // Set the content of <sup> to "*"
            label.appendChild(sup); // Append <sup> to the label
        });

        //Animate the Sagebuddy logo
        document.addEventListener("DOMContentLoaded", function() {
            const headerImage = document.getElementById("sageBuddyImg");
            setTimeout(() => {
                headerImage.style.transform = "translate(0)"
            }, 300);
        });

        //submit button motion
        document.addEventListener("DOMContentLoaded", function() {
            const buttons = document.querySelectorAll(".btn");

            buttons.forEach((button) => {
                button.addEventListener("click", function(e) {
                    const rect = this.getBoundingClientRect();
                    const ripple = document.createElement("span");
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;

                    ripple.style.width = ripple.style.height = `${size}px`;
                    ripple.style.left = `${x}px`;
                    ripple.style.top = `${y}px`;
                    ripple.className = "ripple";
                    this.appendChild(ripple);

                    setTimeout(() => ripple.remove(), 600);
                });
            });
        });

        //toggle between sign in and sign up
        document.addEventListener("DOMContentLoaded", function() {
            const signInForm = document.getElementById('signInForm');
            const signUPForm = document.getElementById('signUpForm');
            const showSignIn = document.getElementById('showSignIn');
            const showSignUp = document.getElementById('showSignUp');

            showSignUp.addEventListener('click', (e) => {
                e.preventDefault();
                signUPForm.classList.remove('d-none');
                signInForm.classList.add('d-none');
            });
            showSignIn.addEventListener('click', (e) => {
                e.preventDefault();
                signUPForm.classList.add('d-none');
                signInForm.classList.remove('d-none');
            });
        });
    </script>

    {{-- <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script> --}}
    <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>


</body>

</html>
