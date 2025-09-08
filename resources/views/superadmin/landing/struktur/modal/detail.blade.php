@foreach ($struktur as $item)
    <div class="modal fade" id="detail{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="kirimLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kirimLabel">Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container pb-5">
                        <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s">
                            <h4 class="text-dark"><strong>{{ $item->tag ?? '-' }}</strong></h4>
                            <h1 class="display-5 mb-4">{{ $item->judul ?? '-' }}</h1>
                            <p class="mb-0">
                                {{ $item->kalimat ?? '-' }}
                            </p>
                        </div>
                        <div class="text-center">
                            <img src="{{ asset('landing/img/logo.png') }}" alt="Logo NU CARE-LAZISNU" width="50%"
                                height="auto">
                            <p class="mb-0 mt-2">
                                <strong>Nomor:</strong> {{ $item->nomor ?? '-' }}<br>
                                <strong>Tanggal:</strong>
                                @php
                                    $hijri = \Alkoumi\LaravelHijriDate\Hijri::Date('l, d F Y', $item->tanggal);

                                    $hariArab = [
                                        'الأحد',
                                        'الإثنين',
                                        'الثلاثاء',
                                        'الأربعاء',
                                        'الخميس',
                                        'الجمعة',
                                        'السبت',
                                    ];
                                    $hariIndo = ['Ahad', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

                                    $bulanArab = [
                                        'محرم',
                                        'صفر',
                                        'ربيع الأول',
                                        'ربيع الثاني',
                                        'جمادى الأولى',
                                        'جمادى الآخرة',
                                        'رجب',
                                        'شعبان',
                                        'رمضان',
                                        'شوال',
                                        'ذو القعدة',
                                        'ذو الحجة',
                                    ];
                                    $bulanIndo = [
                                        'Muharram',
                                        'Shafar',
                                        'Rabiul Awal',
                                        'Rabiul Akhir',
                                        'Jumadil Awal',
                                        'Jumadil Akhir',
                                        'Rajab',
                                        'Sya`ban',
                                        'Ramadhan',
                                        'Syawal',
                                        'Dzulqa`dah',
                                        'Dzulhijjah',
                                    ];

                                    foreach ($hariArab as $key => $hari) {
                                        $hijri = str_replace($hari, $hariIndo[$key], $hijri);
                                    }

                                    foreach ($bulanArab as $key => $bulan) {
                                        $hijri = str_replace($bulan, $bulanIndo[$key], $hijri);
                                    }
                                @endphp

                                {{ $hijri }} /
                                {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d F Y') }}
                            </p>
                        </div>

                        <div class="text-center pb-4 mt-2">
                            <h4><strong>{{ $item->pengurus ?? '-' }}</strong></h4>
                            <p class="mb-1">
                                <strong>
                                    {{ $item->judulpengurus ?? '-' }}
                                </strong>
                            </p>
                            <p class="mb-2"><strong>PCNU KABUPATEN KUDUS</strong></p>
                            <p class="mb-3"><strong>{{ $item->masapengurus ?? '-' }}</strong></p>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-12 col-md-10">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item mb-1">
                                        <div class="label">Ketua</div>
                                        <span class="separator">:</span>
                                        <div class="value">{{ $item->ketua ?? '-' }}</div>
                                    </li>
                                    <li class="list-group-item mb-1">
                                        <div class="label">Wakil Ketua</div>
                                        <span class="separator">:</span>
                                        <div class="value">{{ $item->wakilketua1 ?? '-' }}</div>
                                    </li>
                                    <li class="list-group-item mb-1">
                                        <div class="label">Wakil Ketua</div>
                                        <span class="separator">:</span>
                                        <div class="value">{{ $item->wakilketua2 ?? '-' }}</div>
                                    </li>
                                    <li class="list-group-item mb-1">
                                        <div class="label">Wakil Ketua</div>
                                        <span class="separator">:</span>
                                        <div class="value">{{ $item->wakilketua3 ?? '-' }}</div>
                                    </li>
                                    <li class="list-group-item mb-1">
                                        <div class="label">Sekretaris</div>
                                        <span class="separator">:</span>
                                        <div class="value">{{ $item->sekretaris ?? '-' }}</div>
                                    </li>
                                    <li class="list-group-item mb-1">
                                        <div class="label">Wakil Sekretaris</div>
                                        <span class="separator">:</span>
                                        <div class="value">{{ $item->wakilsekretaris ?? '-' }}</div>
                                    </li>
                                    <li class="list-group-item mb-1">
                                        <div class="label">Bendahara</div>
                                        <span class="separator">:</span>
                                        <div class="value">{{ $item->bendahara ?? '-' }}</div>
                                    </li>
                                    <li class="list-group-item mb-1">
                                        <div class="label">Bidang-bidang</div>
                                        <span class="separator">:</span>
                                        <div class="value"></div>
                                    </li>
                                    <li class="list-group-item mb-1">
                                        <div class="label">Divisi Penghimpunan</div>
                                        <span class="separator">:</span>
                                        <div class="value">
                                            @foreach (explode('|', $item->penghimpunan) as $nama)
                                                {{ trim($nama) }} <br>
                                            @endforeach
                                        </div>
                                    </li>

                                    <li class="list-group-item mb-1">
                                        <div class="label">Divisi Pendistribusian</div>
                                        <span class="separator">:</span>
                                        <div class="value">
                                            @foreach (explode('|', $item->pendistribusian) as $nama)
                                                {{ trim($nama) }} <br>
                                            @endforeach
                                        </div>
                                    </li>

                                    <li class="list-group-item mb-1">
                                        <div class="label">Divisi Keuangan & Pelaporan</div>
                                        <span class="separator">:</span>
                                        <div class="value">
                                            @foreach (explode('|', $item->keuangan) as $nama)
                                                {{ trim($nama) }} <br>
                                            @endforeach
                                        </div>
                                    </li>

                                    <li class="list-group-item mb-1">
                                        <div class="label">Divisi Humas & Publikasi</div>
                                        <span class="separator">:</span>
                                        <div class="value">
                                            @foreach (explode('|', $item->humas) as $nama)
                                                {{ trim($nama) }} <br>
                                            @endforeach
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="text-center pb-4 mt-4">
                            <h4><strong>{{ $item->manajemen ?? '-' }}</strong></h4>
                            <p class="mb-3"><strong>{{ $item->masamanajemen ?? '-' }}</strong></p>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-12 col-md-10">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item mb-1">
                                        <div class="label">Direktur</div>
                                        <span class="separator">:</span>
                                        <div class="value">
                                            <strong>
                                                {{ $item->direktur ?? '-' }}
                                            </strong>
                                        </div>
                                    </li>
                                    <li class="list-group-item mb-1">
                                        <div class="label">Divisi Administrasi <br> Staf Administrasi</div>
                                        <span class="separator">:</span>
                                        <div class="value">{{ $item->administrasi ?? '-' }}</div>
                                    </li>
                                    <li class="list-group-item mb-1">
                                        <div class="label">Divisi Fundraising <br> Staf Fundraising</div>
                                        <span class="separator">:</span>
                                        <div class="value">{{ $item->fundraising ?? '-' }}</div>
                                    </li>
                                    <li class="list-group-item mb-1">
                                        <div class="label">Divisi Program <br> Staf Program</div>
                                        <span class="separator">:</span>
                                        <div class="value">{{ $item->program ?? '-' }}</div>
                                    </li>
                                    <li class="list-group-item mb-1">
                                        <div class="label">Divisi Keuangan <br> Staf Keuangan</div>
                                        <span class="separator">:</span>
                                        <div class="value">{{ $item->manjkeuangan ?? '-' }}</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ url('superadmin/landing/struktur-pengurus/edit-data/' . $item->id) }}"
                        class="btn btn-warning btn-sm d-flex align-items-center gap-1">
                        <i class="bx bxs-pencil"></i> Edit
                    </a>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    @push('css')
        <style>
            /* Custom CSS untuk responsivitas */
            .team {
                padding-bottom: 3rem;
            }

            .team .container {
                padding-bottom: 3rem;
            }

            .team img {
                /* Batas ukuran maksimum logo */
                width: 50px;
                /* Responsif terhadap lebar container */
                height: auto;
            }

            .list-group-item {
                display: flex;
                flex-wrap: wrap;
                /* Membungkus konten jika layar kecil */
                align-items: flex-start;
                padding: 0.5rem 1rem;
            }

            .list-group-item .label {
                flex: 0 0 40%;
                /* Lebar label 40% di layar besar */
                font-weight: bold;
            }

            .list-group-item .separator {
                flex: 0 0 2%;
                /* Lebar separator */
                text-align: center;
            }

            .list-group-item .value {
                flex: 0 0 58%;
                /* Lebar nilai 58% di layar besar */
            }

            /* Media query untuk layar kecil */
            @media (max-width: 576px) {
                .list-group-item .label {
                    flex: 0 0 100%;
                    /* Label mengambil seluruh lebar */
                    margin-bottom: 0.25rem;
                }

                .list-group-item .separator {
                    display: none;
                    /* Sembunyikan separator */
                }

                .list-group-item .value {
                    flex: 0 0 100%;
                    /* Nilai mengambil seluruh lebar */
                }

                .team h1 {
                    font-size: 1.8rem;
                    /* Kurangi ukuran font di layar kecil */
                }

                .team h4 {
                    font-size: 1.2rem;
                }

                .team p {
                    font-size: 0.9rem;
                }
            }
        </style>
    @endpush
@endforeach
