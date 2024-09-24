<?php require_once 'app/views/head.php'; ?>

<body>
<div x-data="userHandler()" class="min-h-screen flex items-center justify-center bg-gray-100 p-4">
    <div class="bg-white shadow-lg rounded-lg p-6 max-w-md w-full">
        <div class="text-center pb-6">
            <a href="#" class="border-b-gray-700 border-b-4 pb-2 text-2xl font-bold text-gray-900">Elikingtrendz.</a>
        </div>
        
        <h2 class="text-3xl font-bold text-center mb-2">Let's get you signed in</h2>
        
        <!-- Google Login Button -->
        <button class="flex items-center justify-center rounded-md border px-4 py-2 mb-6 outline-none ring-gray-400 ring-offset-2 transition focus:ring-2 hover:border-transparent hover:bg-black hover:text-white">
            <img class="mr-2 h-5" src="https://static.cdnlogo.com/logos/g/35/google-icon.svg" alt="Google Icon" /> Log in with Google
        </button>

        <div class="relative flex h-px place-items-center bg-gray-200 mb-6">
            <div class="absolute left-1/2 h-6 w-14 -translate-x-1/2 bg-white text-center text-sm text-gray-500">or</div>
        </div>

        <!-- Email form -->
        <form @submit.prevent="checkEmail" x-show="!showVerification && !showPassword" class="flex flex-col">
            <div class="mb-4 focus-within:border-b-gray-500 relative flex overflow-hidden border-b-2 transition">
                <input type="email" id="email" name="email" x-model="email" required class="w-full flex-1 appearance-none bg-white px-4 py-2 text-base text-gray-700 placeholder-gray-400 focus:outline-none" placeholder="Email" />
            </div>
            <button type="submit" class="w-full rounded-lg bg-gray-900 px-4 py-2 text-center text-base font-semibold text-white shadow-md ring-gray-500 ring-offset-2 transition focus:ring-2">
                <span x-show="!loading">Continue</span>
                <span x-show="loading" class="loader"></span>
            </button>
        </form>

        <!-- Verification code input -->
        <div x-show="showVerification" class="mt-8">
            <h3 class="text-lg font-semibold mb-2">Enter Verification Code</h3>
            <form @submit.prevent="verifyCode" class="flex flex-col">
                <div class="mb-4 focus-within:border-b-gray-500 relative flex overflow-hidden border-b-2 transition">
                    <input type="text" id="verification-code" name="verification-code" x-model="verificationCode" required class="w-full flex-1 appearance-none bg-white px-4 py-2 text-base text-gray-700 placeholder-gray-400 focus:outline-none" placeholder="Verification Code" />
                </div>
                <button type="submit" class="w-full rounded-lg bg-green-600 px-4 py-2 text-center text-base font-semibold text-white shadow-md ring-green-500 ring-offset-2 transition focus:ring-2">
                    <span x-show="!loading">Verify</span>
                    <span x-show="loading" class="loader"></span>
                </button>
            </form>
        </div>

        <!-- Registration/Login form -->
        <div x-show="showPassword" class="mt-8">
            <h3 x-text="existingUser ? 'Login' : 'Register'" class="text-lg font-semibold mb-4"></h3>

            <form @submit.prevent="existingUser ? loginUser() : registerUser()" class="flex flex-col col-span-2">
                <template x-if="!existingUser">
                    <div>
                        <div class="mb-4 focus-within:border-b-gray-500 relative flex overflow-hidden border-b-2 transition">
                            <input type="text" id="first-name" name="first-name" x-model="firstName" required class="w-full flex-1 appearance-none bg-white px-4 py-2 text-base text-gray-700 placeholder-gray-400 focus:outline-none" placeholder="First Name" />
                        </div>
                        
                        <div class="mb-4 focus-within:border-b-gray-500 relative flex overflow-hidden border-b-2 transition">
                            <input type="text" id="last-name" name="last-name" x-model="lastName" required class="w-full flex-1 appearance-none bg-white px-4 py-2 text-base text-gray-700 placeholder-gray-400 focus:outline-none" placeholder="Last Name" />
                        </div>
                        
                        <div class="mb-4 focus-within:border-b-gray-500 relative flex overflow-hidden border-b-2 transition">
                            <input type="text" id="username" name="username" x-model="username" required class="w-full flex-1 appearance-none bg-white px-4 py-2 text-base text-gray-700 placeholder-gray-400 focus:outline-none" placeholder="Username" />
                        </div>
                    </div>
                </template>

                <div class="mb-4 focus-within:border-b-gray-500 relative flex overflow-hidden border-b-2 transition">
                    <input :type="showPasswordInput ? 'text' : 'password'" id="password" name="password" x-model="password" required class="w-full flex-1 appearance-none bg-white px-4 py-2 text-base text-gray-700 placeholder-gray-400 focus:outline-none" placeholder="Password" />
                    <button type="button" @click="togglePasswordVisibility" class="absolute inset-y-0 right-3 flex items-center">
                        <i :class="showPasswordInput ? 'fas fa-eye-slash' : 'fas fa-eye'" class="text-gray-500 cursor-pointer"></i>
                    </button>
                    <div class="mt-2 text-xs text-gray-500" x-text="passwordStrengthMessage"></div>
                </div>

                <template x-if="!existingUser">
                    <div class="mb-4 focus-within:border-b-gray-500 relative flex overflow-hidden border-b-2 transition">
                        <input :type="showPasswordInput ? 'text' : 'password'" id="repeat-password" name="repeat-password" x-model="repeatPassword" required class="w-full flex-1 appearance-none bg-white px-4 py-2 text-base text-gray-700 placeholder-gray-400 focus:outline-none" placeholder="Repeat Password" />
                    </div>
                </template>

                <button type="submit" x-text="existingUser ? 'Login' : 'Register'" class="w-full rounded-lg bg-gray-900 px-4 py-2 text-center text-base font-semibold text-white shadow-md ring-gray-500 ring-offset-2 transition focus:ring-2">
                    <span x-show="!loading">Login</span>
                    <span x-show="loading" class="loader"></span>
                </button>
            </form>
        </div>

        <div x-text="message" :class="messageClass" class="mt-4 text-center"></div>

        <div class="py-12 text-center text-xs">
            <p class="whitespace-nowrap text-gray-600">
                By signing in you accept our
                <a href="#" class="underline-offset-4 font-semibold text-gray-900 underline">Privacy Policy</a> and
                <a href="#" class="underline-offset-4 font-semibold text-gray-900 underline">Terms of service</a>.
            </p>
        </div>
    </div>
