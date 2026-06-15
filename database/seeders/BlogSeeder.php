<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        // Create categories
        $categories = [
            ['name' => 'Recipes',          'slug' => 'recipes'],
            ['name' => 'Street Food',      'slug' => 'street-food'],
            ['name' => 'Chef Stories',     'slug' => 'chef-stories'],
            ['name' => 'Franchise Tips',   'slug' => 'franchise-tips'],
            ['name' => 'Health & Nutrition','slug' => 'health-nutrition'],
            ['name' => 'Company News',     'slug' => 'company-news'],
        ];

        foreach ($categories as $cat) {
            BlogCategory::firstOrCreate(['slug' => $cat['slug']], $cat);
        }

        $recipesCat   = BlogCategory::where('slug', 'recipes')->first();
        $streetCat    = BlogCategory::where('slug', 'street-food')->first();
        $chefCat      = BlogCategory::where('slug', 'chef-stories')->first();
        $franchiseCat = BlogCategory::where('slug', 'franchise-tips')->first();
        $healthCat    = BlogCategory::where('slug', 'health-nutrition')->first();
        $newsCat      = BlogCategory::where('slug', 'company-news')->first();

        $adminUser = User::first();
        if (!$adminUser) return;

        $posts = [
            [
                'blog_category_id' => $recipesCat->id,
                'title'            => 'The Secret Behind Perfect Steamed Momos — A Chef\'s Guide',
                'excerpt'          => 'Discover the step-by-step process our kitchen masters use to create perfectly soft, juicy momos every time.',
                'content'          => "Every momo lover knows the difference between a good momo and a great one. It's all in the dough texture, the filling balance, and — most importantly — the steaming technique.\n\n**The Dough**\nUse all-purpose flour (maida) with just the right amount of warm water. Knead for 10 minutes until smooth and elastic. Let it rest for 30 minutes under a damp cloth.\n\n**The Filling**\nFor our signature chicken momo:\n- 500g minced chicken\n- 2 tbsp finely grated ginger-garlic paste\n- 1 cup finely chopped cabbage (squeeze out excess water)\n- 2 green onions, minced\n- 2 tbsp soy sauce\n- 1 tsp sesame oil\n- Salt & pepper to taste\n\nMix everything gently — never overmix, as it toughens the filling.\n\n**The Fold**\nRoll dough into 3-inch circles. Place 1 tablespoon filling in the center. Use the traditional 'pleating' technique — fold and pleat 12-15 times for a tight, leak-proof seal.\n\n**Steaming**\nLine your steamer basket with cabbage leaves (prevents sticking). Steam on high for exactly 12 minutes. The skin should be translucent and slightly glossy.\n\n**The Chutney**\nRoast 4 dried red chilies, 3 tomatoes, and 1 head of garlic. Blend with rock salt and a drizzle of mustard oil. This is non-negotiable.\n\nFollow these steps and you'll have restaurant-quality momos in your own kitchen.",
                'image'            => 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?auto=format&fit=crop&w=1200&q=80',
                'is_published'     => true,
                'published_at'     => now()->subDays(2),
                'views'            => 1847,
            ],
            [
                'blog_category_id' => $streetCat->id,
                'title'            => 'How Momo Culture Took Over Indian Street Food Scene',
                'excerpt'          => 'From Tibetan highlands to Delhi lanes — the fascinating journey of momos becoming India\'s favorite street snack.',
                'content'          => "If you walk through any major Indian city today, you will find a momo stall on almost every second corner. But this wasn't always the case.\n\n**Origins**\nMomos trace their roots to Tibet, Nepal, and Sikkim — Himalayan communities who perfected this simple dumpling over centuries. The dish was traditionally made during festivals and family gatherings.\n\n**The Delhi Revolution**\nIn the 1990s, Tibetan refugees settling in Delhi's Majnu Ka Tilla brought momos to the capital. By 2005, the humble steamer had migrated from refugee settlements to IIT campuses, then to every railway station in India.\n\n**Why India Fell in Love**\nMomos are:\n- Affordable (₹30–80 for a plate)\n- Customizable (veg, chicken, paneer, cheese)\n- Shareable — perfect for India's communal eating culture\n- Spicy when paired with the right chutney\n\n**The Modern Momo Economy**\nToday, the momo industry in India is estimated at over ₹3,000 crore annually. GOS MOMO is proud to be a part of this revolution — taking this beloved street food and elevating it with consistent quality and hygiene.\n\nFrom the streets of Lhasa to your plate in Gurugram, the momo journey is nothing short of incredible.",
                'image'            => 'https://images.unsplash.com/photo-1567982047351-76b6f93e38fe?auto=format&fit=crop&w=1200&q=80',
                'is_published'     => true,
                'published_at'     => now()->subDays(5),
                'views'            => 3241,
            ],
            [
                'blog_category_id' => $chefCat->id,
                'title'            => 'Meet Chef Rajan: 18 Years of Momo Mastery',
                'excerpt'          => 'Our head chef shares his journey from a small Sikkim kitchen to training 50+ GOS MOMO kitchen teams across India.',
                'content'          => "Chef Rajan Sherpa doesn't measure ingredients. After 18 years, his hands just know.\n\n\"When you've made 10,000 momos, your fingers feel the right dough. It's like a musician playing without reading notes,\" he says, laughing.\n\n**From Gangtok to Gurgaon**\nRajan grew up watching his mother make momos every Sunday morning in Gangtok, Sikkim. The family had a small dhaba near the market — open 6 AM to noon, sold out by 9 AM.\n\nAt 16, he moved to Delhi to pursue a hospitality diploma. He worked in 5-star hotel kitchens for 8 years — Hyatt, Marriott, ITC — learning the science behind great food.\n\n\"Hotel food taught me precision. But street food taught me soul,\" Rajan reflects.\n\n**Joining GOS MOMO**\nIn 2019, Rajan joined GOS MOMO as Head Chef. His mandate: standardize every recipe so a momo in Jaipur tastes identical to one in Kolkata.\n\n\"We spent 3 months testing dough ratios, steaming times, chutney recipes. We created what we call The GOS Bible — every recipe documented to the gram.\"\n\n**His Advice to Aspiring Chefs**\n\"Never skip the basics. Master one thing completely before moving to the next. And taste everything — every single day.\"\n\nToday, Chef Rajan has trained over 50 kitchen teams across 4 cities. His legacy is in every momo that leaves a GOS MOMO kitchen.",
                'image'            => 'https://images.unsplash.com/photo-1577219491135-ce391730fb2c?auto=format&fit=crop&w=1200&q=80',
                'is_published'     => true,
                'published_at'     => now()->subDays(8),
                'views'            => 2156,
            ],
            [
                'blog_category_id' => $franchiseCat->id,
                'title'            => '5 Reasons Why a GOS MOMO Franchise is India\'s Smartest Investment in 2025',
                'excerpt'          => 'With low investment, high margins, and a proven system — here\'s why entrepreneurs are choosing GOS MOMO over other F&B brands.',
                'content'          => "Starting a food business in India is exciting — and risky. Most first-time entrepreneurs lose money before they find their footing. The GOS MOMO franchise model is designed to eliminate that risk.\n\n**1. Proven Unit Economics**\nOur franchise partners recover their investment within 12-18 months on average. Monthly EBITDA margins of 22-28% are consistently achieved across our network.\n\n**2. No Cooking Experience Required**\nOur training program is comprehensive. We train your staff in the GOS Method over 7 days at our central kitchen. You manage the business; we handle the recipe.\n\n**3. Central Supply Chain**\nWe supply all key ingredients — dough, fillings, sauces — from our central kitchen. This ensures consistency and saves you procurement headaches.\n\n**4. Tech-Powered Operations**\nEvery franchise gets access to our POS system, inventory management, and customer loyalty app. You see your numbers in real time.\n\n**5. Brand Power**\nGOS MOMO has 50,000+ Instagram followers, 4.6 stars on Google across all outlets, and a loyal repeat customer base. You inherit this brand equity on day one.\n\n**Investment Details**\n- Kiosk model: ₹8–12 lakhs\n- Dine-in café: ₹18–25 lakhs\n- Master franchise territory: ₹45 lakhs+\n\nInterested? Fill out our franchise inquiry form and our team will connect within 48 hours.",
                'image'            => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?auto=format&fit=crop&w=1200&q=80',
                'is_published'     => true,
                'published_at'     => now()->subDays(12),
                'views'            => 4892,
            ],
            [
                'blog_category_id' => $healthCat->id,
                'title'            => 'Are Momos Healthy? The Nutritional Truth Nobody Tells You',
                'excerpt'          => 'Momos have a bad reputation for being junk food. Here\'s what the science actually says — and how to eat them guilt-free.',
                'content'          => "Momos often get lumped into the \"street food junk\" category. But the truth is far more nuanced — and encouraging.\n\n**What's Actually in a Momo?**\nA standard 6-piece steamed chicken momo contains approximately:\n- Calories: 210–240 kcal\n- Protein: 14–16g\n- Carbohydrates: 22–26g\n- Fat: 5–7g\n\nFor comparison, a burger has 450–600 kcal with far less protein.\n\n**Steaming: The Healthiest Cooking Method**\nSteaming preserves nutrients that frying destroys. Steamed momos retain B vitamins, iron, and zinc from the meat filling.\n\n**The Vegetable Advantage**\nOur veg momos contain cabbage, carrot, and coriander — all nutrient-dense vegetables. Cabbage, in particular, is high in Vitamin K and C.\n\n**The Chutney Factor**\nTomato-based chutney provides lycopene (a powerful antioxidant). Ginger in the filling has well-documented anti-inflammatory properties.\n\n**Where to Be Careful**\n- Fried momos (double the calories)\n- Mayonnaise-based dips\n- Over-salted fillings from cheap vendors\n\n**The GOS MOMO Difference**\nWe use fresh ingredients daily. No MSG, no artificial preservatives. Our steamed momo is genuinely one of the healthier fast-food options you can choose.\n\nSo yes — you can enjoy your momos without guilt. Just skip the fried version.",
                'image'            => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&w=1200&q=80',
                'is_published'     => true,
                'published_at'     => now()->subDays(18),
                'views'            => 6103,
            ],
            [
                'blog_category_id' => $newsCat->id,
                'title'            => 'GOS MOMO Expands to 3 New Cities — Jaipur, Pune & Ahmedabad',
                'excerpt'          => 'We\'re thrilled to announce our biggest expansion yet. Here\'s everything you need to know about our new outlets.',
                'content'          => "2025 is our biggest year yet. GOS MOMO is officially launching in Jaipur, Pune, and Ahmedabad — bringing our signature steamed momos to 3 new cities.\n\n**Why These Cities?**\nOur data showed consistent demand from customers in Rajasthan, Maharashtra, and Gujarat. Jaipur's growing young population and tourism traffic make it ideal. Pune's tech corridor means high footfall and corporate catering potential. Ahmedabad's street food culture is a perfect fit for our brand.\n\n**The Locations**\n- **Jaipur**: Pink Pearl Mall, Vaishali Nagar (opening June 2025)\n- **Pune**: Koregaon Park (opening July 2025)\n- **Ahmedabad**: SG Highway (opening August 2025)\n\n**What's New**\nEach new outlet will feature our latest store design — open kitchen concept, digital menus, QR-code ordering, and our new loyalty program integration.\n\n**New Menu Items**\nWe're also launching 3 city-exclusive flavors:\n- Jaipur: Laal Maas Momo (spicy lamb, Rajasthani spices)\n- Pune: Green Garlic Chicken Momo\n- Ahmedabad: Gujarati Kheema Momo (sweet-spicy profile)\n\nFollow us on Instagram @gosmomoofficial for grand opening updates, giveaways, and first-look videos.\n\nWe can't wait to serve you!",
                'image'            => 'https://images.unsplash.com/photo-1559136555-9303baea8ebd?auto=format&fit=crop&w=1200&q=80',
                'is_published'     => true,
                'published_at'     => now()->subDays(3),
                'views'            => 2789,
            ],
            [
                'blog_category_id' => $recipesCat->id,
                'title'            => 'Paneer & Spinach Momo: The Vegetarian Recipe That Converts Meat Lovers',
                'excerpt'          => 'This creamy, flavorful paneer momo filling is so good, even our non-vegetarian fans order it every time.',
                'content'          => "Our paneer momo is the most reordered item on our vegetarian menu. Here's the exact recipe.\n\n**For the Filling (makes 20 momos):**\n- 200g fresh paneer, crumbled\n- 1 cup baby spinach, blanched and squeezed dry, then chopped\n- 2 green chilies, finely chopped\n- 1 tbsp grated ginger\n- 2 tbsp cream cheese (optional, but makes it ultra creamy)\n- 1 tsp cumin powder\n- ½ tsp garam masala\n- Salt to taste\n- 1 tbsp finely chopped coriander\n\n**Method:**\n1. Mix all filling ingredients in a bowl. Taste and adjust seasoning.\n2. The filling should hold its shape when pressed — if too wet, add a tablespoon of breadcrumbs.\n3. Roll momo dough into circles, add 1 heaped teaspoon of filling.\n4. Pleat and seal tightly.\n5. Steam for 10 minutes (paneer cooks faster than meat).\n\n**Serving Suggestion:**\nPair with our green coriander chutney — blend 1 cup coriander, 3 green chilies, 2 garlic cloves, lemon juice, and a pinch of salt.\n\nThe creaminess of paneer against the bright chutney is absolutely addictive. Trust us — this will become your new favorite.",
                'image'            => 'https://images.unsplash.com/photo-1574484284002-952d92456975?auto=format&fit=crop&w=1200&q=80',
                'is_published'     => true,
                'published_at'     => now()->subDays(21),
                'views'            => 3456,
            ],
            [
                'blog_category_id' => $franchiseCat->id,
                'title'            => 'What Our Franchise Partners Are Saying: Real Success Stories',
                'excerpt'          => 'Three GOS MOMO franchise partners share their experience, challenges, and monthly revenue numbers — honestly.',
                'content'          => "We believe in transparency. Here are three unedited stories from our franchise partners.\n\n---\n\n**Priya Mehta, GOS MOMO Noida (Kiosk model)**\n\"I was a corporate HR manager for 12 years. I wanted to start my own business but was terrified. GOS MOMO gave me the courage — the training, the support, and an established brand. My kiosk in DLF Mall of India crossed ₹4 lakh monthly revenue in the 3rd month. I'm now looking at a second kiosk.\"\n\n---\n\n**Arjun & Kavitha Rao, GOS MOMO Bangalore (Café model)**\n\"We opened our café in Koramangala in October 2024. It wasn't easy — first two months were slow. But the GOS team was on WhatsApp every day, helping us with everything from staff hiring to Instagram marketing. By December, we were profitable. We do ₹8–9 lakh a month now. The margins are real.\"\n\n---\n\n**Mohammed Yusuf, GOS MOMO Hyderabad (Kiosk model)**\n\"The best decision of my life. I was skeptical about the investment initially. But the ROI calculation they showed me was accurate — I recouped my ₹10 lakh investment in 14 months. My staff loves working here. The brand is strong. People trust GOS MOMO.\"\n\n---\n\nEvery partner's journey is different. But the common thread is: with hard work and the right system, this works.\n\nApply for a franchise today and our team will share detailed financial projections for your city.",
                'image'            => 'https://images.unsplash.com/photo-1521791136064-7986c2920216?auto=format&fit=crop&w=1200&q=80',
                'is_published'     => false,
                'published_at'     => null,
                'views'            => 0,
            ],
        ];

        foreach ($posts as $post) {
            Blog::firstOrCreate(
                ['title' => $post['title']],
                array_merge($post, [
                    'user_id' => $adminUser->id,
                    'slug'    => Str::slug($post['title']),
                ])
            );
        }
    }
}
