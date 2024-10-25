<body>

    <main>
        <div class="image-container"></div>
        <div class="container">
            <!-- when the submit button is clicked and an input field is wrong, reload the page with the current form submitted and the error messages. -->
            <div
                class="change-form-login <?php echo isset($_POST['form_type']) && $_POST['form_type'] == 'register' ? 'active' : ''; ?>">
                <p>Already have an account?</p>
                <button class="login">Login</button>
            </div>
            <div
                class="change-form-register <?php echo isset($_POST['form_type']) && $_POST['form_type'] == 'login' ? 'active' : ''; ?>">
                <p>Don't have an account?</p>
                <button class="register">Register</button>
            </div>
            <section
                class="register-form <?php echo isset($_POST['form_type']) && $_POST['form_type'] == 'register' ? 'active' : ''; ?>">
                <h1>Create an account</h1>
                <div class="form-container">
                    <form action="index.php" method="post" novalidate>
                        <!-- hidden input to check which form is submitted -->
                        <input type="hidden" name="form_type" value="register" />
                        <div class="info">
                            <span>Name</span>
                            <span class="error">* <?php echo $nameErr ?></span>
                        </div>
                        <input type="text" name="name" placeholder="Full Name..." autocomplete="off" />
                        <div class="info">
                            <span>Password</span>
                            <span class="error">* <?php echo $passwordErr ?></span>
                        </div>
                        <input type="password" name="password" placeholder="************" autocomplete="off" />
                        <div class="info">
                            <span>Email</span>
                            <span class="error">* <?php echo $emailErr ?></span>
                        </div>
                        <input type="email" name="email" placeholder="Email Address..." autocomplete="off" />
                        <div class="info">
                            <span>Phone number</span>
                            <span class="error">* <?php echo $phoneErr ?></span>
                        </div>
                        <input type="tel" name="phone" placeholder="Phone Number..." autocomplete="off" />
                        <input type="submit" value="Create account" />
                    </form>
                </div>
            </section>
            <section
                class="login-form <?php echo isset($_POST['form_type']) && $_POST['form_type'] == 'login' ? 'active' : ''; ?>">
                <div class="form-container">
                    <h1>Login</h1>
                    <p class="login-error"><?php echo $loginErr ?></p>
                    <form action="index.php" method="post" novalidate>
                        <input type="hidden" name="form_type" value="login" />
                        <div class="info">
                            <span>Name</span>
                        </div>
                        <input type="text" name="name" placeholder="Full name..." autocomplete="off" />
                        <div class="info">
                            <span>Password</span>
                        </div>
                        <input type="password" name="password" placeholder="************" autocomplete="off" />
                        <input type="submit" value="Login" />
                    </form>
                </div>
            </section>
        </div>
    </main>
</body>