<?php
require get_template_directory() . '/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

function export_xlsx() {
    // Check User Permission
    if (!current_user_can('manage_options')) {
        wp_die(__('Bạn không có quyền thực hiện thao tác này.', 'text-domain'));
    }
    // Check Nonce
    if (!isset($_POST['export_newsletter_nonce']) || !wp_verify_nonce($_POST['export_newsletter_nonce'], 'export_newsletter')) {
        wp_die(__('Hành động không hợp lệ.', 'text-domain'));
    }

    global $wpdb;
    $table_name = sanitize_text_field($_POST['table_name']);
    $fields = sanitize_text_field($_POST['fields']);
    $fields = explode(',', $fields);
    $fields = array_map('sanitize_text_field', $fields);
    
    $limit = isset($_POST['limit']) && intval($_POST['limit']) > 0 ? intval($_POST['limit']) : null;
    $offset = isset($_POST['offset']) && intval($_POST['offset']) >= 0 ? intval($_POST['offset']) : null;

    $fields_sql = implode(',', $fields);
    $sql = "SELECT $fields_sql FROM $table_name ORDER BY created_at ASC";

    if ($limit !== null) {
        $sql .= " LIMIT $limit";
    }

    if ($offset !== null) {
        $sql .= " OFFSET $offset";
    }

    $results = $wpdb->get_results($sql);

    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    foreach ($fields as $index => $field) {
        $cell = chr($index + 65) . $index + 1;
        $sheet->setCellValue($cell, $field);
    }
    foreach($results as $index => $result) {
        foreach ($fields as $index2 => $field) {
            $cell = chr($index2 + 65) . ($index + 2);
            $sheet->setCellValue($cell, $result->$field);
        }
    }

    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

    header('Content-Type: text/xlsx');
    header('Content-Disposition: attachment;filename="example.xlsx"');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
    exit;
}
add_action('admin_post_export_xlsx', 'export_xlsx');
add_action('admin_post_nopriv_export_xlsx', 'export_xlsx');