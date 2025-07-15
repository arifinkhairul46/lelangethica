<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Pre-Order</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
            font-family: 'Segoe UI', sans-serif;
            color: white;
        }

        .video-bg {
            position: fixed;
            top: 0; left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        .overlay {
            position: absolute;
            top: 0; left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
        }

        .content {
            position: relative;
            text-align: center;
            top: 30%;
        }

        .countdown, .stock-info {
            font-size: 2.5rem;
            margin-top: 1rem;
        }

        .highlight {
            font-size: 4rem;
            color: #ffeb3b;
        }
    </style>
</head>
<body>

    <video autoplay muted loop class="video-bg">
        <source src="/videos/background.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <div class="overlay"></div>

    <div class="content">
        <h1>🔥 <i> FLASH ORDER </i> PRA GRSI</h1>
        <div class="countdown">
            Waktu tersisa: <span id="timer" class="highlight">--:--</span>
        </div>

        <div class="stock-info">
            Terjual: <span id="sold" class="highlight" >0</span>
        </div>
    </div>

    <script>
        // Set deadline lelang (YYYY-MM-DD HH:MM:SS)
        const deadline = '{{$produk->datetime_end}}';
        const timerEl = document.getElementById('timer');
        const soldEl = document.getElementById('sold');

        let currentSold = 0;

        // Update countdown every second
        const countdownInterval = setInterval(() => {
            const now = new Date().getTime();
            const end = new Date(deadline).getTime();
            const distance = end - now;

            if (distance < 0) {
                clearInterval(countdownInterval);
                timerEl.innerText = "Lelang Selesai";
                return;
            }

            // Calculate days, hours, minutes, seconds
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            timerEl.innerText = `${hours}h ${minutes}m ${seconds}s`;
        }, 1000);

        function animateCount(id, start, end, duration = 1000) {
            let range = end - start;
            let current = start;
            let increment = end > start ? 1 : -1;
            let stepTime = Math.abs(Math.floor(duration / range));

            const obj = document.getElementById(id);
            const timer = setInterval(() => {
                current += increment;
                obj.innerText = current;
                if (current === end) clearInterval(timer);
            }, stepTime);
        }

        // Simulasi real-time penjualan (ganti dengan polling atau socket)
        const produkId = {{$produk->id}}; // id produk lelang
        let lastSold = 0;
        setInterval(() => {
            fetch(`/api/auction/sold-count/${produkId}`)
                .then(res => res.json())
                .then(data => {
                    // soldEl.innerText = data.sold;
                    const newSold = Number(data.sold) ;
                    if (newSold !== lastSold) {
                        animateCount('sold', lastSold, newSold);
                        lastSold = newSold;
                    }
                });
        }, 2000);
    </script>

</body>
</html>
