
<li>
    <a href="#">
        <img style="height: 30px" src="{{ $node['profile_image'] ? Storage::url($node['profile_image']) : asset('backend/img/avatars/avatar.jpg') }}" alt="User Profile">
        <div>
            <strong>User ID:</strong> {{ $node['user_id'] }}<br>
            <strong>Refer Code:</strong> {{ $node['refer_code'] }}<br>
            <strong>Referred By:</strong> {{ $node['refer_by'] }}<br>
            <strong>Wallet Balance:</strong>৳ {{ number_format($node['wallet_balance'], 2) }}<br>
            <strong>Generation:</strong> {{ $node['generation'] }}<br>
            <strong>Position Parent:</strong> {{ $node['position_parent'] }}<br>
            <strong>Position:</strong> {{ $node['position'] }}
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
