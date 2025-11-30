@extends('homepage.layouts.main')
@section('container')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="/homepage_assets/img/breadcrumb-bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb-text">
                        <h2>Kalkulator BMI</h2>
                        <div class="bt-option">
                            <a href="{{ route('home') }}">Beranda</a>
                            <span>Kalkulator BMI</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- BMI Calculator Section Begin -->
    <section class="bmi-calculator-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-title chart-title">
                        <span>Periksa Tubuh Anda</span>
                        <h2>TABEL KALKULATOR BMI</h2>
                    </div>
                    <div class="chart-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>BMI</th>
                                    <th>Status Berat Badan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="point">Dibawah 18.5</td>
                                    <td>Kurus</td>
                                </tr>
                                <tr>
                                    <td class="point">18.5 - 24.9</td>
                                    <td>Normal / Sehat</td>
                                </tr>
                                <tr>
                                    <td class="point">25.0 - 29.9</td>
                                    <td>Kelebihan Berat Badan</td>
                                </tr>
                                <tr>
                                    <td class="point">30.0 ke atas</td>
                                    <td>Obesitas</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="section-title chart-calculate-title">
                        <span>Periksa Tubuh Anda</span>
                        <h2>HITUNG BMI ANDA</h2>
                    </div>
                    <div class="chart-calculate-form">
                        <p>
                            Gunakan kalkulator ini untuk mengetahui nilai BMI (Body Mass Index) Anda.
                            Masukkan tinggi badan dan berat badan untuk melihat kategori kesehatan tubuh Anda.
                        </p>

                        <form id="bmiForm">
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="number" id="height" placeholder="Tinggi / cm" required>
                                </div>
                                <div class="col-sm-6">
                                    <input type="number" id="weight" placeholder="Berat / kg" required>
                                </div>

                                <div class="col-lg-12 mt-3">
                                    <button type="submit">Hitung BMI</button>
                                </div>

                                <div class="col-lg-12 mt-3">
                                    <h4 id="bmiResult" class="text-white" style="display: none;"></h4>
                                    <p id="bmiStatus" style="font-weight: bold;"></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- BMI Calculator Section End -->
    <!-- Get In Touch Section Begin -->
    <div class="gettouch-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="gt-text">
                        <i class="fa fa-map-marker"></i>
                        <p>Komplek Bundaran Palupi Permai,
                            <br>
                            Jl. I Gusti Ngurah Rai No.5, RW.6,
                            <br>
                            Pengawu, Kec. Tatanga, Kota Palu,
                            <br>
                            Sulawesi Tengah 94222
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="gt-text">
                        <i class="fa fa-mobile"></i>
                        <ul>
                            <li><a href="https://api.whatsapp.com/send?phone=6285185471994&text=Halo%2C%20saya%20ingin%20mendapatkan%20informasi%20mengenai%20membership%20gym.%20Boleh%20diinformasikan%20jenis%20paket%2C%20harga%2C%20dan%20manfaat%20tiap%20paketnya%3F%20Terima%20kasih.
                                    "
                                    target="_blank" style="text-decoration: none" class="text-white">+62
                                    851-8547-1994</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="gt-text email">
                        <i class="fa fa-envelope"></i>
                        <p>
                            <a href="mailto:reyfitnes.cs@gmail.com" style="text-decoration: none"
                                class="text-white">reyfitnes.cs@gmail.com</a>
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Get In Touch Section End -->
@endsection
@section('js')
    <script>
        document.getElementById("bmiForm").addEventListener("submit", function(e) {
            e.preventDefault();

            const height = parseFloat(document.getElementById("height").value);
            const weight = parseFloat(document.getElementById("weight").value);

            if (!height || !weight) {
                alert("Tolong masukkan tinggi dan berat badan.");
                return;
            }

            // Rumus BMI
            const bmi = (weight / Math.pow(height / 100, 2)).toFixed(1);

            let status = "";

            if (bmi < 18.5) status = "Kurus";
            else if (bmi < 25) status = "Normal / Sehat";
            else if (bmi < 30) status = "Kelebihan Berat Badan";
            else status = "Obesitas";

            // Tampilkan hasil
            document.getElementById("bmiResult").style.display = "block";
            document.getElementById("bmiResult").innerHTML = `BMI Anda: <strong>${bmi}</strong>`;
            document.getElementById("bmiStatus").innerHTML =
                `Status: <span style="color:#f36100;">${status}</span>`;
        });
    </script>
@endsection
