<!DOCTYPE html>
<html>
<head>
    <title>取引完了のお知らせ</title>
</head>
<body>
    <h1>取引が完了しました</h1>
    <p>お客様の注文が完了しました。ありがとうございます。</p>
    <p>注文詳細:</p>
    <ul>
        <li>商品名: {{ $order->item->name }}</li>
        <li>価格: ¥{{ $order->item->price }}</li>
        <li>注文日時: {{ $order->created_at }}</li>
    </ul>
    <p>今後ともよろしくお願い申し上げます。</p>
</body>
</html>