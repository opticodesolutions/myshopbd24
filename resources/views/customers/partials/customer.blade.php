<li>
    <strong>{{ $customer->user->name ?? 'Unknown' }}</strong>

    @if($customer->children->isNotEmpty())
        <ul>
            @foreach($customer->children as $child)
                @include('customers.partials.customer', ['customer' => $child])
            @endforeach
        </ul>
    @endif

    @if($customer->sales->isNotEmpty())
        <div>
            <h5>Sales:</h5>
            <ul>
                @foreach($customer->sales as $sale)
                    <li>Sale ID: {{ $sale->id }} - Commission: {{ $sale->commission }} TK</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($customer->transactions->isNotEmpty())
        <div>
            <h5>Transactions:</h5>
            <ul>
                @foreach($customer->transactions as $transaction)
                    <li>
                        Transaction ID: {{ $transaction->id }} -
                        Amount: {{ $transaction->amount }} TK -
                        Type: {{ $transaction->transaction_type }} -
                        Date: {{ $transaction->created_at->format('Y-m-d H:i') }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</li>
