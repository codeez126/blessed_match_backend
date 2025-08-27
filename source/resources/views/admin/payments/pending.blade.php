@extends('admin.layouts.app')
@section('contents')
    <style>
        .image-modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.8);
            text-align: center;
        }
        .image-modal img {
            max-width: 90%;
            max-height: 90%;
            margin-top: 5%;
        }
        .image-modal .close {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 30px;
            color: white;
            cursor: pointer;
        }
    </style>
    <style>
        .modal-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.6); display: flex; justify-content: center; align-items: center;
        }
        .modal-box {
            background: #fff; padding: 20px; border-radius: 8px; max-width: 500px; width: 90%;
        }
        .close-btn { float: right; cursor: pointer; font-size: 20px; }
    </style>
    <div class="page-body">
        <div class="container-fluid">
            <div class="row page-title">
                <div class="col-6">
                    <h3>Pending Payments</h3>
                </div>
                <div class="col-6">
                    <nav>
                        <ol class="breadcrumb justify-content-sm-end align-items-center">
                            <li class="breadcrumb-item"><a href="">
                                    <svg class="svg-color">
                                        <use href="{{ asset('assets/admin/theme/svg/iconly-sprite.svg#Home') }}"></use>
                                    </svg></a></li>
                            <li class="breadcrumb-item">Payments</li>
                            <li class="breadcrumb-item active">Pending</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="container-fluid default-dashboard">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="p-5">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h2 class="mb-0">Pending List</h2>
                            </div>
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <table id="example" class="table table-striped table-bordered dt-responsive nowrap custom-table" style="width:100%">
                                <thead>
                                <tr class="text-center" style="background-color: transparent !important;">
                                    <th>No.</th>
                                    <th>Package</th>
                                    <th>Payment Proof</th>
                                    <th>Amount</th>
                                    <th>Payment Method</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($pending as $index => $item)
                                    <tr class="text-center">
                                        <th>{{ $index+1 }}</th>
                                        <td>
                                            <button class="btn btn-sm btn-info view-plan"
                                                    data-title="{{ $item->paymentPlan->title }}"
                                                    data-description="{{ $item->paymentPlan->description }}"
                                                    data-price="{{ $item->paymentPlan->price }}"
                                                    data-duration="{{ $item->paymentPlan->duration_days }}"
                                                    data-features='@json($item->paymentPlan->features)' style="    background-color: #117178;">
                                                {{ $item->paymentPlan->title }} ({{ $item->paymentPlanVariation->duration_days ?? '0 Days' }})
                                            </button>
                                        </td>
                                        <td>
                                            <img src="{{ asset($item->payment_proof) }}" width="50" class="clickable-image">
                                        </td>
                                        <td>{{ $item->amount }}</td>
                                        <td>{{ $item->type_id_name }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm view-payment"
                                                    data-user_id="{{ $item->user_id }}"
                                                    data-amount="{{ $item->amount }}"
                                                    data-currency="{{ $item->currency }}"
                                                    data-user_note="{{ $item->user_note }}"
                                                    data-admin_note="{{ $item->admin_note }}"
                                                    data-status="{{ $item->status }}">
                                                <i class="fa fa-eye text-warning"></i>
                                            </button>
                                            <!-- Keep your original button exactly as it was -->
                                            <button type="button" class="btn btn-sm" data-payment-id="{{ $item->id }}" data-action="1">
                                                <i class="fa fa-check text-success"></i>
                                            </button>

                                            <!-- Reject Button -->
                                            <button type="button" class="btn btn-sm " data-payment-id="{{ $item->id }}" data-action="2">
                                                <i class="fa fa-times text-danger"></i>
                                            </button>
                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Custom Modal -->
    <div id="imageModal" class="image-modal">
        <span class="close">&times;</span>
        <img id="modalImage">
    </div>
{{--    payment plans model--}}
    <div id="planModal" class="modal-overlay" style="display:none;">
        <div class="modal-box">
            <span class="close-btn">&times;</span>
            <h3 id="planTitle"></h3>
            <p id="planDescription"></p>
            <p><strong>Price:</strong> <span id="planPrice"></span> <span id="planCurrency"></span></p>
            <p><strong>Duration:</strong> <span id="planDuration"></span> days</p>
            <h5>Features:</h5>
            <ul id="planFeatures"></ul>
        </div>
    </div>
{{-- user payment mode--}}
    <div id="paymentModal" class="modal-overlay" style="display:none;">
        <div class="modal-box">
            <span class="close-btn">&times;</span>
            <h3>Payment Details</h3>
            <p><b>User ID:</b> <span id="modalUserId"></span></p>
            <p><b>Amount:</b> <span id="modalAmount"></span></p>
            <p><b>Currency:</b> <span id="modalCurrency"></span></p>
            <p><b>User Note:</b> <span id="modalUserNote"></span></p>
            <p><b>Admin Note:</b> <span id="modalAdminNote"></span></p>
            <p><b>Status:</b> <span id="modalStatus"></span></p>
        </div>
    </div>





    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const modal = document.getElementById("imageModal")
            const modalImg = document.getElementById("modalImage")
            const closeBtn = document.querySelector(".image-modal .close")

            document.querySelectorAll(".clickable-image").forEach(img => {
                img.addEventListener("click", function () {
                    modal.style.display = "block"
                    modalImg.src = this.src
                })
            })

            closeBtn.addEventListener("click", function () {
                modal.style.display = "none"
            })

            modal.addEventListener("click", function (e) {
                if (e.target === modal) {
                    modal.style.display = "none"
                }
            })
        })
    </script>
{{--    payment plans--}}
<script>
    document.querySelectorAll('.view-plan').forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById('planTitle').innerText = this.dataset.title;
            document.getElementById('planDescription').innerText = this.dataset.description;
            document.getElementById('planPrice').innerText = this.dataset.price;
            document.getElementById('planCurrency').innerText = this.dataset.currency;
            document.getElementById('planDuration').innerText = this.dataset.duration;

            let features = JSON.parse(this.dataset.features);
            let featuresList = document.getElementById('planFeatures');
            featuresList.innerHTML = '';
            features.forEach(f => {
                let li = document.createElement('li');
                li.textContent = f;
                featuresList.appendChild(li);
            });

            document.getElementById('planModal').style.display = 'flex';
        });
    });

    document.querySelector('#planModal .close-btn').addEventListener('click', () => {
        document.getElementById('planModal').style.display = 'none';
    });

    document.getElementById('planModal').addEventListener('click', (e) => {
        if (e.target.id === 'planModal') {
            document.getElementById('planModal').style.display = 'none';
        }
    });

