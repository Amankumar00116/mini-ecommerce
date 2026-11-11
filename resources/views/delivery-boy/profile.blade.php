@extends('layouts.delivery-boy')

@section('title', 'My Profile')
@section('header', 'My Profile')

@section('content')

<div style="max-width:850px; margin:10px auto;">

    {{-- Profile Details --}}
    <div style="background:white; padding:25px; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.06);">

        <h2 style="margin:0 0 8px; color:#1e293b;">My Profile</h2>
        <p style="color:#64748b; margin-bottom:25px;">
            View and update your personal details.
        </p>

        @if(session('success'))
            <div style="background:#dcfce7; color:#166534; padding:12px; border-radius:6px; margin-bottom:20px;">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div style="background:#fee2e2; color:#991b1b; padding:12px; border-radius:6px; margin-bottom:20px;">
                <ul style="margin:0; padding-left:20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('delivery-boy.profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(230px,1fr)); gap:20px;">

                <div>
                    <label style="display:block; margin-bottom:7px;">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        style="width:100%; padding:11px; border:1px solid #cbd5e1; border-radius:6px;">
                </div>

                <div>
                    <label style="display:block; margin-bottom:7px;">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                        style="width:100%; padding:11px; border:1px solid #cbd5e1; border-radius:6px;">
                </div>

                <div>
                    <label style="display:block; margin-bottom:7px;">Mobile Number</label>
                    <input type="text" name="mobile" value="{{ old('mobile', $user->mobile) }}" maxlength="15"
                        style="width:100%; padding:11px; border:1px solid #cbd5e1; border-radius:6px;">
                </div>

                <div>
                    <label style="display:block; margin-bottom:7px;">City</label>
                    <input type="text" name="city" value="{{ old('city', $user->city) }}"
                        style="width:100%; padding:11px; border:1px solid #cbd5e1; border-radius:6px;">
                </div>

                <div>
                    <label style="display:block; margin-bottom:7px;">State</label>
                    <input type="text" name="state" value="{{ old('state', $user->state) }}"
                        style="width:100%; padding:11px; border:1px solid #cbd5e1; border-radius:6px;">
                </div>

                <div>
                    <label style="display:block; margin-bottom:7px;">Pincode</label>
                    <input type="text" name="pincode" value="{{ old('pincode', $user->pincode) }}" maxlength="10"
                        style="width:100%; padding:11px; border:1px solid #cbd5e1; border-radius:6px;">
                </div>

                <div style="grid-column:1 / -1;">
                    <label style="display:block; margin-bottom:7px;">Full Address</label>
                    <textarea name="address" rows="3"
                        style="width:100%; padding:11px; border:1px solid #cbd5e1; border-radius:6px; resize:vertical;">{{ old('address', $user->address) }}</textarea>
                </div>

            </div>

            <div style="margin-top:25px;">
                <button type="submit"
                    style="background:#1677ff; color:white; border:none; padding:12px 24px; border-radius:6px; cursor:pointer;">
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    {{-- Change Password --}}
    <div style="background:white; padding:25px; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.06); margin-top:25px;">

        <h2 style="margin:0 0 8px; color:#1e293b;">Change Password</h2>
        <p style="color:#64748b; margin-bottom:25px;">
            Update your password to keep your account secure.
        </p>

        @if(session('password_success'))
            <div style="background:#dcfce7; color:#166534; padding:12px; border-radius:6px; margin-bottom:20px;">
                {{ session('password_success') }}
            </div>
        @endif

        @if($errors->has('current_password') || $errors->has('password'))
            <div style="background:#fee2e2; color:#991b1b; padding:12px; border-radius:6px; margin-bottom:20px;">
                @if($errors->has('current_password'))
                    <p style="margin:0 0 5px;">{{ $errors->first('current_password') }}</p>
                @endif
                @if($errors->has('password'))
                    <p style="margin:0;">{{ $errors->first('password') }}</p>
                @endif
            </div>
        @endif

        <form action="{{ route('delivery-boy.password.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div style="margin-bottom:18px;">
                <label style="display:block; margin-bottom:7px;">Current Password</label>
                <input type="password" name="current_password" required autocomplete="current-password"
                    style="width:100%; max-width:500px; padding:11px; border:1px solid #cbd5e1; border-radius:6px;">
            </div>

            <div style="margin-bottom:18px;">
                <label style="display:block; margin-bottom:7px;">New Password</label>
                <input type="password" name="password" required minlength="8" autocomplete="new-password"
                    style="width:100%; max-width:500px; padding:11px; border:1px solid #cbd5e1; border-radius:6px;">
            </div>

            <div style="margin-bottom:22px;">
                <label style="display:block; margin-bottom:7px;">Confirm New Password</label>
                <input type="password" name="password_confirmation" required minlength="8" autocomplete="new-password"
                    style="width:100%; max-width:500px; padding:11px; border:1px solid #cbd5e1; border-radius:6px;">
            </div>

            <button type="submit"
                style="background:#1677ff; color:white; border:none; padding:12px 24px; border-radius:6px; cursor:pointer;">
                Change Password
            </button>
        </form>
    </div>

</div>

@endsection
