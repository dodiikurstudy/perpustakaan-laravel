<x-app-layout>

    <div class="max-w-xl mx-auto mt-10">

        <div class="bg-white rounded-xl shadow p-6">


            <h2 class="text-2xl font-bold mb-5">
                Pembayaran Member
            </h2>



            {{-- STATUS PENGAJUAN --}}
            <div class="mb-6">

                <span class="font-semibold">
                    Status Pengajuan :
                </span>


                @if($memberRequest->status == 'pending_payment')

                    <span class="text-yellow-600 font-bold">
                        Menunggu Pembayaran
                    </span>


                @elseif($memberRequest->status == 'waiting_confirmation')

                    <span class="text-blue-600 font-bold">
                        Menunggu Verifikasi Admin
                    </span>


                @elseif($memberRequest->status == 'approved')

                    <span class="text-green-600 font-bold">
                        Member Aktif
                    </span>


                @elseif($memberRequest->status == 'rejected')

                    <span class="text-red-600 font-bold">
                        Pengajuan Ditolak
                    </span>


                @endif

            </div>




            {{-- BIAYA MEMBER --}}
            <div class="mb-5">

                <p class="font-semibold">
                    Biaya Keanggotaan
                </p>


                <p class="text-3xl font-bold text-blue-600">

                    Rp {{ number_format($memberRequest->jumlah,0,',','.') }}

                </p>

            </div>





            {{-- INFORMASI PEMBAYARAN --}}
            <div class="mb-5">

                <p class="font-semibold">
                    Silakan transfer ke:
                </p>


                <p>
                    Bank BCA
                </p>


                <p>
                    1234567890
                </p>


                <p>
                    a.n Perpustakaan DK
                </p>

            </div>





            {{-- UPLOAD HANYA JIKA BELUM BAYAR --}}
            @if($memberRequest->status == 'pending_payment')


                <form
                    action="{{ route('member.payment.upload') }}"
                    method="POST"
                    enctype="multipart/form-data"
                >

                    @csrf


                    <label class="block mb-2 font-semibold">

                        Upload Bukti Pembayaran

                    </label>



                    <input
                        type="file"
                        name="bukti_pembayaran"
                        class="border p-2 rounded w-full"
                        required
                    >



                    <button
                        class="
                            mt-5
                            bg-blue-600
                            text-white
                            px-5
                            py-3
                            rounded-lg
                        "
                    >

                        Kirim Bukti Pembayaran

                    </button>


                </form>


            @endif






            {{-- MENUNGGU VERIFIKASI --}}
            @if($memberRequest->status == 'waiting_confirmation')


                <div class="mt-6 p-4 rounded-lg bg-blue-100 border border-blue-300">


                    <h3 class="font-bold text-blue-700">

                        Bukti pembayaran telah dikirim

                    </h3>


                    <p class="mt-2">

                        Pembayaran sedang diperiksa oleh admin.
                        Silakan tunggu proses verifikasi.

                    </p>


                </div>


            @endif






            {{-- SUDAH DISETUJUI --}}
            @if($memberRequest->status == 'approved')


                <div class="mt-6 p-4 rounded-lg bg-green-100 border border-green-300">


                    <h3 class="font-bold text-green-700">

                        Selamat!

                    </h3>


                    <p class="mt-2">

                        Pembayaran berhasil diverifikasi.
                        Akun Anda sekarang sudah menjadi member.

                    </p>


                </div>


            @endif






            {{-- DITOLAK --}}
            @if($memberRequest->status == 'rejected')


                <div class="mt-6 p-4 rounded-lg bg-red-100 border border-red-300">


                    <h3 class="font-bold text-red-700">

                        Pengajuan Ditolak

                    </h3>


                    <p class="mt-2">

                        Pengajuan member Anda ditolak oleh admin.

                    </p>


                </div>


            @endif



        </div>

    </div>

</x-app-layout>