@props(['current' => 1])

@php
    // url = us step par click karne par kahan jana hai (null = clickable nahi)
    $steps = [
        ['label' => 'Bag', 'url' => route('cart.index')],
        ['label' => 'Address', 'url' => route('cart.checkout')],
        ['label' => 'Payment', 'url' => null],
    ];
@endphp

<style>
    .checkout-steps {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        margin: 6px 0 28px;
        width: 100%;
    }

    .cs-item {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #9ca3af;
        font-size: 14px;
        font-weight: 600;
    }

    .cs-circle {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #e5e7eb;
        color: #6b7280;
        border-radius: 50%;
        font-size: 14px;
        transition: box-shadow 0.2s;
    }

    .cs-item.active { color: #111827; }

    .cs-item.active .cs-circle {
        background: #0F766E;
        color: #fff;
        box-shadow: 0 0 0 4px rgba(15, 118, 110, 0.15);
    }

    .cs-item.done { color: #0F766E; }
    .cs-item.done .cs-circle { background: #0F766E; color: #fff; }

    /* Clickable (poore ho chuke) steps */
    a.cs-item {
        text-decoration: none;
        cursor: pointer;
    }

    a.cs-item:hover .cs-circle {
        box-shadow: 0 0 0 4px rgba(15, 118, 110, 0.2);
    }

    a.cs-item:hover .cs-label {
        text-decoration: underline;
    }

    .cs-line {
        width: 70px;
        height: 2px;
        background: #e5e7eb;
    }

    .cs-line.done { background: #0F766E; }

    @media (max-width: 650px) {
        .cs-label { display: none; }
        .cs-item.active .cs-label { display: inline; }
        .cs-line { width: 30px; }
    }

    /* Teal radio buttons (accent-color par depend nahi) */
    input[type="radio"] {
        -webkit-appearance: none;
        appearance: none;
        width: 18px;
        height: 18px;
        border: 2px solid #9ca3af;
        border-radius: 50%;
        display: inline-grid;
        place-content: center;
        cursor: pointer;
        background: #fff;
        flex-shrink: 0;
        vertical-align: middle;
    }

    input[type="radio"]::before {
        content: "";
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #0F766E;
        transform: scale(0);
        transition: transform 0.15s;
    }

    input[type="radio"]:checked {
        border-color: #0F766E;
    }

    input[type="radio"]:checked::before {
        transform: scale(1);
    }
</style>

<div class="checkout-steps">
    @foreach ($steps as $index => $step)
        @php
            $number = $index + 1;
            $isDone = $number < $current;
            $isActive = $number === $current;
            $isLink = $isDone && $step['url'];
            $tag = $isLink ? 'a' : 'div';
            $classes = 'cs-item ' . ($isDone ? 'done' : '') . ' ' . ($isActive ? 'active' : '');
        @endphp

        <{{ $tag }}
            @if ($isLink) href="{{ $step['url'] }}" title="Back to {{ $step['label'] }}" @endif
            class="{{ $classes }}">
            <span class="cs-circle">
                @if ($isDone)
                    <i class="bi bi-check-lg"></i>
                @else
                    {{ $number }}
                @endif
            </span>
            <span class="cs-label">{{ $step['label'] }}</span>
        </{{ $tag }}>

        @if (!$loop->last)
            <div class="cs-line {{ $isDone ? 'done' : '' }}"></div>
        @endif
    @endforeach
</div>
