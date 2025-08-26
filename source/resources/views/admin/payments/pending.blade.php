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
                                    <th>Payment Method</th>
                                    <th>Payment Proof</th>
                                    <th>Amount</th>
                                    <th>Transaction Details</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($pending as $index => $item)
                                    <tr class="text-center">
                                        <th>{{ $index+1 }}</th>
                                        <td>{{ $item->payment_method }}</td>
                                        <td>
                                            <img src="{{ asset($item->payment_proof) }}" width="50" class="clickable-image">
                                        </td>
                                        <td>{{ $item->Amount }}</td>
                                        <td>{{ $item->type_id }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.countries.edit', $item->id) }}" class="btn btn-sm btn-success">
                                                <i class="fa fa-pencil-alt"></i> Edit
                                            </a>
                                            {{--                                            <form action="{{ route('admin.countries.destroy', $country->id) }}" method="POST" style="display: inline-block;">--}}
                                            {{--                                                @csrf--}}
                                            {{--                                                @method('DELETE')--}}
                                            {{--                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">--}}
                                            {{--                                                    <i class="fa fa-trash"></i> Delete--}}
                                            {{--                                                </button>--}}
                                            {{--                                            </form>--}}
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

@endsection
