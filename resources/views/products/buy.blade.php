<h1>{{ $product->product_name }} を購入</h1>
<p>価格: {{ $product->price }}円</p>

<form method="POST" action="#">
    @csrf
    <button type="submit">購入する</button>
</form>
