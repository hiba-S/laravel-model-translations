<?php

use Tests\Models\Order;
use Tests\Models\OrderItem;
use Tests\Models\Product;

// ============================================================
// Helpers
// ============================================================

function makeOrder(array $products = []): Order
{
    $order = Order::create(['reference' => 'ORD-' . uniqid()]);

    foreach ($products as $product) {
        OrderItem::create([
            'order_id'   => $order->id,
            'product_id' => $product->id,
            'quantity'   => 1,
        ]);
    }

    return $order;
}

// ============================================================
// belongsTo — $item->product->name
// ============================================================

it('returns translation when product is accessed via belongsTo', function () {
    $product = makeProduct(['name' => ['en' => 'Laptop', 'fr' => 'Ordinateur']]);
    $order   = makeOrder([$product]);

    $item = OrderItem::with('product')->find(
        OrderItem::where('order_id', $order->id)->first()->id
    );

    app()->setLocale('fr');
    expect($item->product->name)->toBe('Ordinateur');
});

it('returns _translations when product is accessed via belongsTo', function () {
    $product = makeProduct(['name' => ['en' => 'Laptop', 'fr' => 'Ordinateur']]);
    $order   = makeOrder([$product]);

    $item = OrderItem::with('product')->find(
        OrderItem::where('order_id', $order->id)->first()->id
    );

    expect($item->product->name_translations)
        ->toHaveKeys(['en', 'fr'])
        ->and($item->product->name_translations['fr'])->toBe('Ordinateur');
});

it('lazy loads translations when product accessed via belongsTo without eager loading', function () {
    $product = makeProduct(['name' => ['en' => 'Laptop']]);
    $order   = makeOrder([$product]);

    // No eager loading — simulate raw relationship access
    $item = OrderItem::withoutGlobalScope('withTranslations')
        ->find(OrderItem::where('order_id', $order->id)->first()->id);

    app()->setLocale('en');
    expect($item->product->name)->toBe('Laptop');
});

// ============================================================
// hasMany — $order->items->each product translation
// ============================================================

it('returns translation for each product accessed via hasMany items', function () {
    $laptop  = makeProduct(['name' => ['en' => 'Laptop', 'fr' => 'Ordinateur']]);
    $monitor = makeProduct(['name' => ['en' => 'Monitor', 'fr' => 'Écran']]);
    $order   = makeOrder([$laptop, $monitor]);

    $items = Order::find($order->id)->items()->with('product')->get();

    app()->setLocale('fr');
    expect($items->first()->product->name)->toBe('Ordinateur')
        ->and($items->last()->product->name)->toBe('Écran');
});

it('returns _translations for each product accessed via hasMany items', function () {
    $laptop  = makeProduct(['name' => ['en' => 'Laptop', 'fr' => 'Ordinateur']]);
    $monitor = makeProduct(['name' => ['en' => 'Monitor', 'fr' => 'Écran']]);
    $order   = makeOrder([$laptop, $monitor]);

    $items = Order::find($order->id)->items()->with('product')->get();

    expect($items->first()->product->name_translations)->toHaveKeys(['en', 'fr'])
        ->and($items->last()->product->name_translations['fr'])->toBe('Écran');
});

it('applies fallback strategy when product accessed via relationship has no translation for locale', function () {
    config()->set('translatable.fallback', 'app');
    config()->set('app.fallback_locale', 'en');

    $product = makeProduct(['name' => ['en' => 'Laptop']]);
    $order   = makeOrder([$product]);

    $item = OrderItem::with('product')->find(
        OrderItem::where('order_id', $order->id)->first()->id
    );

    app()->setLocale('de');
    expect($item->product->name)->toBe('Laptop');
});