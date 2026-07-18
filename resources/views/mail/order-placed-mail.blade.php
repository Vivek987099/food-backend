```blade
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Placed</title>
</head>

<body style="margin:0;padding:30px;background:#f4f4f4;font-family:Arial,Helvetica,sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0"
                    style="background:#ffffff;border-radius:10px;overflow:hidden;">

                    <!-- Header -->
                    <tr>
                        <td align="center" style="background:#ff6b00;padding:25px;">
                            <h1 style="margin:0;color:#ffffff;">
                                FoodExpress
                            </h1>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:35px;">

                            <h2 style="margin-top:0;color:#333;">
                                🎉 Order Placed Successfully!
                            </h2>

                            <p style="font-size:16px;color:#555;line-height:26px;">
                                Hi <strong>{{ $order->name }}</strong>,
                            </p>

                            <p style="font-size:16px;color:#555;line-height:26px;">
                                Thank you for your order! We've received it successfully and our team has started
                                preparing your delicious food.
                            </p>

                            <table width="100%" cellpadding="10" cellspacing="0"
                                style="border-collapse:collapse;border:1px solid #e5e5e5;margin:30px 0;">

                                <tr style="background:#fafafa;">
                                    <td><strong>Order ID</strong></td>
                                    <td>{{ $order->razorpay_order_id }}</td>
                                </tr>
                                <tr style="background:#fafafa;">
                                    <td><strong>Payment ID</strong></td>
                                    <td>{{ $order->razorpay_payment_id }}</td>
                                </tr>

                                <tr>
                                    <td><strong>Order Date</strong></td>
                                    <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
                                </tr>

                                <tr style="background:#fafafa;">
                                    <td><strong>Payment Method</strong></td>
                                    <td>{{ $order->payment_method }}</td>
                                </tr>

                                <tr>
                                    <td><strong>Status</strong></td>
                                    <td style="color:green;font-weight:bold;">
                                        {{ $order->status }}
                                    </td>
                                </tr>

                                <tr style="background:#fafafa;">
                                    <td><strong>Total Amount</strong></td>
                                    <td><strong>₹{{ $order->total }}.00</strong></td>
                                </tr>

                            </table>

                            <h3 style="color:#333;">
                                Ordered Items
                            </h3>

                            <table width="100%" cellpadding="10" cellspacing="0"
                                style="border-collapse:collapse;border:1px solid #e5e5e5;">

                                <tr style="background:#ff6b00;color:#ffffff;">
                                    <th align="left">Item</th>
                                    <th align="center">Qty</th>
                                    <th align="right">Price</th>
                                </tr>
                                @foreach ($order->order_items as $item)
                                    <tr>
                                        <td>{{ $item ->foodItem->name }}</td>
                                        <td align="center">{{$item->quantity}}</td>
                                        <td align="right">₹{{ $item->price * $item->quantity }}</td>
                                    </tr>
                                @endforeach

                            </table>

                            <p style="margin-top:30px;font-size:16px;color:#555;line-height:26px;">
                                We'll notify you once your order is confirmed and out for delivery.
                            </p>

                            <div style="text-align:center;margin:35px 0;">

                                <a href="#"
                                    style="background:#ff6b00;color:#ffffff;text-decoration:none;padding:14px 30px;border-radius:6px;display:inline-block;font-weight:bold;">
                                    Track Your Order
                                </a>

                            </div>

                            <p style="font-size:14px;color:#777;">
                                If you have any questions, simply reply to this email or contact our support team.
                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="background:#fafafa;padding:20px;color:#777;font-size:13px;">
                            © 2026 FoodExpress. All Rights Reserved.
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
```
