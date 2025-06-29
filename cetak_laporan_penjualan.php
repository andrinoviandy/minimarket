<?php
ob_start();
require 'vendor/autoload.php';
include("include/API.php");

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

// Dummy JSON untuk contoh
$file = file_get_contents($API . "json/cetak_laporan_penjualan.php?tglPenjualan1=" . $_GET['tglPenjualan1'] . "&tglPenjualan2=" . $_GET['tglPenjualan2'] . "");
$json = json_decode($file, true);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->mergeCells('A1:G1');
$sheet->setCellValue('A1', 'LAPORAN PENJUALAN');
$sheet->getStyle('A1')->applyFromArray([
    'font' => [
        'bold' => true,
        'size' => 14,
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
]);
$sheet->mergeCells('A2:G2');
$sheet->setCellValue('A2', 'Periode : ' . (new DateTime($_GET['tglPenjualan1']))->format('d/m/Y') . ' - ' . (new DateTime($_GET['tglPenjualan2']))->format('d/m/Y'));
$sheet->getStyle('A2')->applyFromArray([
    'font' => [
        'bold' => true,
        'size' => 12,
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
]);

$headers = ['No', 'Tgl Transaksi', 'No. Nota', 'Pelanggan', 'Produk', 'Diskon', 'Total Harga'];
$col = 'A';
foreach ($headers as $header) {
    $sheet->setCellValue($col . '3', $header);
    $col++;
}
// Style untuk header (baris ke-3)
$sheet->getStyle('A3:G3')->applyFromArray([
    'font' => [
        'bold' => true,
        'color' => ['rgb' => 'FFFFFF'], // putih
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'rgb' => '0000FF', // biru
        ],
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    ],
]);

if ($json != null) {
    $jml = count($json);
    for ($i = 0; $i < $jml; $i++) {
        $row = $i + 4;
        $sheet->setCellValue('A' . $row, $i + 1);
        $sheet->setCellValue('B' . $row, (new DateTime($json[$i]['tgl_jual']))->format('d-m-Y'));
        $sheet->setCellValue('C' . $row, $json[$i]['no_po_jual']);
        $sheet->setCellValue('D' . $row, ($json[$i]['nama_siswa'] != '' || $json[$i]['nama_siswa'] != NULL) ? $json[$i]['nama_siswa'] : $json[$i]['nama_guru']);
        $sheet->setCellValue('E' . $row, '');
        $sheet->setCellValue('F' . $row, $json[$i]['diskon_jual']. "%");
        $sheet->setCellValue('G' . $row, $json[$i]['total_harga']);
    }
    $columns = range('A', 'G');
    foreach ($columns as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // Tambahkan border setelah loop
    $styleArray = [
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => 'FF000000'],
            ],
        ],
    ];

    // Tentukan range dari A3 sampai J + baris terakhir data
    $lastRow = $jml + 3;
    $sheet->getStyle("A3:G$lastRow")->applyFromArray($styleArray);
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Laporan Penjualan ['.(new DateTime($_GET['tglPenjualan1']))->format('d-m-Y').' sampai '.(new DateTime($_GET['tglPenjualan2']))->format('d-m-Y').'].xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
ob_end_clean();
$writer->save('php://output');
exit;
