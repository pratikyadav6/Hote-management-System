<?php
function printBill($items, $taxRate)
{
  $subtotal = 0;

  echo "---------------------------------\n";
  echo "          Restaurant Bill        \n";
  echo "---------------------------------\n";
  echo "Item             Qty    Price   Total\n";
  echo "---------------------------------\n";

  foreach ($items as $item) {
    $itemTotal = $item['quantity'] * $item['price'];
    $subtotal += $itemTotal;

    printf("%-15s %3d  %7.2f  %7.2f\n", $item['name'], $item['quantity'], $item['price'], $itemTotal);
  }

  $tax = $subtotal * $taxRate;
  $total = $subtotal + $tax;

  echo "---------------------------------\n";
  printf("Subtotal:                 %7.2f\n", $subtotal);
  printf("Tax (%.2f%%):              %7.2f\n", $taxRate * 100, $tax);
  echo "---------------------------------\n";
  printf("Total:                    %7.2f\n", $total);
  echo "---------------------------------\n";
}

// Example usage:
$items = [
  ['name' => 'Burger', 'quantity' => 2, 'price' => 5.99],
  ['name' => 'Fries', 'quantity' => 1, 'price' => 2.99],
  ['name' => 'Soda', 'quantity' => 3, 'price' => 1.50],
];

$taxRate = 0.07; // 7% tax

printBill($items, $taxRate);
