<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Food;
use App\Models\Order;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ---------- Users ----------
        User::create([
            'name' => 'Admin',
            'email' => 'admin@zaiqa.com',
            'phone' => '0300-1234567',
            'password' => 'admin123',
            'is_admin' => true,
        ]);

        $customer = User::create([
            'name' => 'Ali Raza',
            'email' => 'ali@example.com',
            'phone' => '0321-7654321',
            'address' => 'House 12, Street 4, Model Town',
            'password' => 'password',
        ]);

        // ---------- Categories & Foods ----------
        $menu = [
            ['Desi Karahi & Handi', 'desi-karahi-handi', 'Rich, slow-cooked desi curries served with naan.', [
                ['Butter Chicken', 'Tender chicken in a silky tomato, butter and cream gravy.', 1250, 'butter-chicken', true, false],
                ['Chicken Handi', 'Boneless chicken cooked in a clay handi with yogurt and green chillies.', 1450, 'chicken-handi', false, true],
                ['Chicken Tikka Masala', 'Char-grilled tikka pieces in a spiced masala sauce.', 1350, 'chicken-tikka-masala', true, true],
                ['Chicken Kofta Curry', 'Juicy minced chicken koftas in a homestyle curry.', 1150, 'chicken-kofta-curry', false, false],
            ]],
            ['Biryani & Rice', 'biryani-rice', 'Fragrant basmati rice dishes, the pride of our kitchen.', [
                ['Chicken Biryani', 'Layered basmati, spicy chicken masala, saffron and fried onions.', 650, 'chicken-biryani', true, true],
                ['Mutton Biryani', 'Slow-cooked mutton dum biryani with aromatic spices.', 950, 'mutton-biryani', false, true],
                ['Sindhi Biryani', 'Tangy, spicy Sindhi style biryani with potatoes and plums.', 700, 'sindhi-biryani', false, true],
                ['Egg Fried Rice', 'Wok-tossed rice with egg, peas and carrots.', 550, 'egg-fried-rice', false, false],
                ['Chicken Fried Rice', 'Chinese style fried rice with chicken and vegetables.', 650, 'chicken-fried-rice', false, false],
                ['Vegetable Pulao', 'Light and fragrant pulao with garden vegetables.', 450, 'vegetable-pulao', false, false],
            ]],
            ['Burgers', 'burgers', 'Juicy, stacked and made fresh to order.', [
                ['Zinger Burger', 'Crispy fried chicken fillet, lettuce and our signature mayo.', 590, 'zinger-burger', true, false],
                ['Double Beef Smash', 'Two smashed beef patties, double cheese and pickles.', 890, 'double-beef-smash', true, false],
                ['Grilled Chicken Burger', 'Flame-grilled chicken, fresh veggies and garlic sauce.', 650, 'grilled-chicken-burger', false, false],
            ]],
            ['Pizza', 'pizza', 'Hand-tossed dough, baked hot in our oven.', [
                ['Pepperoni Pizza', 'Loaded with beef pepperoni and mozzarella. (Medium)', 1399, 'pepperoni-pizza', true, false],
                ['Fajita Supreme Pizza', 'Chicken fajita, olives, capsicum and onions. (Medium)', 1299, 'fajita-supreme-pizza', false, true],
                ['Margherita Pizza', 'Classic tomato sauce, fresh mozzarella and basil. (Medium)', 1099, 'margherita-pizza', false, false],
            ]],
            ['Pasta', 'pasta', 'Italian favourites with a desi twist.', [
                ['Penne Arrabbiata', 'Penne in a fiery garlic and tomato sauce.', 850, 'penne-arrabbiata', false, true],
                ['Creamy Chicken Pasta', 'Chicken and mushrooms in a creamy white sauce.', 950, 'creamy-chicken-pasta', true, false],
                ['Spaghetti Bolognese', 'Spaghetti with slow-cooked beef ragu and parmesan.', 990, 'spaghetti-bolognese', false, false],
            ]],
            ['Starters', 'starters', 'Perfect little bites to start your meal.', [
                ['Aloo Samosa (4 pcs)', 'Crispy samosas stuffed with spiced potatoes, served with chutney.', 250, 'aloo-samosa', false, true],
                ['Chicken Samosa Platter', 'Six chicken keema samosas with mint and imli chutney.', 450, 'chicken-samosa-platter', false, false],
            ]],
            ['Desserts', 'desserts', 'A sweet ending to every meal.', [
                ['Berry Cupcakes (2 pcs)', 'Soft vanilla cupcakes topped with berry cream.', 390, 'berry-cupcakes', false, false],
                ['Chocolate Muffins (2 pcs)', 'Rich chocolate muffins with a molten centre.', 420, 'chocolate-muffins', true, false],
                ['Apple Pastry', 'Flaky pastry filled with warm cinnamon apples.', 350, 'apple-pastry', false, false],
            ]],
        ];

        foreach ($menu as $i => [$name, $slug, $description, $foods]) {
            $category = Category::create([
                'name' => $name,
                'slug' => $slug,
                'description' => $description,
                'image' => "uploads/categories/{$slug}.jpg",
                'sort_order' => $i + 1,
            ]);

            foreach ($foods as [$foodName, $foodDesc, $price, $image, $featured, $spicy]) {
                $category->foods()->create([
                    'name' => $foodName,
                    'slug' => Str::slug($foodName),
                    'description' => $foodDesc,
                    'price' => $price,
                    'image' => "uploads/foods/{$image}.jpg",
                    'is_featured' => $featured,
                    'is_spicy' => $spicy,
                ]);
            }
        }

        // ---------- Sample orders (so the dashboard is not empty) ----------
        $samples = [
            ['Ali Raza', '0321-7654321', $customer->id, ['chicken-biryani' => 2, 'zinger-burger' => 1], 'delivered', 3],
            ['Sara Khan', '0333-1112233', null, ['pepperoni-pizza' => 1, 'aloo-samosa' => 2], 'preparing', 1],
            ['Usman Tariq', '0345-9988776', null, ['butter-chicken' => 1, 'chicken-fried-rice' => 1], 'pending', 0],
            ['Ali Raza', '0321-7654321', $customer->id, ['creamy-chicken-pasta' => 1, 'chocolate-muffins' => 1], 'pending', 0],
        ];

        foreach ($samples as [$name, $phone, $userId, $items, $status, $daysAgo]) {
            $subtotal = 0;
            $lines = [];
            foreach ($items as $slug => $qty) {
                $food = Food::where('image', "uploads/foods/{$slug}.jpg")->firstOrFail();
                $lines[] = ['food_id' => $food->id, 'food_name' => $food->name, 'price' => $food->price, 'quantity' => $qty, 'total' => $food->price * $qty];
                $subtotal += $food->price * $qty;
            }
            $fee = $subtotal >= 2000 ? 0 : 150;

            $order = Order::create([
                'order_number' => Order::generateNumber(),
                'user_id' => $userId,
                'customer_name' => $name,
                'phone' => $phone,
                'address' => 'Main Boulevard, Gulberg',
                'subtotal' => $subtotal,
                'delivery_fee' => $fee,
                'total' => $subtotal + $fee,
                'status' => $status,
            ]);
            $order->items()->createMany($lines);
            $order->created_at = now()->subDays($daysAgo)->subHours(rand(1, 5));
            $order->save();
        }

        // ---------- Sample reservations & messages ----------
        Reservation::create([
            'user_id' => $customer->id, 'name' => 'Ali Raza', 'email' => 'ali@example.com', 'phone' => '0321-7654321',
            'reservation_date' => now()->addDays(2)->toDateString(), 'reservation_time' => '20:00', 'guests' => 4,
            'message' => 'Birthday dinner, please arrange a corner table.', 'status' => 'pending',
        ]);
        Reservation::create([
            'name' => 'Hina Ahmed', 'email' => 'hina@example.com', 'phone' => '0300-5556677',
            'reservation_date' => now()->addDay()->toDateString(), 'reservation_time' => '13:30', 'guests' => 2,
            'status' => 'approved',
        ]);

        Contact::create([
            'name' => 'Bilal Hussain', 'email' => 'bilal@example.com', 'subject' => 'Catering inquiry',
            'message' => 'Do you offer catering for an office event of around 50 people?',
        ]);
    }
}
