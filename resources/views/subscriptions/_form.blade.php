<div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input type="text" class="form-control" id="name" name="name" value="{{ $subscription->name ?? old('name') }}" required>
</div>
<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea class="form-control" id="description" name="description">{{ $subscription->description ?? old('description') }}</textarea>
</div>
<div class="mb-3">
    <label for="amount" class="form-label">Amount</label>
    <input type="number" step="0.01" class="form-control" id="amount" name="amount" value="{{ $subscription->amount ?? old('amount') }}" required>
</div>
<div class="mb-3">
    <label for="per_person" class="form-label">Per Person</label>
    <input type="number" step="0.01" class="form-control" id="per_person" name="per_person" value="{{ $subscription->per_person ?? old('per_person') }}">
</div>
<div class="mb-3">
    <label for="lavel" class="form-label">Level</label>
    <input type="number" class="form-control" id="lavel" name="lavel" value="{{ $subscription->lavel ?? old('lavel') }}">
</div>
<div class="mb-3">
    <label for="ref_income" class="form-label">Ref Income</label>
    <input type="number" step="0.01" class="form-control" id="ref_income" name="ref_income" value="{{ $subscription->ref_income ?? old('ref_income') }}" required>
</div>
<div class="mb-3">
    <label for="insective_income" class="form-label">Insective Income</label>
    <input type="number" step="0.01" class="form-control" id="insective_income" name="insective_income" value="{{ $subscription->insective_income ?? old('insective_income') }}" required>
</div>
<div class="mb-3">
    <label for="daily_bonus" class="form-label">Daily Bonus</label>
    <input type="number" step="0.01" class="form-control" id="daily_bonus" name="daily_bonus" value="{{ $subscription->daily_bonus ?? old('daily_bonus') }}" required>
</div>
<div class="mb-3">
    <label for="admin_profit_salary" class="form-label">Admin Profit Salary</label>
    <input type="number" step="0.01" class="form-control" id="admin_profit_salary" name="admin_profit_salary" value="{{ $subscription->admin_profit_salary ?? old('admin_profit_salary') }}" required>
</div>
<div class="mb-3">
    <label for="admin_profit" class="form-label">Admin Profit</label>
    <input type="number" step="0.01" class="form-control" id="admin_profit" name="admin_profit" value="{{ $subscription->admin_profit ?? old('admin_profit') }}" required>
</div>

<div class="mb-3">
    <label for="Image" class="form-label">Image</label>
    <input type="file" class="form-control" id="image" name="image">
     @if (isset($subscription) && $subscription->image)
        <img src="{{ asset('storage/' . $subscription->image) }}" alt="Subscription Image" class="img-thumbnail mt-2" style="max-width: 150px;">
    @endif
    @error('image')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>