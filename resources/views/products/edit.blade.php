@extends('layouts.app')

@section('header')
    <h1 class="text-xl font-semibold text-gray-800">
        商品編集
    </h1>
@endsection


@section('content')
    <div class="container">

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

         <form action="{{ route('products.update', $product->id) }}"
               method="POST" 
               enctype="multipart/form-data">
         
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
                  @foreach($companies as $id => $name)
                    <option value="{{ $id }}"
                        {{ old('company_id', $product->company_id) == $id ? 'selected' : '' }}>
                        {{ $name }}
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
            <textarea name="comment" class="form-control">{{ old('comment', $product->comment) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">在庫数</label>
            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">商品画像</label>
            <input type="file" name="img_path" class="form-control">
        </div>


        <button type="submit" class="btn btn-primary">更新</button>
        <a href="{{ route('products.show', $product->id) }}" class="btn btn-secondary">詳細に戻る</a>
        </form>
    
    </div>
@endsection

