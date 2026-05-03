<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Barangay Document')</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Times New Roman', serif;
            background: #fff;
            color: #000;
            font-size: 13pt;
        }

        .page {
            width: 215mm;
            min-height: 279mm;
            margin: 0 auto;
            padding: 20mm 22mm;
            position: relative;
        }

        /* Watermark */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.07;
            z-index: 0;
            pointer-events: none;
        }
        .watermark img { width: 260px; }

        /* All content sits above watermark */
        .content { position: relative; z-index: 1; }

        /* Header */
        .cert-header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px double #000;
            padding-bottom: 14px;
            position: relative;
        }
        .cert-header .republic {
            font-size: 10pt;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .cert-header .province {
            font-size: 10pt;
        }
        .cert-header .brgy-name {
            font-size: 18pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 4px 0;
        }
        .cert-header .brgy-address {
            font-size: 9.5pt;
            color: #333;
        }
        .seal {
            position: absolute;
            top: 2mm;
            left: 14mm;
            width: 100px;
        }

        /* Title */
        .cert-title {
            text-align: center;
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin: 24px 0 6px;
            text-decoration: underline;
        }
        .cert-subtitle {
            text-align: center;
            font-size: 9pt;
            letter-spacing: 2px;
            color: #444;
            margin-bottom: 28px;
        }

        /* Body */
        .cert-body {
            line-height: 2;
            font-size: 13pt;
            text-align: justify;
        }
        .cert-body .name {
            font-weight: bold;
            text-transform: uppercase;
        }
        .cert-body .blank {
            display: inline-block;
            border-bottom: 1px solid #000;
            min-width: 120px;
            font-weight: bold;
        }

        /* Purpose line */
        .cert-purpose {
            margin-top: 20px;
            font-size: 13pt;
            line-height: 1.9;
        }

        /* Signature block */
        .sig-block {
            margin-top: 50px;
            text-align: center;
            display: inline-block;
            min-width: 220px;
        }
        .sig-block .sig-name {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 13pt;
            border-top: 1.5px solid #000;
            padding-top: 4px;
        }
        .sig-block .sig-title {
            font-size: 10.5pt;
            font-style: italic;
        }
        .sig-right {
            display: flex;
            justify-content: flex-end;
        }

        /* Date line */
        .cert-date {
            margin-top: 28px;
            font-size: 12pt;
        }

        /* OR and control number */
        .cert-footer-info {
            position: absolute;
            bottom: 20mm;
            left: 22mm;
            right: 22mm;
            border-top: 1px solid #aaa;
            padding-top: 8px;
            font-size: 9pt;
            color: #555;
            display: flex;
            justify-content: space-between;
        }

        /* Print button */
        .print-bar {
            position: fixed;
            top: 0; left: 0; right: 0;
            background: #2d6a4f;
            color: #fff;
            padding: 10px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 1000;
            font-family: 'DM Sans', sans-serif;
        }
        .print-bar .actions { display: flex; gap: 10px; }
        .print-bar .btn-print {
            background: #fff;
            color: #2d6a4f;
            border: none;
            padding: 7px 18px;
            border-radius: 6px;
            font-weight: 700;
            cursor: pointer;
            font-size: 13px;
        }
        .print-bar .btn-back {
            background: transparent;
            color: #fff;
            border: 1px solid rgba(255,255,255,.5);
            padding: 7px 18px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            font-size: 13px;
            text-decoration: none;
        }
        .print-bar .btn-back:hover { background: rgba(255,255,255,.1); }

        /* Push page below print bar on screen */
        @media screen {
            body { padding-top: 56px; }
        }

        /* Hide print bar and show clean page when printing */
        @media print {
            .print-bar { display: none !important; }
            body { padding-top: 0; background: #fff; }
            .page { width: 100%; margin: 0; padding: 15mm 20mm; }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>

{{-- Print action bar (hidden on print) --}}
<div class="print-bar">
    <span style="font-family:'DM Sans',sans-serif; font-weight:600;">
        🖨️ &nbsp; Document ready — review before printing
    </span>
    <div class="actions">
        <a href="{{ $backRoute ?? route('documents.index') }}" class="btn-back">
        ← {{ $backLabel ?? 'Back to Document Issuance Page' }}
        </a>
        <button class="btn-print" onclick="window.print()">Print Document</button>
    </div>
</div>

@yield('body')

</body>
</html>
