<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Takalo-Takalo - Register</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="/assets/images/favicon.ico" />
    <style>
      .error-message {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
        display: none;
      }
      .form-control.is-invalid {
        border-color: #dc3545;
      }
      .form-control.is-valid {
        border-color: #28a745;
      }
    </style>
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
          <div class="row flex-grow">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left p-5">
                <div class="brand-logo">
                  <img src="/assets/images/logo.png" alt="Logo">
                </div>
                <h4>New here?</h4>
                <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
                <form class="pt-3" id="registerForm" action="/register" method="POST">
                  <div class="form-group">
                    <input type="text" class="form-control form-control-lg" id="username" name="username" placeholder="Username" required>
                    <div class="error-message" id="usernameError">Username is required</div>
                  </div>
                  <div class="form-group">
                    <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="Email" required>
                    <div class="error-message" id="emailError">Please enter a valid email address</div>
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Password" required>
                    <div class="error-message" id="passwordError">Password is required</div>
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-lg" id="confirmPassword" name="confirm_password" placeholder="Confirm Password" required>
                    <div class="error-message" id="confirmPasswordError">Passwords do not match</div>
                  </div>
                  <div class="mb-4">
                    <div class="form-check">
                      <label class="form-check-label text-muted">
                        <input type="checkbox" class="form-check-input" name="terms" required> I agree to all Terms & Conditions </label>
                    </div>
                  </div>
                  <div class="mt-3">
                    <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">SIGN UP</button>
                  </div>
                  <div class="text-center mt-4 font-weight-light"> Already have an account? <a href="/login" class="text-primary">Login</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="/assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- inject:js -->
    <script src="/assets/js/off-canvas.js"></script>
    <script src="/assets/js/hoverable-collapse.js"></script>
    <script src="/assets/js/misc.js"></script>
    <!-- endinject -->
    <!-- Form validation -->
    <script>
      (function() {
        'use strict';
        
        function validateEmail(email) {
          const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
          return emailRegex.test(email);
        }
        
        function showError(inputId, errorId) {
          document.getElementById(inputId).classList.add('is-invalid');
          document.getElementById(inputId).classList.remove('is-valid');
          document.getElementById(errorId).style.display = 'block';
        }
        
        function hideError(inputId, errorId) {
          document.getElementById(inputId).classList.remove('is-invalid');
          document.getElementById(inputId).classList.add('is-valid');
          document.getElementById(errorId).style.display = 'none';
        }
        
        // Email validation on blur
        document.getElementById('email').addEventListener('blur', function() {
          if (!validateEmail(this.value)) {
            showError('email', 'emailError');
          } else {
            hideError('email', 'emailError');
          }
        });
        
        // Password confirmation validation
        document.getElementById('confirmPassword').addEventListener('blur', function() {
          const password = document.getElementById('password').value;
          if (this.value !== password) {
            showError('confirmPassword', 'confirmPasswordError');
          } else {
            hideError('confirmPassword', 'confirmPasswordError');
          }
        });
        
        // Form submission validation
        document.getElementById('registerForm').addEventListener('submit', function(e) {
          let isValid = true;
          
          const username = document.getElementById('username');
          const email = document.getElementById('email');
          const password = document.getElementById('password');
          const confirmPassword = document.getElementById('confirmPassword');
          
          // Username validation
          if (username.value.trim() === '') {
            showError('username', 'usernameError');
            isValid = false;
          } else {
            hideError('username', 'usernameError');
          }
          
          // Email validation
          if (!validateEmail(email.value)) {
            showError('email', 'emailError');
            isValid = false;
          } else {
            hideError('email', 'emailError');
          }
          
          // Password validation
          if (password.value.trim() === '') {
            showError('password', 'passwordError');
            isValid = false;
          } else {
            hideError('password', 'passwordError');
          }
          
          // Confirm password validation
          if (confirmPassword.value !== password.value) {
            showError('confirmPassword', 'confirmPasswordError');
            isValid = false;
          } else {
            hideError('confirmPassword', 'confirmPasswordError');
          }
          
          if (!isValid) {
            e.preventDefault();
          }
        });
      })();
    </script>
  </body>
</html>
