@extends('layouts.app') @section('content')
<div class="container-fluid px-4">
    <div class="dashboard-header">
        <h1>Pending Product Approvals</h1>
        <div class="breadcrumb">
            <span class="active">Dashboard / Products / Pending</span>
        </div>
    </div>

    <div class="dashboard-section">
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Submitted By</th>
                        <th>Price</th>
                        <th>Date Submitted</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingProducts as $product)
                    <tr>
                        <td>
                            <strong>{{ $product->name }}</strong>
                            <p class="text-muted small">
                                {{ Str::limit($product->description, 50) }}
                            </p>
                        </td>
                        <td>{{ $product->user->name }}</td>
                        <td>€{{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <form
                                    method="POST"
                                    action="{{
                                        route(
                                            'admin.products.approve',
                                            $product
                                        )
                                    }}"
                                >
                                    @csrf
                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-success"
                                    >
                                        Approve
                                    </button>
                                </form>
                                <button
                                    type="button"
                                    class="btn btn-sm btn-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#rejectModal{{ $product->id }}"
                                >
                                    Reject
                                </button>
                                <a
                                    href="{{
                                        route('products.show', $product)
                                    }}"
                                    class="btn btn-sm btn-primary"
                                    >Preview</a
                                >
                            </div>

                            <!-- Rejection Modal -->
                            <div
                                class="modal fade"
                                id="rejectModal{{ $product->id }}"
                                tabindex="-1"
                            >
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">
                                                Reject Product
                                            </h5>
                                            <button
                                                type="button"
                                                class="btn-close"
                                                data-bs-dismiss="modal"
                                            ></button>
                                        </div>
                                        <form
                                            method="POST"
                                            action="{{
                                                route(
                                                    'admin.products.reject',
                                                    $product
                                                )
                                            }}"
                                        >
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label"
                                                        >Reason for
                                                        rejection</label
                                                    >
                                                    <textarea
                                                        name="rejection_reason"
                                                        class="form-control"
                                                        rows="3"
                                                        required
                                                    ></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button
                                                    type="button"
                                                    class="btn btn-secondary"
                                                    data-bs-dismiss="modal"
                                                >
                                                    Cancel
                                                </button>
                                                <button
                                                    type="submit"
                                                    class="btn btn-danger"
                                                >
                                                    Confirm Rejection
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $pendingProducts->links() }}
        </div>
    </div>
</div>
@endsection
