@extends('layouts.app')

@section('content')
    <div class="container">
         <h1>商品編集</h1>

        @if(session('success'))
          <div class="alert alert-success">
              {{ session('success') }}
          </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            </div>
         @endif

         <form action="{{ route('products.update', $product->id) }}" method="POST">
              @csrf
              @method('PUT')

             <div class="mb-3">
                <label class="form-label">商品名</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">企業</label>
                <select name="company_id" class="form-control">
                    <option value="">選択してください</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}" 
                            {{ old('company_id', $product->company_id) == $company->id ? 'selected' : '' }}>
                            {{ $company->name }}
                        </option>
                    @endforeach
                </select>
            </div>



            <div class="mb-3">
            <label class="form-label">価格</label>
            <input type="number" name="price" value="{{ old('price', $product->price) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">説明</label>
            <textarea name="description" class="form-control">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">在庫数</label>
            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">更新</button>
        <a href="{{ route('products.show', $product->id) }}" class="btn btn-secondary">詳細に戻る</a>
        </form>
    
    </div>
@endsection

