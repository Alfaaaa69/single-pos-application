<x-print-layout :sale="$sale">
    <div class="text-center font-bold" style="font-size: 16px;">
        {{ config('app.name', 'SinglePOS') }}
    </div>
    <div class="text-center text-[10px] text-gray-500">
        Jl. Raya Singaraja, Bali<br>
        Telp: 0812-3456-7890
    </div>
    
    <div class="divider"></div>

    <!-- Metadata -->
    <table style="width: 100%; margin-bottom: 5px;">
        <tr>
            <td style="width: 40%;">No. Invoice:</td>
            <td class="text-right font-bold">{{ $sale->invoice_number }}</td>
        </tr>
        <tr>
            <td>Tanggal:</td>
            <td class="text-right">{{ $sale->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td>Kasir:</td>
            <td class="text-right">{{ $sale->user->name }}</td>
        </tr>
        <tr>
            <td>Metode:</td>
            <td class="text-right uppercase">{{ $sale->payment_method }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <!-- Items Table -->
    <table style="width: 100%; font-size: 11px;">
        <thead>
            <tr style="border-bottom: 1px dashed #000;">
                <th class="text-left" style="width: 50%;">Produk</th>
                <th class="text-center" style="width: 15%;">Qty</th>
                <th class="text-right" style="width: 35%;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->items as $item)
                <tr>
                    <td class="text-left">
                        {{ $item->product_name }}<br>
                        <span style="font-size: 9px; color: #555;">@ Rp {{ number_format($item->unit_price, 0, ',', '.') }}</span>
                    </td>
                    <td class="text-center" style="vertical-align: top;">{{ $item->quantity }}</td>
                    <td class="text-right" style="vertical-align: top;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="divider"></div>

    <!-- Totals -->
    <table style="width: 100%; margin-top: 5px;">
        <tr>
            <td style="width: 60%;" class="text-right">Subtotal:</td>
            <td class="text-right">Rp {{ number_format($sale->subtotal, 0, ',', '.') }}</td>
        </tr>
        @if($sale->discount_amount > 0)
            <tr>
                <td class="text-right">Diskon:</td>
                <td class="text-right">-Rp {{ number_format($sale->discount_amount, 0, ',', '.') }}</td>
            </tr>
        @endif
        <tr>
            <td class="text-right">PPN (11%):</td>
            <td class="text-right">Rp {{ number_format($sale->tax_amount, 0, ',', '.') }}</td>
        </tr>
        <tr class="font-bold">
            <td class="text-right" style="font-size: 13px;">Grand Total:</td>
            <td class="text-right" style="font-size: 13px;">Rp {{ number_format($sale->total, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="text-right">Bayar:</td>
            <td class="text-right">Rp {{ number_format($sale->amount_paid, 0, ',', '.') }}</td>
        </tr>
        <tr class="font-bold">
            <td class="text-right">Kembalian:</td>
            <td class="text-right">Rp {{ number_format($sale->change_amount, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <div class="text-center font-bold" style="margin-top: 10px; font-size: 11px;">
        Terima Kasih atas Kunjungan Anda
    </div>
    <div class="text-center" style="font-size: 9px; margin-top: 2px;">
        Powered by SinglePOS
    </div>

    <!-- Autoprint trigger script -->
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            window.print();
        });
    </script>
</x-print-layout>
