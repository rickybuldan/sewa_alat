@extends('layouts.app')

@section('content')
<div class="container p-4 ">
    <div class="row relative overflow-x-auto shadow-md sm:rounded-lg border-custom shadow-custom" id="printableArea">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" >
            <caption class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                Laporan
                <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">List daftar pengembalian</p>
            </caption>
            @if (count($sewa) > 0)
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nama Perusahaan
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Alat Berat
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status Alat
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Jumlah
                    </th>

                    <th scope="col" class="px-6 py-3">
                        Tanggal Awal
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tanggal Akhir
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Total Harga
                    </th>
                    {{-- <th scope="col" class="px-6 py-3">
                        Action
                    </th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach($sewa as $sewa)
                {{-- @foreach ($sewa as $index => $sewa) --}}
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4 id-cell">
                        {{ $sewa->id }}
                    </td>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        
                        @if($sewa->nama_perusahaan == 'Perorangan')
                            <span class="bg-blue-500 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded text-white">{{ $sewa->nama_perusahaan }}</span>
                        
                        @else
                            <span class="bg-gray-500 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded text-white">{{ $sewa->nama_perusahaan }}</span>
                        @endif
                    </th>
                    <td class="px-6 py-4">
                        {{$sewa->nama}} 
                    </td>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        @if($sewa->status_barang == 'rusak sedang')
                            <span class="bg-yellow-400 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded text-white">
                                Rusak Sedang
                            </span>
                        @elseif($sewa->status_barang == 'baik')
                            <span class="bg-green-500 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded text-white"">
                                Baik
                            </span>
                        @elseif($sewa->status_barang == 'rusak parah')
                            <span class="bg-red-500 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded text-white"">
                                Rusak Parah
                            </span>
                        @else
                            <span class="bg-gray-500 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded text-white"">
                                Status Tidak Diketahui
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        {{$sewa->jumlah}}
                    </td>
                    <td class="px-6 py-4">
                        {{ $sewa->tanggal_awal }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $sewa->tanggal_akhir }}
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $totalHarga = $sewa->jumlah * $sewa->harga_sewa +$sewa->denda;
                            $totalHargaRupiah = "Rp " . number_format($totalHarga, 0, ',', '.');
                        @endphp
                        {{ $totalHargaRupiah }}
                    </td>
                    {{-- <td class="px-6 py-4">
                        <a href="{{ route('admin.riwayat.show', $sewa->id) }}" class="px-4 py-2 font-medium text-white bg-blue-500 rounded-md dark:text-blue-500 hover:underline">Detail</a>
                    </td> --}}
                </tr>
                @endforeach
            </tbody>
            @else
                <p class="p-4 text-red-500 dark:text-gray-400 bg-white border-b border-custom-392676">Tidak ada riwayat.</p>
            @endif
        </table>
        <div class="p-2 bg-white dark:text-white dark:bg-gray-800">
            <button id="printButton" class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Print</button>
        </div>
    </div>
    @if (Auth::user()->role->name == 'admin')
        <a href="{{ route('admin.dataMaster.show') }}" class="inline-flex items-center px-3 py-1 mt-3 text-white bg-blue-600 border border-transparent rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-400">
            Kembali
        </a>
    @else
    @endif
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const idCells = document.querySelectorAll('.id-cell');
    
    idCells.forEach(cell => {
        const idText = cell.textContent.trim();
        const formattedId = idText.padStart(3, '0');
        cell.textContent = formattedId;
    });

    document.getElementById('printButton').addEventListener('click', function() {
        printDiv('printableArea');
    });

    function printDiv(divId) {
        var printContents = document.getElementById(divId).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
});
</script>
@endsection


