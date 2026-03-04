@php $subtotal = 0; @endphp

@forelse($cart as $key => $item)
@php $subtotal += $item['price'] * $item['qty']; @endphp

<div class="minicart__product--items d-flex" data-key="{{ $key }}">

    <div class="minicart__thumb">
        <img src="{{ asset($item['image']) }}" alt="">
    </div>

    <div class="minicart__text">
        <h3 class="minicart__subtitle h4">
            {{ $item['name'] }}
        </h3>

        @if(!empty($item['attributes']))
            @foreach($item['attributes'] as $attr => $value)
                <span class="color__variant">
                    <b>{{ $attr }}:</b> {{ $value }}
                </span>
            @endforeach
        @endif

        <div class="minicart__price">
            <span class="current__price">
                ৳{{ number_format($item['price'],2) }}
            </span>
        </div>

        <div class="minicart__text--footer d-flex align-items-center">

            <div class="quantity__box minicart__quantity">

                <button type="button"
                        class="quantity__value decrease"
                        data-key="{{ $key }}">
                    -
                </button>

                <label>
                    <input type="number"
                           class="quantity__number"
                           value="{{ $item['qty'] }}"
                           readonly>
                </label>

                <button type="button"
                        class="quantity__value increase"
                        data-key="{{ $key }}">
                    +
                </button>

            </div>

            <button class="minicart__product--remove"
                    data-key="{{ $key }}">
                Remove
            </button>

        </div>
    </div>
</div>

@empty
<p class="text-center">Cart is empty</p>
@endforelse

<div class="minicart__amount">
    <div class="minicart__amount_list d-flex justify-content-between">
        <span>Sub Total:</span>
        <span><b>৳{{ number_format($subtotal,2) }}</b></span>
    </div>
</div>
