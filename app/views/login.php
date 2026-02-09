<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Takalo-Takalo - Login</title>
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
                <h4>Hello! let's get started</h4>
                <h6 class="font-weight-light">Sign in to continue.</h6>
                <form class="pt-3" id="loginForm" action="/login" method="POST">
                  <div class="form-group">
                    <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="Email" required>
                    <div class="error-message" id="emailError">Please enter a valid email address</div>
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Password" required>
                    <div class="error-message" id="passwordError">Password is required</div>
                  </div>
                  <div class="mt-3">
                    <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">SIGN IN</button>
                  </div>
                  <div class="my-2 d-flex justify-content-between align-items-center">
                    <div class="form-check">
                      <label class="form-check-label text-muted">
                      
                  <div class="text-center mt-4 font-weight-light"> Don't have an account? <a href="/register" class="text-primary">Create</a>
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
        
        // Form submission validation
        document.getElementById('loginForm').addEventListener('submit', function(e) {
          let isValid = true;
          
          const email = document.getElementById('email');
          const password = document.getElementById('password');
          
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
          
          if (!isValid) {
            e.preventDefault();
          }
        });
      })();
    </script>
  </body>
</html>
