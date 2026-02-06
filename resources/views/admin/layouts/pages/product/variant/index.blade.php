@extends('admin.layouts.app')
@section('title','Product Variants')

@section('admin_content')
<div class="page-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Product Variants</h5>
                        <a href="{{ route('admin.product.variants.create') }}"
                           class="btn btn-outline-primary px-5 rounded-0">
                            Add Variant
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>SKU</th>
                                    <th>Attributes</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($variants as $k => $v)
                                <tr>
                                    <td>{{ $k+1 }}</td>
                                    <td>{{ $v->product->name }}</td>
                                    <td>{{ $v->sku }}</td>
                                    <td>
                                        @foreach($v->values as $val)
                                            <span class="badge bg-secondary">
                                                {{ $val->attribute->name }}:
                                                {{ $val->attributeValue->value }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td>
                                        {{ $v->price_override ?? $v->product->base_price }}
                                    </td>
                                    <td>
                                        @if($v->status)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
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
@endsection
