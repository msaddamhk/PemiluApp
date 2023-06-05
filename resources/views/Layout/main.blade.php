<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="description" content="Menarra Finance Dashboard Page" />
    <meta name="keywords" content="HTML, CSS, JavaScript, Bootstrap, Chart JS" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Pemilu App</title>

    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous" />

    <!-- External CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }} " type="text/css" media="screen" />

    <!-- CDN Fontawesome -->
    <script src=" {{ asset('https://kit.fontawesome.com/32f82e1dca.js') }}" crossorigin="anonymous"></script>
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
                <i class="fas fa-close"></i>
            </button>
        </div>
        <div class="d-flex justify-content-center mt-md-5 mb-2">
            <h2 class="text-black">Voters APP</h2>
        </div>
        <div class="pt-2 d-flex flex-column gap-5">
            <div class="menu p-0">
                <p>Daily Use</p>

                @if (Gate::any(['isKoorKota', 'isGeneral']))
                    ;
                    <a href="{{ route('dashboard.general.index') }}" class="item-menu activ">
                        <i class="icon ic-stats"></i>
                        Dashboard
                    </a>
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
                    <a href="{{ route('dashboard.kecamatan.index') }}" class="item-menu activ">
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
                    <a href="{{ route('dashboard.tps.index') }}" class="item-menu">
                        <i class="icon ic-stats"></i>
                        Dashboard
                    </a>
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
                    <button class="item-menu bg-transparent border-0">
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
                        <i class="fa-solid fa-bars"></i>
                    </button>

                    <button data-bs-toggle="offcanvas" data-bs-target=".sidebar" aria-controls="sidebar"
                        aria-label="Hamburger Button" class="sidebarCollapseMobile btn p-0 border-0 d-block d-md-none">
                        <i class="fa-solid fa-bars"></i>
                    </button>

                </div>
                <div class="d-flex align-items-center justify-content-end gap-4">

                    <small class="fw-semibold">Admin</small>

                    <a href="{{ route('users.edit', auth()->user()->id) }}">
                        <img src="{{ asset('storage/img/users/' . auth()->user()->photo) }}" alt="Photo Profile"
                            class="avatar" />
                    </a>


                    <i class="bi bi-fullscreen" id="myButton"></i>

                </div>
            </div>
        </nav>

        @yield('content')
    </main>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
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

    <script type="text/javascript">
        var countDownDate = new Date("May 14, 2024 23:10:00").getTime();
        var x = setInterval(function() {
            var now = new Date().getTime();
            var distance = countDownDate - now;
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            document.getElementById("countingDown").innerHTML = days + " Hari " + hours +
                " Jam " + minutes + " Menit " + seconds + " Detik";
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("countingDown").innerHTML = "Daftar Sekarang";
            }
        }, 1000);
    </script>
</body>

</html>
