@extends('layouts.app')

@section('title', $product->name)

@section('content')
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $product->name }}
            </h2>
            <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800">
                &larr; Back to Products
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Product Images -->
                        <div>
                            <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200">
                                @if($product->images && count($product->images) > 0)
                                    <img src="{{ Storage::url($product->images[0]) }}" 
                                        alt="{{ $product->name }}"
                                        class="h-full w-full object-cover object-center">
                                @else
                                    <div class="flex items-center justify-center h-full bg-gray-100">
                                        <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            @if($product->images && count($product->images) > 1)
                                <div class="mt-4 grid grid-cols-4 gap-2">
                                    @foreach(array_slice($product->images, 1) as $image)
                                        <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200">
                                            <img src="{{ Storage::url($image) }}" 
                                                alt="{{ $product->name }}"
                                                class="h-full w-full object-cover object-center cursor-pointer hover:opacity-75">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Product Info -->
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $product->name }}</h1>
                            <div class="mt-2">
                                <p class="text-3xl tracking-tight text-gray-900">${{ number_format($product->price, 2) }}</p>
                            </div>

                            <div class="mt-4">
                                <h2 class="sr-only">Product information</h2>
                                <p class="text-sm text-gray-600">Category: 
                                    <a href="{{ route('categories.show', $product->category) }}" class="text-blue-600 hover:text-blue-800">
                                        {{ $product->category->name }}
                                    </a>
                                </p>
                                
                                @if($product->stock > 0)
                                    <p class="text-sm text-gray-600 mt-1">
                                        Stock: {{ $product->stock }} units
                                    </p>
                                @endif
                            </div>

                            <div class="mt-6">
                                <h3 class="sr-only">Description</h3>
                                <div class="space-y-6 text-base text-gray-700">
                                    {{ $product->description }}
                                </div>
                            </div>

                            @if($product->stock > 0)
                                <form action="{{ route('cart.store') }}" method="POST" class="mt-8">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <div class="mb-4">
                                        <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                                        <select name="quantity" id="quantity"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            @for($i = 1; $i <= min($product->stock, 10); $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <button type="submit"
                                        class="w-full bg-blue-600 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Add to Cart
                                    </button>
                                </form>
                            @else
                                <div class="mt-8">
                                    <button type="button" disabled
                                        class="w-full bg-gray-300 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-gray-500 cursor-not-allowed">
                                        Out of Stock
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($relatedProducts->isNotEmpty())
                        <div class="mt-16">
                            <h2 class="text-xl font-bold text-gray-900 mb-6">Related Products</h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                                @foreach($relatedProducts as $relatedProduct)
                                    <div class="group relative">
                                        <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200">
                                            @if($relatedProduct->images && count($relatedProduct->images) > 0)
                                                <img src="{{ Storage::url($relatedProduct->images[0]) }}" 
                                                    alt="{{ $relatedProduct->name }}"
                                                    class="h-full w-full object-cover object-center group-hover:opacity-75">
                                            @endif
                                        </div>
                                        <div class="mt-4">
                                            <h3 class="text-sm text-gray-700">
                                                <a href="{{ route('products.show', $relatedProduct) }}">
                                                    <span aria-hidden="true" class="absolute inset-0"></span>
                                                    {{ $relatedProduct->name }}
                                                </a>
                                            </h3>
                                            <p class="mt-1 text-sm font-medium text-gray-900">
                                                ${{ number_format($relatedProduct->price, 2) }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@endsection 