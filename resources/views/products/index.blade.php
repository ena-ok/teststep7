@extends('layouts.app')

@section('header')
    <h1 class="text-xl font-semibold text-gray-800">
        商品情報一覧
    </h1>
@endsection

@section('content')
<div class="d-flex justify-content-center mt-5">
    <div class="card shadow p-4 product-card">

    <form id="search-form" 
          action="{{ route('products.index') }}" 
          method="GET" 
          class="row g-3 mb-4"
          data-url="{{ route('products.index') }}">
          
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

        <div class="col-md-3">
          <input type="number" name="price_min" value="{{ request('price_min') }}" class="form-control" placeholder="価格（下限）">
        </div>

        <div class="col-md-3">
           <input type="number" name="price_max" value="{{ request('price_max') }}" class="form-control" placeholder="価格（上限）">
        </div>

        <div class="col-md-3">
          <input type="number" name="stock_min" value="{{ request('stock_min') }}" class="form-control" placeholder="在庫（下限）">
        </div>

        <div class="col-md-3">
          <input type="number" name="stock_max" value="{{ request('stock_max') }}" class="form-control" placeholder="在庫（上限）">
        </div>  
          <div class="col-md-3 d-flex">
                <button type="submit" class="btn btn-primary flex-fill me-2">検索</button>
                <a href="{{ route('products.create') }}" class="btn btn-success flex-fill">新規登録</a>
         </div>
    </form>

    <table class="table table-striped align-middle text-center">
        <thead class="table-dark">
            <tr>
                 <th class="sortable" data-sort="id">ID</th>
                 <th>商品画像</th>
                 <th class="sortable" data-sort="name">商品名</th>
                 <th class="sortable" data-sort="price">価格</th>
                 <th class="sortable" data-sort="stock">在庫数</th>
                 <th>メーカー名</th>
                 <th>操作</th>
            </tr>
        </thead>
        <tbody id="product-list">
            @forelse($products as $product)
                <tr id="product-{{ $product->id }}">
                <td>{{ $product->id }}</td>

                <td>
                    @if ($product->img_path)
                        <img src="{{ asset('storage/' . $product->img_path) }}"
                             alt="商品画像"
                             width="60">
                    @else
                        画像なし
                    @endif
                </td>

                <td>{{ $product->name }}</td>

                <td>¥{{ number_format($product->price) }}</td>

                <td>{{ $product->stock }}</td>

                <td>{{ $product->company->company_name ?? '不明' }}</td>

                <td>
                  <a href="{{ route('products.show', $product) }}"
                      class="btn btn-info btn-sm text-white">
                           詳細
                  </a>

                  <form action="{{ route('products.destroy', $product) }}"
                      method="POST"
                      class="d-inline delete-form">

                      @csrf
                      @method('DELETE')

                 <button type="submit" class="btn btn-danger btn-sm">
                      削除
                 </button>
            </form>
        </td>
    </tr>
@empty
    <tr>
            <td colspan="7" class="text-muted">
                商品が見つかりません。
            </td>
        </tr>
    @endforelse
</tbody>

              
    </table>

    <div class="mt-6" id="pagination">
    {{ $products->links() }}
    </div>

</div>
</div>


@endsection