</div>

<script>
    function userHandler() {
    return {
        email: '',
        verificationCode: '',
        firstName: '',
        lastName: '',
        username: '',
        password: '',
        repeatPassword: '',
        existingUser: false,
        showPassword: false,
        showVerification: false,
        showPasswordInput: false,
        message: '',
        messageClass: '',
        passwordStrengthMessage: '',
        loading: false,  // Loading state

        async checkEmail() {
            this.loading = true;  // Start loading
            const response = await fetch('Auth', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ action: 'checkEmail', email: this.email })
            });
            const result = await response.json();
            this.loading = false;  // Stop loading

            if (result.exists) {
                this.existingUser = true;
                this.showPassword = true;
            } else {
                this.existingUser = false;
                this.showVerification = true;
                this.message = 'A verification code has been sent to your email.';
                this.messageClass = 'success';
            }
        },

        async verifyCode() {
            this.loading = true;  // Start loading
            const response = await fetch('Auth', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ action: 'verifyCode', email: this.email, verificationCode: this.verificationCode })
            });
            const result = await response.json();
            this.loading = false;  // Stop loading

            if (result.success) {
                this.showVerification = false;
                this.showPassword = true;
                this.message = 'Verification successful. Please complete your registration below.';
                this.messageClass = 'success';
            } else {
                this.message = 'Verification code is incorrect!';
                this.messageClass = 'error';
            }
        },

        async loginUser() {
            this.loading = true;  // Start loading
            const data = { action: 'login', email: this.email, password: this.password };
            const response = await this.submitForm(data);
            this.loading = false;  // Stop loading
            
            if (response.success) {
                this.message = 'Login successful!';
                this.messageClass = 'success';
                // Redirect to the welcome page
                window.location.href = `Home?message=${encodeURIComponent('Welcome back! You have successfully logged in.')}`;
            } else {
                this.message = response.error;
                this.messageClass = 'error';
            }
        },

        async registerUser() {
            if (this.password !== this.repeatPassword) {
                this.message = 'Passwords do not match!';
                this.messageClass = 'error';
                return;
            }
            
            this.loading = true;  // Start loading
            const data = { 
                action: 'register', 
                email: this.email, 
                firstName: this.firstName,
                lastName: this.lastName,
                username: this.username, 
                password: this.password 
            };
            const response = await this.submitForm(data);
            this.loading = false;  // Stop loading

            if (response.success) {
                this.message = 'Registration successful!';
                this.messageClass = 'success';
                window.location.href = `Signup?message=${encodeURIComponent('Welcome, you can now register')}`;

            } else {
                this.message = response.error;
                this.messageClass = 'error';
            }
        },

        async submitForm(data) {
            const response = await fetch('Auth', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });
            return await response.json();
        },

        togglePasswordVisibility() {
            this.showPasswordInput = !this.showPasswordInput;
        },

        checkPasswordStrength() {
            if (this.password.length < 6) {
                this.passwordStrengthMessage = 'Password is too weak';
            } else if (this.password.length < 10) {
                this.passwordStrengthMessage = 'Password is medium strength';
            } else {
                this.passwordStrengthMessage = 'Password is strong';
            }
        }
    };
}

</script>
</body>
