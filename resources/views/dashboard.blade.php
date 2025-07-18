<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard PraGRSI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet"  type='text/css'>
    <link href="https://fonts.googleapis.com/css2?family=Tenor+Sans&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
            font-family: 'Tenor Sans', sans-serif !important;
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

        .img-bg {
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
            width: 60%;
            margin-top: auto;
            margin-bottom: auto;
        }

        .content-2 {
            position: relative;
            text-align: center;
            top: 30%;
            width: 40%
        }

        .container {
            display: flex;
            justify-content: space-around;     /* center horizontally */
            align-items: center;         /* center vertically */
            height: 50vh;               /* full height of screen */
            gap: 30px;                   /* space between columns */
            padding: 20px;
            box-sizing: border-box;
        }

        .countdown, .stock-info {
            font-size: 2.5rem;
            margin-top: 1rem;
        }

        .highlight {
            font-size: 3rem;
            color: #ffeb3b;
        }
    </style>
</head>
<body>

    <img class="img-bg" src="{{asset('assets/images/background.jpg')}}" alt="background" >

    {{-- <div class="overlay"></div> --}}

    <div class="container">
        <div class="content">
            <h1>🔥 <i> FLASH ORDER </i> PRA GRSI</h1>
            <h1 style="margin-top: 1rem; color: #BCAA97;">{{ $produk->nama_produk }}</h1>
            <div class="countdown">
                Waktu tersisa: <span id="timer" class="highlight">--:--</span>
            </div>

            <div class="stock-info">
                Stock Tersedia: <span id="stock" class="highlight" >0</span>
            </div>
        </div>

        <div class="content-2">
            <table class="table table-dark">
                <thead>
                    <tr>
                        <th>No</th>
                        <th style="width: 150px">Nama Agen</th>
                        <th style="width: 150px">Total Order</th>
                    </tr>
                </thead>
                <tbody id="order-body">
                    {{-- Data order akan diisi melalui JavaScript --}}
                    @foreach ($order_per_produk_by_agen as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->agen }}</td>
                            <td>{{ $item->total_order }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="2" class="text-end"><strong>Total Order:</strong></td>
                        <td><strong>{{ $order_per_produk_by_agen->sum('total_order') }}</strong></td>
                    </tr>
                </tbody>
            </table>
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

        function animateCount(id, start, end, duration = 2000) {
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
        let lastStock = null; // menyimpan stok terakhir yang ditampilkan
        let stokAwal = null;

        setInterval(() => {
            fetch(`/api/auction/sold-count/${produkId}`)
                .then(res => res.json())
                .then(data => {
                    stokAwal = Number(data.stok_awal);
                    lastStock = Number(data.stok); // nilai pertama yang ditampilkan

                    // Tampilkan stok awal ke tampilan
                    document.getElementById('stock').innerText = lastStock;

                    if (stokBaru !== lastStock) {
                        animateCount('stock', lastStock, stokBaru);
                        lastStock = stokBaru; // update nilai cache
                    }
                });
        }, 2000);

        function fetchOrderData() {
            $.get(`/dashboard/order-lelang/${produkId}`, function(data) {
                let rows = '';
                let total = 0;

                data.forEach((item, index) => {
                    total += parseInt(item.total_order);
                    rows += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.agen}</td>
                            <td>${item.total_order}</td>
                        </tr>
                    `;
                });

                rows += `
                    <tr>
                        <td colspan="2" class="text-end"><strong>Total Order:</strong></td>
                        <td><strong>${total}</strong></td>
                    </tr>
                `;

                $('#order-body').html(rows);
            });
        }

        // Panggil pertama kali
        fetchOrderData();

        // Ulangi setiap 5 detik
        setInterval(fetchOrderData, 3000);
    </script>

</body>
</html>
