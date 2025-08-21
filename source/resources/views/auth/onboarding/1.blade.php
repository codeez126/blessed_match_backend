@extends('layouts.app')
@push('styles')
    <style>
        #navbar{
            display: none;
        }
        .footer{
            display: none;
        }
    </style>

    <style>
        /* Maintained your original tab styling */
        .nav-tabs {
            border-bottom: none;
            margin-bottom: 30px;
        }
        .nav-tabs .nav-link {
            color: #495057;
            border: 1px solid #4950571c;
            padding: 12px 20px;
            font-weight: 500;
            position: relative;
            display: flex;
            align-items: center;
            gap: 8px;
            border-radius: 0px;
            border-left : 1px solid #4950571a;
        }
        .nav-tabs .nav-link.active {
            border-bottom: 2px solid #D7486B;
            color: #D7486B;
            background: #d7486b1a;
        }
        .nav-tabs .nav-link.completed {
            background-color: #D7486B;
            color: white;
        }

        .nav-tabs .nav-link.completed:after {
            border-top: 10px solid #D7486B;
        }

        /* Added tick mark styling */
        .nav-tabs .nav-link .step-indicator {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
            border: 2px solid currentColor;
            border-radius: 50%;
            margin-right: 8px;
        }
        .nav-tabs .nav-link.active .step-indicator,
        .nav-tabs .nav-link.completed .step-indicator {
            border-color: #d7486b;
            background: #d7486b;
            color: white;
        }
        .nav-tabs .nav-link.completed .step-indicator:after {
            content: "✓";
            font-size: 12px;
        }
        .nav-tabs .nav-link:not(.completed):not(.active) .step-indicator {
            background-color: white;
            border-color: #D7486B;
            color: #D7486B;
        }

        /* Rest of your original styles */
        .tab-content {
            padding: 0;
            border: none;
            background-color: transparent;
        }
        .form-section-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-label {
            font-weight: 500;
            margin-bottom: 8px;
            display: block;
        }
        .form-label.required:after {
            content: "*";
            color: #f00;
            margin-left: 4px;
        }
        .form-control {
            border-radius: 6px;
            padding: 10px 15px;
            border: 1px solid #ddd;
        }
        .btn-action {
            padding: 10px 25px;
            border-radius: 6px;
            font-weight: 500;
        }
        .btn-cancel {
            background-color: #F9EEF2;
            color: #333;
            border: none;
        }
        .btn-continue {
            background-color: #3f80ea;
            color: #fff;
            border: none;
        }
        .radio-group {
            display: flex;
            gap: 20px;
            margin-top: 10px;
        }
        .radio-option {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .file-upload {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .file-upload-btn {
            padding: 8px 15px;
            background-color: #f0f0f0;
            border-radius: 4px;
            border: 1px solid #ddd;
            cursor: pointer;
        }
        .file-name {
            color: #666;
            font-size: 14px;
        }
        .form-note {
            color: #666;
            font-size: 14px;
            margin: 20px 0;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 6px;
        }
        .form-row {
            display: flex;
            gap: 20px;
        }
        .form-row .form-group {
            flex: 1;
        }
        .loading-spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
            margin-left: 10px;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
@endpush

@section('contents')
    <section class="log-reg theme-bg">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-md-12">
                    <div class="log-reg-inner form-bg p-md-5 rounded-3 shadow-sm mx-auto">
                        <form id="multiStepForm">
                            <!-- Tabs Navigation - Now with step indicators -->
                            <ul class="nav nav-tabs" id="formTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal" type="button" role="tab" aria-controls="personal" aria-selected="true">
                                        <span class="step-indicator">✓</span>
                                        Personal Details
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="agency-tab" data-bs-toggle="tab" data-bs-target="#agency" type="button" role="tab" aria-controls="agency" aria-selected="false">
                                        <span class="step-indicator">✓</span>
                                        Agency Details
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">
                                        <span class="step-indicator">✓</span>
                                        Contact Person
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="work-tab" data-bs-toggle="tab" data-bs-target="#work" type="button" role="tab" aria-controls="work" aria-selected="false">
                                        <span class="step-indicator">✓</span>
                                        Work Order Scope
                                    </button>
                                </li>
                            </ul>

                            <!-- Tab Content (remainder of your form content stays exactly the same as in your original) -->
                            <div class="tab-content" id="formTabsContent">

                                <div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="personal-tab">
                                    a
                                </div>

                                <!-- Agency Details -->
                                <div class="tab-pane fade" id="agency" role="tabpanel" aria-labelledby="agency-tab">
                                   b
                                </div>

                                <!-- Contact Person Details -->
                                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                    <!-- ... your existing contact person form ... -->
                                </div>

                                <!-- Work Order Scope -->
                                <div class="tab-pane fade" id="work" role="tabpanel" aria-labelledby="work-tab">
                                    <!-- ... your existing work order scope form ... -->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Form submission for each step
            document.querySelectorAll('.submit-step').forEach(button => {
                button.addEventListener('click', function() {
                    const form = document.getElementById('multiStepForm');
                    const currentTabId = this.closest('.tab-pane').id;
                    const step = this.getAttribute('data-step');
                    const nextTabId = this.getAttribute('data-next');
                    const button = this;
                    const spinner = button.querySelector('.loading-spinner');

                    // Show loading spinner
                    button.disabled = true;
                    spinner.style.display = 'inline-block';

                    // Validate form
                    if (!form.checkValidity()) {
                        form.reportValidity();
                        button.disabled = false;
                        spinner.style.display = 'none';
                        return;
                    }

                    // Prepare form data
                    const formData = new FormData(form);
                    formData.append('step', step);

                    // Submit form via AJAX
                    fetch("{{ route('HomePage') }}", {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Mark current step as completed
                                const currentTabButton = document.querySelector(`#${currentTabId}-tab`);
                                currentTabButton.classList.remove('active');
                                currentTabButton.classList.add('completed');

                                // If there's a next step, go to it
                                if (nextTabId) {
                                    const nextTab = document.querySelector(`#${nextTabId}-tab`);
                                    const tab = new bootstrap.Tab(nextTab);
                                    tab.show();
                                } else {
                                    // Form completed
                                    alert('Registration completed successfully!');
                                    // Redirect or do something else
                                    window.location.href = data.redirect || '/';
                                }
                            } else {
                                // Show validation errors
                                if (data.errors) {
                                    for (const [field, errors] of Object.entries(data.errors)) {
                                        const input = document.querySelector(`[name="${field}"]`);
                                        if (input) {
                                            input.classList.add('is-invalid');
                                            const errorDiv = document.createElement('div');
                                            errorDiv.className = 'invalid-feedback';
                                            errorDiv.textContent = errors[0];
                                            input.parentNode.appendChild(errorDiv);
                                        }
                                    }
                                } else {
                                    alert(data.message || 'An error occurred. Please try again.');
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred. Please try again.');
                        })
                        .finally(() => {
                            button.disabled = false;
                            spinner.style.display = 'none';
                        });
                });
            });

            // Previous button functionality
            document.querySelectorAll('.prev-step').forEach(button => {
                button.addEventListener('click', function() {
                    const prevTabId = this.getAttribute('data-prev');
                    const prevTab = document.querySelector(`#${prevTabId}-tab`);
                    const tab = new bootstrap.Tab(prevTab);
                    tab.show();
                });
            });

            // File upload display
            document.getElementById('companyLogo').addEventListener('change', function(e) {
                const fileName = e.target.files[0] ? e.target.files[0].name : 'No file chosen';
                document.querySelector('.file-name').textContent = fileName;
            });

            // Clear validation errors when input changes
            document.querySelectorAll('input, textarea, select').forEach(input => {
                input.addEventListener('input', function() {
                    this.classList.remove('is-invalid');
                    const errorDiv = this.parentNode.querySelector('.invalid-feedback');
                    if (errorDiv) {
                        errorDiv.remove();
                    }
                });
            });
        });
    </script>
@endpush
