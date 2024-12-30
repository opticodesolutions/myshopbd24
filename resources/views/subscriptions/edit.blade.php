@extends('layout.app')

@section('content')
    <main class="content">
        <div class="container card p-3">
            <h1>Edit Subscription</h1>
            <form method="POST" action="{{ route('subscriptions.update', $subscription->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('subscriptions._form', ['subscription' => $subscription])
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </main>
@endsection
