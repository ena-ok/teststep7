@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center mt-5">
    <div class="card shadow p-4 product-card">

        <h2 class="mb-4 text-center">商品情報一覧</h2>

    <!-- 検索フォーム -->
    <form method="GET" action="{{ route('products.index') }}" class="row g-3 mb-4">
        <div class="col-md-5">
            <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control" placeholder="検索キーワード">
        </div>
        <div class="col-md-4">
            <select name="company_id" class="form-select">
                <option value="">メーカー名</option>
                @foreach($companies as $id => $name)
                    <option value="{{ $id }}" {{ request('company_id') == $id ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
        </div>
          <div class="col-md-3 d-flex">
                <button type="submit" class="btn btn-primary flex-fill me-2">検索</button>
                <a href="{{ route('products.create') }}" class="btn btn-success flex-fill">新規登録</a>
         </div>
    </form>

    <!-- 一覧テーブル -->
    <table class="table table-striped align-middle text-center">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>商品画像</th>
                <th>商品名</th>
                <th>価格</th>
                <th>在庫数</th>
                <th>メーカー名</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>
                        @if ($product->img_path)
                            <img src="{{ asset('storage/' . $product->img_path) }}" alt="商品画像" width="60">
                        @else
                            画像なし
                        @endif
                    </td>
                    <td>{{ $product->product_name }}</td>
                    <td>¥{{ number_format($product->price) }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ $product->company->company_name ?? '不明' }}</td>
                    <td>
                        <a href="{{ route('products.show', $product) }}" class="btn btn-info btn-sm text-white">詳細</a>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-secondary btn-sm">編集</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST"
                             class="d-inline js-delete-form">

                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">削除</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-muted">商品が見つかりません。</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- ページネーション -->
    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
@endsection
