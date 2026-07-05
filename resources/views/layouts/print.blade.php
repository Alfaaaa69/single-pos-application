<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Struk #{{ $sale->invoice_number }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            line-height: 1.2;
            color: #000;
            background-color: #fff;
            margin: 0;
            padding: 0;
        }

        .receipt-container {
            width: 100%;
            max-width: 80mm; /* support 58mm/80mm scales */
            margin: 0 auto;
            padding: 5px;
            box-sizing: border-box;
        }

        /* 58mm thermal specific scaling */
        @media screen and (max-width: 58mm) {
            .receipt-container {
                max-width: 58mm;
            }
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .font-bold { font-weight: bold; }
        
        .divider {
            border-top: 1px dashed #000;
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            font-size: 11px;
            padding: 2px 0;
        }

        /* Printing optimizations */
        @media print {
            body {
                background: none;
                color: #000;
            }
            .receipt-container {
                width: 100%;
                margin: 0;
                padding: 0;
            }
            /* hide browser default headers/footers */
            @page {
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        {{ $slot }}
    </div>
</body>
</html>
