@extends('layouts.app')

@section('header')
    <h1 class="text-xl font-semibold text-gray-800">
        商品新規登録
    </h1>
@endsection


@section('content')
<div class="container">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('products.store') }}"
          method="POST"
          enctype="multipart/form-data"> 
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">商品名</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control">
            @error('name') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="company_id" class="form-label">企業名</label>
            <select name="company_id" id="company_id" class="form-control">
                <option value="">選択してください</option>

                @foreach($companies as $id => $name)
                    <option value="{{ $id }}"
                        {{ old('company_id') == $id ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
                @error('company_id') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">価格</label>
            <input type="number" name="price" id="price" value="{{ old('price') }}" class="form-control">
            @error('price') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">在庫数</label>
            <input type="number" name="stock" id="stock" value="{{ old('stock') }}" class="form-control">
            @error('stock') <div class="text-danger">{{ $message }}</div> @enderror
        </div> 
        
        <div class="mb-3">
            <label for="comment" class="form-label">コメント</label>
            <textarea name="comment" id="comment" rows="3" class="form-control">{{ old('comment') }}</textarea>
            @error('comment') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="img_path" class="form-label">商品画像</label>
            <input type="file" name="img_path" id="img_path" class="form-control" accept="image/*">
            @error('img_path') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary px-5 me-2">登録</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary px-4">戻る</a>
        </div>

        </form>


</div>
@endsection

