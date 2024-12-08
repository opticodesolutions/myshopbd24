
<li>
    <a href="#">
        <img style="height: 30px" src="https://happyproductsltd.com/image/user/profile.png" alt="User Profile">
        <div>
            <strong>User ID:</strong> {{ $node['id'] }}<br>
            <strong>Refer Code:</strong> {{ $node['refer_code'] }}<br>
            <strong>Referred By:</strong> {{ $node['refer_by'] }}<br>
            <strong>Wallet Balance:</strong> ${{ number_format($node['wallet_balance'], 2) }}<br>
            <strong>Generation:</strong> {{ $node['generation'] }}
        </div>
    </a>
    @if (!empty($node['children']))
        <ul>
            @foreach ($node['children'] as $child)
                @include('tree_node', ['node' => $child])
            @endforeach
        </ul>
    @endif
</li>
