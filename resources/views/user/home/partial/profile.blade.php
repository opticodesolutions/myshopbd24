 <div class="card-body">
     @foreach ($data as $item)
         <div class="d-flex flex-column align-items-center text-center">
             @if ($item->user->profile_picture)
                 <img src="{{ Storage::url($item->user->profile_picture) }}" id="user1.png" class="m-2" alt="icon"
                     style="border-radius:50%" width="120" height="120">
             @else
                 <img src="{{ asset('backend/img/avatars/avatar.jpg') }}" id="user1.png" class="m-2" alt="icon"
                     style="border-radius:50%" width="120" height="120">
             @endif
             <div class="mt-3 mb-3">
                 <h4 class="text-capitalize"> <span id="ContentPlaceHolder1_txtName"
                         class="progress-description">{{ $item->user->name }}</span></h4>
             </div>
         </div>
         @php
             $balance = $Balance_customer;
             $target = -6900;
             $remainingAmount = max(6900, -$balance);
         $progress = $balance < 0 ? min(100, (-$balance / -$target) * 100) : 0; @endphp <ul class="list-group   list-group-flush">
             <li class="list-group-item bg-transparent py-1 ">
                 <p class="m-0">Sponsor</p>
                 <span class="badge bg-success badge-pill ps-4 pe-4">{{ $item->refer_code }}</span>
             </li>
             <li class="list-group-item bg-transparent py-2 ">
                 <p class="m-0">Account Type</p>


                 @if ($balance < 0)
                     <span style="padding-bottom: 5px;"
                         class="pl-4 pr-4 badge bg-secondary badge-pill">Processing</span>
                     <div class="">
                         <label class="form-label">Current Balance:
                             {{ $balance }}</label>
                         <br>
                         <label class="form-label">Completed
                             {{ number_format(100 - $progress, 2) }}%</label>

                         <div class="progress"
                             style=" background-color: #FF5722; color: black; --bs-progress-bar-bg: green; ">
                             <div class="progress-bar" role="progressbar" style="width: {{ 100 - $progress }}%;"
                                 aria-valuenow="{{ 100 - $progress }}" aria-valuemin="0" aria-valuemax="100">
                                 {{ number_format(100 - $progress, 2) }}%
                             </div>
                         </div>
                     </div>
                 @else
                     <span style="padding-bottom: 5px;" class="pl-4 pr-4 badge bg-secondary badge-pill">Customer</span>
                 @endif

             </li>
             <li class="list-group-item bg-transparent py-2 ">
                 <p class="m-0">Mobile No</p>
                 <span
                     class="badge bg-secondary badge-pill ps-4 pe-4">{{ $item->user->phone_number ?? '01968402925' }}</span>
             </li>
             <li class="list-group-item bg-transparent py-1 ">
                 <p class="m-0">E-mail</p>
                 <span class="badge bg-secondary badge-pill ps-4 pe-4">{{ $item->user->email }}</span>
             </li>
             {{-- @php
                                        $startDate = \Carbon\Carbon::parse($item->subscription_start_date);
                                        $endDate = \Carbon\Carbon::parse($item->subscription_end_date);

                                        $diffInMonths = $startDate->diffInMonths($endDate);
                                        $diffInDays = $startDate->diffInDays($endDate->copy()->subMonths($diffInMonths));
                                    @endphp
                                    <li class="list-group-item bg-transparent py-1 ">
                                        <p class="m-0">Membership Duration Remaining</p>
                                            <span class="badge bg-primary badge-pill ps-4 pe-4">{{ $diffInMonths }} months</span>
                                    </li> --}}
             @include('user.home.partial')

             <li class="list-group-item bg-transparent py-1">
                <p class="m-0">Designation</p>
                 <span class="badge bg-secondary badge-pill ps-4 pe-4">{{ $designation }}</span>
             </li>
             <li class="list-group-item bg-transparent py-1">
                <p class="m-0">Total Users</p>
                 <span class="badge bg-secondary badge-pill ps-4 pe-4">{{ $total_users }}</span>
             </li>
         </ul>
     @endforeach
 </div>
