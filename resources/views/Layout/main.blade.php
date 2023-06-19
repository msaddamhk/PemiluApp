<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Voters APP</title>

    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }} " type="text/css" media="screen" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css" />

    <link href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>

<body>
    <nav class="sidebar offcanvas-md offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false">
        <div class="d-flex justify-content-end m-3 d-block d-md-none">
            <button aria-label="Close" data-bs-dismiss="offcanvas" data-bs-target=".sidebar"
                class="btn p-0 border-0 fs-4">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="d-flex justify-content-center mt-md-5 mb-2">
            <h2 class="text-black">Voters APP</h2>
        </div>
        <div class="pt-2 d-flex flex-column gap-5">
            <div class="menu p-0">
                <p>Daily Use</p>

                @if (Gate::any(['isGeneral']))
                    ;
                    <a href="{{ route('dashboard.general.index') }}"
                        class="item-menu {{ Request::is('/*') ? 'active' : '' }}">
                        <i class="icon ic-stats"></i>
                        Dashboard
                    </a>
                @endif

                @if (Gate::any(['isKoorKota']))
                    ;
                    <a href="{{ route('dashboard.kota.index') }}"
                        class="item-menu {{ Request::is('dashboard-kota*') ? 'active' : '' }}">
                        <i class="icon ic-stats"></i>
                        Dashboard
                    </a>
                @endif

                @if (Gate::any(['isKoorKota', 'isGeneral']))
                    <a href="{{ route('kota.index') }}" class="item-menu {{ Request::is('kabkota*') ? 'active' : '' }}">
                        <i class="icon ic-city"></i>
                        Kelola Data
                    </a>
                    <a href="{{ route('users.index') }}"
                        class="item-menu {{ Request::is('data-admin*') ? 'active' : '' }}">
                        <i class="icon ic-user"></i>
                        Kelola Pengguna
                    </a>
                @endif

                @if (Gate::allows('isKoorKecamatan'))
                    <a href="{{ route('dashboard.kecamatan.index') }}"
                        class="item-menu {{ Request::is('koor/dashboard-kecamatan*') ? 'active' : '' }}">
                        <i class="icon ic-stats"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('koor.kecamatan.index') }}"
                        class="item-menu  {{ Request::routeis('koor*') ? 'active' : '' }}">
                        <i class="icon ic-city"></i>
                        Kelola Data
                    </a>
                    <a href="{{ route('users.index') }}"
                        class="item-menu {{ Request::is('data-admin*') ? 'active' : '' }}">
                        <i class="icon ic-user"></i>
                        Kelola Pengguna
                    </a>
                @endif

                @if (Gate::allows('isKoorDesa'))
                    <a href="{{ route('koor.desa.index') }}"
                        class="item-menu {{ Request::routeis('koor*') ? 'active' : '' }}">
                        <i class="icon ic-city"></i>
                        Kelola Data
                    </a>
                    <a href="{{ route('users.index') }}"
                        class="item-menu {{ Request::is('data-admin*') ? 'active' : '' }}">
                        <i class="icon ic-user"></i>
                        Kelola Pengguna
                    </a>
                @endif

                @if (Gate::allows('isKoorTps'))
                    <a href="{{ route('koor.tps.index') }}"
                        class="item-menu {{ Request::routeis('koor*') ? 'active' : '' }}">
                        <i class="icon ic-city"></i>
                        Kelola Data
                    </a>
                @endif
            </div>

            <div class="menu">
                <p>Others</p>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="">
                    @csrf
                    <button class="item-menu bg-transparent border-0"
                        onclick="return confirm('Apakah Anda yakin ingin keluar?')">
                        <i class="icon ic-logout"></i>
                        Logout
                    </button>
                </form>
            </div>

        </div>
    </nav>

    <main class="content">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <div class="d-flex align-items-center justify-content-end gap-3">
                    <i class="bi bi-arrow-left" onclick="window.history.back()"></i>

                    <button class="sidebarCollapseDefault bg-transparent p-0 border-0 d-none d-md-block"
                        aria-label="Hamburger Button">
                        <i class="bi bi-list"></i>
                    </button>

                    <button data-bs-toggle="offcanvas" data-bs-target=".sidebar" aria-controls="sidebar"
                        aria-label="Hamburger Button" class="sidebarCollapseMobile btn p-0 border-0 d-block d-md-none">
                        <i class="bi bi-list fw-1"></i>
                    </button>

                </div>
                <div class="d-flex align-items-center gap-3">

                    <div style="text-align: end">
                        <p class="fw-semibold m-0 text-end p-0" style="font-size: 12px">{{ auth()->user()->name }}</p>
                        <small class="m-0 text-end" style="font-size: 11px">{{ auth()->user()->level }}</small>
                    </div>

                    <a href="{{ route('users.edit', auth()->user()->id) }}">
                        <img src="{{ asset('storage/img/users/' . auth()->user()->photo) }}" alt="Photo Profile"
                            class="avatar" />
                    </a>

                    <i class="bi bi-fullscreen d-none d-md-block" id="myButton" style="cursor: pointer"></i>

                </div>
            </div>
        </nav>

        @yield('content')
    </main>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

    <script src="{{ asset('assets/js/custom.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    <script>
        document.querySelector('form.needs-validation').addEventListener('submit', function(event) {
            if (!event.target.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            event.target.classList.add('was-validated');
            if (!event.target.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
        }, false);
    </script>

    @stack('scripts')

    <script>
        const choices = new Choices('#user', {
            searchEnabled: true,
            searchChoices: true,
            placeholder: true,
            placeholderValue: 'Pilih pengelola',
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>
</body>

</html>
