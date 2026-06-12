@extends('layouts.admin')

@section('content')
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 row-cols-xxl-4">
        <div class="col">
            <div class="card radius-10 border-0 border-start border-tiffany border-3">
            <div class="card-body">
                <div class="d-flex align-items-center">
                <div class="">
                    <p class="mb-1">Total Project Types</p>
                    <h4 class="mb-0 text-tiffany">{{ $projectTypes->count() }}</h4>
                </div>
                <div class="ms-auto widget-icon bg-tiffany text-white">
                    <i class="bi bi-briefcase-fill"></i>
                </div>
                </div>
            </div>
            </div>
        </div>
        <div class="col">
        <div class="card radius-10 border-0 border-start border-success border-3">
            <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="">
                <p class="mb-1">Total Revenue</p>
                <h4 class="mb-0 text-success">$1,245</h4>
                </div>
                <div class="ms-auto widget-icon bg-success text-white">
                <i class="bi bi-currency-dollar"></i>
                </div>
            </div>
            </div>
        </div>
        </div>
        <div class="col">
        <div class="card radius-10 border-0 border-start border-pink border-3">
            <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="">
                <p class="mb-1">Bounce Rate</p>
                <h4 class="mb-0 text-pink">24.25%</h4>
                </div>
                <div class="ms-auto widget-icon bg-pink text-white">
                <i class="bi bi-bar-chart-fill"></i>
                </div>
            </div>
            </div>
        </div>
        </div>
        <div class="col">
        <div class="card radius-10 border-0 border-start border-orange border-3">
            <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="">
                <p class="mb-1">New Users</p>
                <h4 class="mb-0 text-orange">214</h4>
                </div>
                <div class="ms-auto widget-icon bg-orange text-white">
                <i class="bi bi-person-plus-fill"></i>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-lg-12 col-xl-6 d-flex">
        <div class="card radius-10 w-100">
            <div class="card-body">
            <div class="d-flex align-items-center">
                <h6 class="mb-0">Project Types</h6>
                <div class="fs-5 ms-auto dropdown">
                <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></div>
                    <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </div>
            </div>
            <div class="table-responsive mt-2">
                <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#ID</th>
                        <th>Project Type</th>
                        <th>Added By</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($projectTypes as $projectType)
                    <tr>
                        <td>{{ $projectType->id }}</td>
                        <td>{{ $projectType->project_type_name }}</td>
                        <td>{{ $projectType->added_by }}</td>
                        <td>{{ $projectType->created_at }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-3 fs-6">
                            <a href="javascript:;" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View detail" aria-label="Views"><i class="bi bi-eye-fill"></i></a>
                            <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit"><i class="bi bi-pencil-fill"></i></a>
                            <a href="javascript:;" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"></i></a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    nothing to show
                    @endforelse
                </tbody>
                </table>
            </div>
            </div>
        </div>
        </div>
        <div class="col-12 col-lg-12 col-xl-6 d-flex">
        <div class="card radius-10 w-100">
            <div class="card-body">
            <div class="d-flex align-items-center">
                <h6 class="mb-0">Reserved</h6>
                <div class="fs-5 ms-auto dropdown">
                <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></div>
                    <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </div>
            </div>
            <div class="table-responsive mt-2">
                <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                    <th>#ID</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Date</th>
                    <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <td>#89742</td>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                        <div class="product-box border">
                            <img src="{{ asset('dashboard_assets') }}/images/products/11.png" alt="">
                        </div>
                        <div class="product-info">
                            <h6 class="product-name mb-1">Smart Mobile Phone</h6>
                        </div>
                        </div>
                    </td>
                    <td>2</td>
                    <td>$214</td>
                    <td>Apr 8, 2021</td>
                    <td>
                        <div class="d-flex align-items-center gap-3 fs-6">
                        <a href="javascript:;" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View detail" aria-label="Views"><i class="bi bi-eye-fill"></i></a>
                        <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit"><i class="bi bi-pencil-fill"></i></a>
                        <a href="javascript:;" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"></i></a>
                        </div>
                    </td>
                    </tr>
                    <tr>
                    <td>#68570</td>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                        <div class="product-box border">
                            <img src="{{ asset('dashboard_assets') }}/images/products/07.png" alt="">
                        </div>
                        <div class="product-info">
                            <h6 class="product-name mb-1">Sports Time Watch</h6>
                        </div>
                        </div>
                    </td>
                    <td>1</td>
                    <td>$185</td>
                    <td>Apr 9, 2021</td>
                    <td>
                        <div class="d-flex align-items-center gap-3 fs-6">
                        <a href="javascript:;" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View detail" aria-label="Views"><i class="bi bi-eye-fill"></i></a>
                        <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit"><i class="bi bi-pencil-fill"></i></a>
                        <a href="javascript:;" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"></i></a>
                        </div>
                    </td>
                    </tr>
                    <tr>
                    <td>#38567</td>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                        <div class="product-box border">
                            <img src="{{ asset('dashboard_assets') }}/images/products/17.png" alt="">
                        </div>
                        <div class="product-info">
                            <h6 class="product-name mb-1">Women Red Heals</h6>
                        </div>
                        </div>
                    </td>
                    <td>3</td>
                    <td>$356</td>
                    <td>Apr 10, 2021</td>
                    <td>
                        <div class="d-flex align-items-center gap-3 fs-6">
                        <a href="javascript:;" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View detail" aria-label="Views"><i class="bi bi-eye-fill"></i></a>
                        <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit"><i class="bi bi-pencil-fill"></i></a>
                        <a href="javascript:;" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"></i></a>
                        </div>
                    </td>
                    </tr>
                    <tr>
                    <td>#48572</td>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                        <div class="product-box border">
                            <img src="{{ asset('dashboard_assets') }}/images/products/04.png" alt="">
                        </div>
                        <div class="product-info">
                            <h6 class="product-name mb-1">Yellow Winter Jacket</h6>
                        </div>
                        </div>
                    </td>
                    <td>1</td>
                    <td>$149</td>
                    <td>Apr 11, 2021</td>
                    <td>
                        <div class="d-flex align-items-center gap-3 fs-6">
                        <a href="javascript:;" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View detail" aria-label="Views"><i class="bi bi-eye-fill"></i></a>
                        <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit"><i class="bi bi-pencil-fill"></i></a>
                        <a href="javascript:;" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"></i></a>
                        </div>
                    </td>
                    </tr>
                    <tr>
                    <td>#96857</td>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                        <div class="product-box border">
                            <img src="{{ asset('dashboard_assets') }}/images/products/10.png" alt="">
                        </div>
                        <div class="product-info">
                            <h6 class="product-name mb-1">Orange Micro Headphone</h6>
                        </div>
                        </div>
                    </td>
                    <td>2</td>
                    <td>$199</td>
                    <td>Apr 15, 2021</td>
                    <td>
                        <div class="d-flex align-items-center gap-3 fs-6">
                        <a href="javascript:;" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View detail" aria-label="Views"><i class="bi bi-eye-fill"></i></a>
                        <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit"><i class="bi bi-pencil-fill"></i></a>
                        <a href="javascript:;" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"></i></a>
                        </div>
                    </td>
                    </tr>
                    <tr>
                    <td>#96857</td>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                        <div class="product-box border">
                            <img src="{{ asset('dashboard_assets') }}/images/products/12.png" alt="">
                        </div>
                        <div class="product-info">
                            <h6 class="product-name mb-1">Pro Samsung Laptop</h6>
                        </div>
                        </div>
                    </td>
                    <td>1</td>
                    <td>$699</td>
                    <td>Apr 18, 2021</td>
                    <td>
                        <div class="d-flex align-items-center gap-3 fs-6">
                        <a href="javascript:;" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View detail" aria-label="Views"><i class="bi bi-eye-fill"></i></a>
                        <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit"><i class="bi bi-pencil-fill"></i></a>
                        <a href="javascript:;" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"></i></a>
                        </div>
                    </td>
                    </tr>
                </tbody>
                </table>
            </div>
            </div>
        </div>
        </div>
    </div><!--end row-->

@endsection
