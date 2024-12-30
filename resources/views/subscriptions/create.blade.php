@extends('layout.app')

@section('content')
<main class="content">
    <div class="container card p-3">
    <h1>Add New Subscription</h1>
    <form method="POST" action="{{ route('subscriptions.store') }}" enctype="multipart/form-data">
        @csrf
        @include('subscriptions._form')
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
</main>
@endsection
