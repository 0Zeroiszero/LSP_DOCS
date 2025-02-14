<?php

require_once '../assets/dompdf/autoload.inc.php';
include_once '../model/database.php';
include_once '../model/database_crud.php';
include_once '../model/login-validator.php';

$crud = new DatabaseCRUD($conn);
$validator = new LoginValidator($conn);

if (!$validator->check_login_status('login')) {
    header("Location: /kasir");
    exit;
}


use Dompdf\Dompdf;

// Sample data for the transactions
$transactions = $crud->read('penjualan', '', 'PenjualanID', 'TanggalPenjualan', 'TotalHarga', 'PelangganID');

// Create a new DOMPDF instance
$dompdf = new Dompdf();

// HTML content for the PDF
$html = '<html>
<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Laporan Transaksi Penjualan</h1>
    <table>
        <tr>
            <th>PenjualanID</th>
            <th>TanggalPenjualan</th>
            <th>TotalHarga</th>
            <th>PelangganID</th>
        </tr>';

// Add rows for each transaction
foreach ($transactions as $transaction) {
    $html .= '<tr>
        <td>' . $transaction['PenjualanID'] . '</td>
        <td>' . $transaction['TanggalPenjualan'] . '</td>
        <td>' . $transaction['TotalHarga'] . '</td>
        <td>' . $transaction['PelangganID'] . '</td>
    </tr>';
}

$html .= '</table>
</body>
</html>';

// Load the HTML content into DOMPDF
$dompdf->loadHtml($html);

// Set the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the PDF
$dompdf->render();

// Output the PDF to the browser
$dompdf->stream('laporan_transaksi.pdf', ['Attachment' => 0]);
?>