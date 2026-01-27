@extends('layouts.app')

@section('header')
    <h1 class="text-xl font-semibold text-gray-800">
        商品情報詳細
    </h1>
@endsection

@section('content')
<div class="container">

    <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">商品一覧画面に戻る</a>

    <div class="card">
        <div class="card-body">
            <h2 class="card-title">{{ $product->name }}</h2>

    <dl class="row mt-3" >
        <dt class="col-sm-3">商品情報ID</dt>
        <dd class="col-sm-9">{{ $product->id }}</dd>

        <dt class="col-sm-3">商品画像</dt>
        <dd class="col-sm-9">
            @if($product->img_path)
            <img src="{{ asset('storage/' . $product->img_path) }}">
                alt="商品画像"
                width="300"
                style="max-height: 400px; object-fit: contain;">

        @else
                商品画像がありません
        @endif
        </dd>
    

        <dt class="col-sm-3">メーカー</dt>
        <dd class="col-sm-9">{{ $product->company->company_name ?? '未設定' }}</dd>

        <dt class="col-sm-3">価格</dt>
        <dd class="col-sm-9">{{ $product->price }}</dd>

        <dt class="col-sm-3">在庫数</dt>
        <dd class="col-sm-9">{{ $product->stock }}</dd>

        <dt class="col-sm-3">コメント</dt>
        <dd class="col-sm-9">{{ $product->comment }}</dd>

    </dl>
    <a href="{{ route('products.edit', $product) }}" class="btn btn-primary btn-sm mx-1">商品情報を編集する</a>
  </div>
</div>
@endsection

