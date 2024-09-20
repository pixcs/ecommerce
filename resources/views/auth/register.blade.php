@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                    
                        <!-- Existing fields... -->
                    
                        <div class="form-group row">
                            <label for="phone_number" class="col-md-4 col-form-label text-md-right">{{ __('Phone Number') }}</label>
                    
                            <div class="col-md-6">
                                <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}" required autocomplete="phone_number">
                    
                                @error('phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    
                        <div class="form-group row">
                            <label for="complete_address" class="col-md-4 col-form-label text-md-right">{{ __('Complete Address') }}</label>
                    
                            <div class="col-md-6">
                                <input id="complete_address" type="text" class="form-control @error('complete_address') is-invalid @enderror" name="complete_address" value="{{ old('complete_address') }}" required autocomplete="complete_address">
                    
                                @error('complete_address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    
                        <div class="form-group row">
                            <label for="e_wallet" class="col-md-4 col-form-label text-md-right">{{ __('E-Wallet') }}</label>
                    
                            <div class="col-md-6">
                                <input id="e_wallet" type="number" class="form-control @error('e_wallet') is-invalid @enderror" name="e_wallet" value="{{ old('e_wallet') }}" required autocomplete="e_wallet">
                    
                                @error('e_wallet')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    
                        <!-- Submit button... -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


<div class="form-group row mb-0">
    <div class="col-md-6 offset-md-4">
        <button type="submit" class="btn btn-primary">
            {{ __('Register') }}
        </button>
    </div>
</div>