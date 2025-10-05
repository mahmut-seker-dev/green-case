<form id="customerForm" action="{{ $action }}" method="POST">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
        <input type="hidden" id="customer_id" value="{{ $customer->id ?? '' }}">
    @endif

    @if (isset($customer))
        <div class="mb-3">
            <label class="form-label">Kod</label>
            <input type="text" value="{{ $customer->code }}" class="form-control" disabled>
        </div>
    @endif

    <div class="mb-3">
        <label class="form-label">İsim</label>
        <input type="text" name="name" value="{{ $customer->name ?? '' }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" value="{{ $customer->email ?? '' }}" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Telefon</label>
        <input type="text" name="phone" value="{{ $customer->phone ?? '' }}" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Adres</label>
        <textarea name="address" class="form-control" rows="3">{{ $customer->address ?? '' }}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">
        {{ $method === 'PUT' ? 'Güncelle' : 'Kaydet' }}
    </button>
    <a href="{{ route('customers.index') }}" class="btn btn-secondary">Geri Dön</a>
</form>

