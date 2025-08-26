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
                                                    data-features='@json($item->paymentPlan->features)'>
                                                {{ $item->paymentPlan->title }} ({{ $item->variations->duration_days }})
                                            </button>
                                        </td>
                                        <td>
                                            <img src="{{ asset($item->payment_proof) }}" width="50" class="clickable-image">
                                        </td>
                                        <td>{{ $item->amount }}</td>
                                        <td>{{ $item->type_id_name }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.countries.edit', $item->id) }}" class="btn btn-sm btn-success">
                                                <i class="fa fa-pencil-alt"></i> Edit
                                            </a>
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
@endsection
