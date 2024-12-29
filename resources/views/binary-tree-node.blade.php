@if ($tree && $tree['level'] <= 12)
    <li>
        <div class="node">
            <img src="{{ $tree['customer']->user->profile_picture ? Storage::url($tree['customer']->user->profile_picture) : asset('backend/img/avatars/avatar.jpg') }}" height="50px" width="50px" alt="" srcset=""><br>
            Name: {{ $tree['customer']->user->name ?? ' ' }}<br>
            Level: {{ $tree['level'] }}<br>
            RC: {{ $tree['customer']->refer_code ?? 'Available' }}<br>
            RB: {{ $tree['customer']->refer_by ?? 'Available' }}
        </div>
        <ul class="{{ $tree['level'] < 12 ? 'level-valid' : 'level-invalid' }}">
            {{-- Render Left Child --}}
            @if ($tree['left'])
                @include('binary-tree-node', ['tree' => $tree['left']])
            @elseif ($tree['level'] < 12)
                <li>
                    <div class="node empty">Available</div>
                </li>
            @endif

            {{-- Render Right Child --}}
            @if ($tree['right'])
                @include('binary-tree-node', ['tree' => $tree['right']])
            @elseif ($tree['level'] < 12)
                <li>
                    <div class="node empty">Available</div>
                </li>
            @endif
        </ul>
    </li>
@endif
