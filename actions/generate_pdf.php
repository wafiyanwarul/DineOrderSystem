<?php
require('../includes/fpdf.php'); // Sesuaikan path ke file fpdf.php
include('../includes/db_connect.php'); // Sesuaikan path ke file koneksi database Anda

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Query untuk mengambil data order, customer, user, dan restoran
    $sql_order = "SELECT o.*, c.customer_id, c.user_id, u.username, r.restaurant_name 
                  FROM orders o
                  JOIN customer c ON o.customer_id = c.customer_id
                  JOIN user u ON c.user_id = u.user_id
                  JOIN restaurant r ON o.restaurant_id = r.restaurant_id
                  WHERE o.order_id = '$order_id'";
    $result_order = $koneksi->query($sql_order);
    $order = $result_order->fetch_assoc();

    // Query untuk mengambil detail order
    $sql_order_detail = "SELECT od.*, f.food_name, f.price, cat.category_name 
                         FROM order_detail od
                         JOIN food f ON od.food_id = f.food_id
                         JOIN category cat ON f.category_id = cat.category_id
                         WHERE od.order_id = '$order_id'";
    $result_order_detail = $koneksi->query($sql_order_detail);

    class PDF extends FPDF
    {
        function Header()
        {
            $this->SetFont('Arial', 'B', 15);
            $this->Cell(0, 10, 'Dine In Hub', 0, 1, 'C');
            $this->Cell(0, 10, 'Payment Details', 0, 1, 'C');
            $this->Ln(10);
        }

        function Footer()
        {
            $this->SetY(-15);
            $this->SetFont('Arial', 'I', 8);
            $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
        }
    }

    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);

    $pdf->Cell(0, 10, 'Order ID: ' . $order['order_id'], 0, 1);
    $pdf->Cell(0, 10, 'Order Date: ' . $order['order_date'], 0, 1);
    $pdf->Cell(0, 10, 'Customer Username: ' . $order['username'], 0, 1);
    $pdf->Cell(0, 10, 'Restaurant Name: ' . $order['restaurant_name'], 0, 1);

    $pdf->Ln(10);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(40, 10, 'Food Name', 1);
    $pdf->Cell(40, 10, 'Category', 1);
    $pdf->Cell(30, 10, 'Price', 1);
    $pdf->Cell(20, 10, 'Quantity', 1);
    $pdf->Cell(30, 10, 'Total Price', 1);
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 10);
    $total_amount = 0;
    while ($row = $result_order_detail->fetch_assoc()) {
        $total_amount += $row['total_price'];
        $pdf->Cell(40, 10, $row['food_name'], 1);
        $pdf->Cell(40, 10, $row['category_name'], 1);
        $pdf->Cell(30, 10, 'Rp. ' . number_format($row['price'], 2), 1);
        $pdf->Cell(20, 10, $row['quantity'], 1);
        $pdf->Cell(30, 10, 'Rp. ' . number_format($row['total_price'], 2), 1);
        $pdf->Ln();
    }

    // Voucher and discount details
    $voucher_name = $order['voucher_id'] ? $order['voucher_id'] : 'No Voucher';
    $voucher_discount = $order['voucher_id'] ? 10 : 0; // example discount value, replace with actual value from your database
    $final_amount = $total_amount - ($total_amount * ($voucher_discount / 100));

    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Payment Summary', 0, 1);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 10, 'Total Amount: Rp. ' . number_format($total_amount, 2), 0, 1);
    $pdf->Cell(0, 10, 'Voucher: ' . htmlspecialchars($voucher_name), 0, 1);
    $pdf->Cell(0, 10, 'Discount: ' . number_format($voucher_discount, 2) . '%', 0, 1);
    $pdf->Cell(0, 10, 'Final Amount: Rp. ' . number_format($final_amount, 2), 0, 1);

    $pdf->Output('D', 'Dine In Hub - Order_Detail_' . $order_id . '.pdf');
}
?>
