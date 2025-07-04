@include('layouts.welcome')

<style>
    body {
        margin: 0;
        padding: 0;
        background-color: #1e2533;
        color: white;
        font-family: 'Segoe UI', sans-serif;
        height: 100vh;
        overflow: hidden;
    }

    .full-screen-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        box-sizing: border-box;
        padding: 20px;
    }

    #reader {
        width: 90vw;
        max-width: 500px;
        height: 90vw;
        max-height: 500px;
        border: 2px solid #fff;
        border-radius: 10px;
        margin: 20px auto;
        overflow: hidden;
        position: relative;
    }
    #reader video {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 10px;
    }

    .top-right {
        position: absolute;
        right: 10px;
        top: 10px;
    }

    #success-message {
        color: #0f0;
        font-size: 20px;
        margin-top: 20px;
        display: none;
    }

    #clock {
        font-size: 60px;
        color: white;
    }

    h1, p {
        margin: 0;
        padding: 5px;
        text-align: center;
    }
</style>

<div class="top-right links color-white">
    @auth
        <a href="{{ url('/admin') }}">Admin</a>
    @else
        <a style="color: white" href="{{ route('login') }}">Login</a>
        @if (Route::has('register'))
            <a href="{{ route('register') }}">Register</a>
        @endif
    @endauth
</div>

<div class="full-screen-container">
    @if (session('success'))
        <div style="background-color: #28a745; color: white; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div style="background-color: #dc3545; color: white; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
            {{ session('error') }}
        </div>
    @endif

    @if (session('info'))
        <div style="background-color: #17a2b8; color: white; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
            {{ session('info') }}
        </div>
    @endif

    <!-- Reloj -->
    <div id="clock"></div>

    <!-- Registro de Asistencia -->
    <h1>Registro de Asistencia</h1>
    <p>Escanea tu código QR para registrar tu asistencia</p>

    <!-- Lector QR -->
    <div id="reader"></div>
</div>

<!-- Audio para sonido al escanear -->
<audio id="scan-sound" src="https://actions.google.com/sounds/v1/alarms/beep_short.ogg" preload="auto"></audio>


<!-- Scripts -->
<script src="https://unpkg.com/html5-qrcode"></script>

<script>
   
    const html5QrCode = new Html5Qrcode("reader");
    const audio = document.getElementById('scan-sound');
    let scanning = true;

    Html5Qrcode.getCameras().then(devices => {
        if (devices && devices.length) {
            html5QrCode.start(
                { facingMode: "environment" },
                {
                    fps: 25, // frames por segundo aumentado para más rapidez
                    qrbox: { width: 400, height: 400 },
                    disableFlip: false
                },
                qrCodeMessage => {
                    if (!scanning) return; // bloquea lecturas repetidas

                    scanning = false; // bloqueo lectura repetida

                    console.log("QR leído:", qrCodeMessage);

                    if (audio.paused) {
                        audio.volume = 0.5;
                        audio.play().catch(e => console.log('Error al reproducir sonido:', e));
                    }

                    html5QrCode.stop().then(() => {
                        // redirige casi inmediato para que se sienta rápido
                        window.location.href = `/attended/${qrCodeMessage}`;
                    }).catch(err => {
                        console.error('Error al detener lector:', err);
                    });
                },
                errorMessage => {
                    // Puedes manejar errores o dejar vacío
                }
            ).catch(err => {
                console.error("Error al iniciar lector QR", err);
            });
        }
    });

    function updateClock() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('en-US', { hour12: true });
        document.getElementById('clock').innerText = timeString;
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>
