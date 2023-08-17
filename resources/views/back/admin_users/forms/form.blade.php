<div class="row">
    <div class="col-md-6">
        @csrf
        <input type="hidden" name="id" value="{{ old('id', $user->id) }}" />

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                class="form-control @error('name') is-invalid @enderror" />
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" value="{{ old('email', $user->email) }}"
                class="form-control @error('email') is-invalid @enderror" />
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" value=""
                class="form-control @error('password') is-invalid @enderror" />
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>