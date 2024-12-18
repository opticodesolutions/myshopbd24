  <div class="card-body">
      <div class="d-flex flex-column align-items-center text-center">
          <img src="{{ asset('join.png') }}" class="m-2" alt="icon" style="border-radius:50%" width="120"
              height="120">

          <div class="mt-3 mb-3">
              <h4 class="text-capitalize">Latest Joining</h4>
          </div>
      </div>
      <marquee direction="up" onmouseover="this.stop()" onmouseout="this.start()">
          <ul class="list-group   list-group-flush">
              @foreach ($latest_users as $item)
                  <li class="list-group-item bg-transparent ">
                      <p class="m-0">{{ $item->user->name }}</p>
                      <span class="badge bg-primary badge-pill ps-4 pe-4">{{ $item->user_id }}</span>
                  </li>
              @endforeach
          </ul>
      </marquee>
  </div>
