@extends('layouts.app')

@section('title', 'Our Menu')

@section('content')
<!-- Page Header Start -->
<div class="page-header parallaxie">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- Page Header Box Start -->
                <div class="page-header-box">
                    <h1 class="text-anime-style-2" data-cursor="-opaque">Our Menu</h1>
                </div>
                <!-- Page Header Box End -->
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Classic Menu Section Start -->
<div class="classic-menu-section" style="padding: 120px 0;">
    <div class="container">
        @if($categories->isEmpty())
            <div class="col-lg-12 text-center">
                <h2>Our menu is currently being updated. Please check back soon!</h2>
            </div>
        @else
            <div class="row">
                @php
                    // Split the categories collection into two halves for the two-column layout
                    $columns = $categories->chunk(ceil($categories->count() / 2));
                @endphp

                @foreach($columns as $column)
                <div class="col-lg-6">
                    @foreach($column as $category)
                    <div class="classic-menu-category-card">
                        <div class="classic-menu-category-title">
                            <h2>{{ $category->name }}</h2>
                        </div>
                        <div class="classic-menu-list">
                            @forelse($category->menus as $item)
                            <div class="classic-menu-card">
                                <div class="classic-menu-card-img">
                                    <img src="{{ $item->image_url ?? asset('public/assets/images/default-food.png') }}" alt="{{ $item->name }}" />
                                </div>
                                <div class="classic-menu-card-content">
                                    <div class="classic-menu-card-header">
                                        <h3>{{ $item->name }}</h3>
                                        <span class="price">${{ number_format($item->price, 2) }}</span>
                                    </div>
                                    <p class="description">{{ $item->description }}</p>
                                </div>
                            </div>
                            @empty
                            <p>No items in this category yet.</p>
                            @endforelse
                        </div>
                    </div>
                    @endforeach
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
<!-- Classic Menu Section End -->
@endsection 