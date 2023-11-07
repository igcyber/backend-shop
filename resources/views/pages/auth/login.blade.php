@extends('layouts.auth')

@section('title', 'Login')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-social/bootstrap-social.css') }}">
@endpush

@section('main')
    <div class="card card-primary" style="border-top: 4px solid #008829; !important">
        <div class="card-header d-block">
            <h3 class="text-center" style="color: #008829;">SIGAP</h3>
            <h4 class="text-center" style="color: #008829;">PT. Upindo Raya Semesta Borneo</h4>
        </div>
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success mt-2">
                    {{ session('status') }}
                </div>
            @endif
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <div class="d-block">
                        <label for="password" class="control-label text-default">USERNAME</label>
                    </div>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <img
                                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABkAAAAZCAYAAADE6YVjAAAACXBIWXMAAAsTAAALEwEAmpwYAAAA6ElEQVR4nO2SsQ4BQRRFDz2JipZexV8IFVHiC6yG7Ga/QIJ/UGr1fAo9CZWtGJlkJJsJu5OdaYSb3LzMTOaezLwHv6gKMARmqpZdhucAH4gAEXOkgPLcWr4WLjRPXXyR/gKh+Wb7daMUgFAe2EBCQ0hoAwkMIYENpG8I6dlAisA5BXACCjaQ12vuHwByv4sjtYGjBjgALRwrDzSBjqpy/b0qADUXjY5LBk6APXDVenIBdoAHVLOE14F1wlQJzQ9gCzRMwmUzF+qSSbh4A5unDYWXMVxoHidBVo4gyyRISYE2Fl6pnL/IpCcW0amIN98JjgAAAABJRU5ErkJggg==">
                            </div>
                        </div>
                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror"
                            name="username" tabindex="1" autofocus value="{{ old('username') }}">
                        @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <div class="d-block">
                        <label for="password" class="control-label">PASSWORD</label>
                        <div class="float-right">
                            <a href="{{ route('password.request') }}" class="text-small">
                                Lupa Password
                            </a>
                        </div>
                    </div>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <img id="toggle-icon" onclick="togglePassword()"
                                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABkAAAAZCAYAAADE6YVjAAAACXBIWXMAAAsTAAALEwEAmpwYAAACS0lEQVR4nO1VO2hUURBdG1FLQXD13XPmzrxVWMFGQUwj/gq/hKgRvxEVDDEoiCAiLCgWSnpbxUZrO8VKsPSDlagRbET84ydGDSLzdldW2bd5KRabTPPefczMmXPuzLxSadr+p6WIexW83jUAg+xT8Ic/pxQYY1xq5Fmj3FbKMwVf+9PIWwo5XxFZkQEE6Vfwu4oMFM09Q8k+Ix8pON5IeCoCeyLiOiN7/azgTaNMGPjCGRQGsMRSpdw1yjuF1JIkmdvJX4McUXBCRWqFAJTcpeRng1xL03TeZP4p4g5n2mSwCIgGvjJydXsG5Gklf2qQ4zkF9CnkgVHGlHJPGUdaAf7kAY4a5FsKHPoX4IwzSEPckg/AT4Y4rEGXp+AVo/zyhO38I+Jm91dysJlgt3dFDHF9niwZA8ThhkTbmwzK5fKcvJhUZJVRviqwqaSUUSVH8pzrTGXMGURgWxOgAqh3FMlZ+XGukIz6S28mBbmyA5P7BlxuvQOFHDPwSS4ToKqUt95M9STkoIEfDehpFxDJi34HSh7QhVpxgKwLg/S3ZQAsM8pLn6W/qxUZcEaRPNjm0scjOZQkyWyjvHdm/r0tQJCtjTE4mSML1mZDSF4lOb8JUGSSk6wAXjDIBxPZ2dF5cQgLlLyh4Jciu6harc40xMNKeW7kHW+IyQqqMyI3NnbWOT8beSIlhxRY43r7/nJZnbGSbwx86DIVSt4A2JC1bAsD1zdbhuBjXxtKPm0szZqFsKQ0FfNJ9ZVgQfaXumUGueR/tq4BTFupgP0GTJSuIaQkgNUAAAAASUVORK5CYII=">
                            </div>
                        </div>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" tabindex="2" value="{{ old('password') }}">
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-lg btn-block" tabindex="4">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script>
        function togglePassword() {
            var passwordInput = document.getElementById('password');
            var toggleIcon = document.getElementById('toggle-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.src =
                    'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABkAAAAZCAYAAADE6YVjAAAACXBIWXMAAAsTAAALEwEAmpwYAAABlElEQVR4nO3VO2uUQRTG8Z8aRWtvjXFtzH4C08UyJHYisdBgraidioilCQiClbixNZbxWlpqgigpRRRvhU0QVPQLyIRnC5d3lqypAvk3wzlzznnnXGZeNtmobEUbR3Es60j062IHTuIxfmEFb/A860r0jzAV+4GYxhcs4SwOVOyGcQ6v8Bmn1xJ8L57hLcYHPNh4/J5iT83oED7gDnY27LcxiweYSU962YW7eI9W7+Z+fMWVygHO4E8CXEQncilrE1dT7n1dxVBqf7Pi0E7AIz360eibMircwsvEdzlCbRxnk0ETc7jRuMM2LOJSEb5hQp15XKjsldLd7+M7kfirmSz2yWQmPfifTJa6mQzlI6WG/Xoy2qMv8m8crvjdxotuT2QKyjRcqzhM50OdlGgu8qmK/fVcznLv/qGV+e5k3nsZSWnmszZlUPzu4R0OVg6welOfxGjSYEzGr7x1u9fiUN6gT3iN8023N7QyeeXB/NinfFW24wQe4ie+Yzmv8HLkH1jA8diviy3pwVj+J2ORi36TDchfeq1U7UHX4ukAAAAASUVORK5CYII='; // Open eye icon
            } else {
                passwordInput.type = 'password';
                toggleIcon.src =
                    'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABkAAAAZCAYAAADE6YVjAAAACXBIWXMAAAsTAAALEwEAmpwYAAACS0lEQVR4nO1VO2hUURBdG1FLQXD13XPmzrxVWMFGQUwj/gq/hKgRvxEVDDEoiCAiLCgWSnpbxUZrO8VKsPSDlagRbET84ydGDSLzdldW2bd5KRabTPPefczMmXPuzLxSadr+p6WIexW83jUAg+xT8Ic/pxQYY1xq5Fmj3FbKMwVf+9PIWwo5XxFZkQEE6Vfwu4oMFM09Q8k+Ix8pON5IeCoCeyLiOiN7/azgTaNMGPjCGRQGsMRSpdw1yjuF1JIkmdvJX4McUXBCRWqFAJTcpeRng1xL03TeZP4p4g5n2mSwCIgGvjJydXsG5Gklf2qQ4zkF9CnkgVHGlHJPGUdaAf7kAY4a5FsKHPoX4IwzSEPckg/AT4Y4rEGXp+AVo/zyhO38I+Jm91dysJlgt3dFDHF9niwZA8ThhkTbmwzK5fKcvJhUZJVRviqwqaSUUSVH8pzrTGXMGURgWxOgAqh3FMlZ+XGukIz6S28mBbmyA5P7BlxuvQOFHDPwSS4ToKqUt95M9STkoIEfDehpFxDJi34HSh7QhVpxgKwLg/S3ZQAsM8pLn6W/qxUZcEaRPNjm0scjOZQkyWyjvHdm/r0tQJCtjTE4mSML1mZDSF4lOb8JUGSSk6wAXjDIBxPZ2dF5cQgLlLyh4Jciu6harc40xMNKeW7kHW+IyQqqMyI3NnbWOT8beSIlhxRY43r7/nJZnbGSbwx86DIVSt4A2JC1bAsD1zdbhuBjXxtKPm0szZqFsKQ0FfNJ9ZVgQfaXumUGueR/tq4BTFupgP0GTJSuIaQkgNUAAAAASUVORK5CYII='; // Closed eye icon
            }
        }
    </script>
    <!-- Page Specific JS File -->
@endpush