</script>
{{--    user payment details--}}
    <script>
        document.querySelectorAll('.view-payment').forEach(button => {
            button.addEventListener('click', function () {
                document.getElementById('modalUserId').innerText = this.dataset.user_id;
                document.getElementById('modalAmount').innerText = this.dataset.amount;
                document.getElementById('modalCurrency').innerText = this.dataset.currency;
                document.getElementById('modalUserNote').innerText = this.dataset.user_note;
                document.getElementById('modalAdminNote').innerText = this.dataset.admin_note || 'N/A';
                document.getElementById('modalStatus').innerText = this.dataset.status == 0 ? 'Pending' : 'Completed';

                document.getElementById('paymentModal').style.display = 'flex';
            });
        });

        // Close modal on button click
        document.querySelector('#paymentModal .close-btn').addEventListener('click', () => {
            document.getElementById('paymentModal').style.display = 'none';
        });

        // Close modal when clicking outside the box
        document.getElementById('paymentModal').addEventListener('click', (e) => {
            if (e.target.id === 'paymentModal') {
                document.getElementById('paymentModal').style.display = 'none';
            }
        });
    </script>


    <script>
        const authToken = "{{ auth()->user()->createToken('authToken')->accessToken }}";
        console.log("Auth Token:", authToken ? "Token exists" : "No token");

        function updatePaymentStatus(paymentId, action) {
            console.log("updatePaymentStatus called with ID:", paymentId, "Action:", action);

            const actionText = action === 1 ? "Accept" : "Reject";
            console.log(`${actionText} payment action initiated`);

            fetch("{{ url('api/admin-action-on-payment') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "Authorization": "Bearer " + authToken
                },
                body: JSON.stringify({
                    payment_id: paymentId,
                    status: action
                })
            })
                .then(response => {
                    console.log("Response status:", response.status);
                    console.log("Response ok:", response.ok);
                    return response.json();
                })
                .then(data => {
                    console.log("API Response:", data);

                    const actionText = action === 1 ? "accepted" : "rejected";

                    // Check for success using status code and presence of data
                    if (data.status === 201 && data.data) {
                        alert(`Payment ${actionText} successfully!`);
                        console.log(`Success: Payment ${actionText} - Reloading page...`);

                        // Reload the page after successful update
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);

                    } else {
                        alert(`Failed to ${actionText.slice(0, -2)} payment.`);
                        console.log("Error: Unexpected API response", data);
                    }
                })
                .catch(err => {
                    console.error("Fetch Error:", err);
                    alert("Network error occurred");
                });
        }

        document.addEventListener("DOMContentLoaded", function() {
            console.log("DOM Content Loaded");

            // Select buttons by their data attribute instead of class
            const buttons = document.querySelectorAll('button[data-payment-id]');
            console.log("Found buttons:", buttons.length);

            if (buttons.length === 0) {
                console.error("No buttons found with data-payment-id attribute");
            }

            buttons.forEach((btn, index) => {
                console.log(`Button ${index + 1}:`, btn);
                console.log(`Button ${index + 1} payment-id:`, btn.dataset.paymentId);

                btn.addEventListener('click', function() {
                    console.log("Button clicked:", this);
                    const paymentId = this.dataset.paymentId;
                    const action = parseInt(this.dataset.action);

                    console.log("Payment ID from dataset:", paymentId);
                    console.log("Action from dataset:", action);

                    if (!paymentId) {
                        console.error("No payment ID found in dataset");
                        alert("Error: Payment ID not found");
                        return;
                    }

                    if (!action || (action !== 1 && action !== 2)) {
                        console.error("Invalid action found in dataset:", action);
                        alert("Error: Invalid action");
                        return;
                    }

                    const actionText = action === 1 ? "accept" : "reject";

                    // Show confirmation dialog with dynamic message
                    if (confirm(`Are you sure you want to ${actionText} this payment?`)) {
                        console.log(`User confirmed the ${actionText} action`);
                        updatePaymentStatus(paymentId, action);
                    } else {
                        console.log(`User cancelled the ${actionText} action`);
                    }
                });
            });
        });
    </script>


@endsection
