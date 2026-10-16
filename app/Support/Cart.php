<?php

namespace App\Support;

use App\Models\Food;
use Illuminate\Support\Collection;

/**
 * Simple session based shopping cart.
 * Session format: ['cart' => [food_id => quantity, ...]]
 */
class Cart
{
    public const DELIVERY_FEE = 150;
    public const FREE_DELIVERY_ABOVE = 2000;
    public const MAX_QTY = 20;

    public static function raw(): array
    {
        return session('cart', []);
    }

    public static function add(int $foodId, int $qty = 1): void
    {
        $cart = self::raw();
        $cart[$foodId] = min(self::MAX_QTY, ($cart[$foodId] ?? 0) + max(1, $qty));
        session(['cart' => $cart]);
    }

    public static function update(int $foodId, int $qty): void
    {
        $cart = self::raw();
        if ($qty <= 0) {
            unset($cart[$foodId]);
        } else {
            $cart[$foodId] = min(self::MAX_QTY, $qty);
        }
        session(['cart' => $cart]);
    }

    public static function remove(int $foodId): void
    {
        self::update($foodId, 0);
    }

    public static function clear(): void
    {
        session()->forget('cart');
    }

    /** Number of items (sum of quantities) - used for the navbar badge. */
    public static function count(): int
    {
        return array_sum(self::raw());
    }

    /** Cart lines with fresh prices from the database. */
    public static function items(): Collection
    {
        $cart = self::raw();
        if (empty($cart)) {
            return collect();
        }

        $foods = Food::whereIn('id', array_keys($cart))->where('is_available', true)->get()->keyBy('id');

        // drop items that were deleted / made unavailable by the admin
        $clean = array_intersect_key($cart, $foods->all());
        if (count($clean) !== count($cart)) {
            session(['cart' => $clean]);
        }

        return collect($clean)->map(fn ($qty, $id) => (object) [
            'food' => $foods[$id],
            'quantity' => $qty,
            'total' => $foods[$id]->price * $qty,
        ])->values();
    }

    public static function subtotal(?Collection $items = null): float
    {
        return (float) ($items ?? self::items())->sum('total');
    }

    public static function deliveryFee(float $subtotal): float
    {
        return ($subtotal == 0 || $subtotal >= self::FREE_DELIVERY_ABOVE) ? 0 : self::DELIVERY_FEE;
    }
}
