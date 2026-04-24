<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Banner;
use App\Models\FlashSale;
use App\Models\Combo;
use App\Models\HomeSection;
use App\Models\SareeEditSetting;
use App\Models\JewelleryExperienceSetting;
use App\Models\JustInExperience;
use App\Models\PriceBand;
use App\Models\HomeStyle;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    private function bestBuyCardsData(): array
    {
        return [
            [
                'slug' => 'shimmer-silver-party-dress',
                'title' => 'Shimmer Silver Party Dress',
                'description' => 'Elegant sleeveless shimmer dress with a soft pleated skirt',
                'price' => 699,
                'sku' => 'AVN-BB-0001',
                'image' => asset('images/best-buy/shimmer-silver-party-dress.png'),
            ],
            [
                'slug' => 'glam-black-sequin-dress',
                'title' => 'Glam Black Sequin Dress',
                'description' => 'Stylish sequin dress with a statement overlay and sling bag detail',
                'price' => 699,
                'sku' => 'AVN-BB-0002',
                'image' => asset('images/best-buy/glam-black-sequin-dress.png'),
            ],
            [
                'slug' => 'casual-chic-denim-set',
                'title' => 'Casual Chic Denim Set',
                'description' => 'Trendy shirt & denim combo for everyday stylish looks',
                'price' => 699,
                'sku' => 'AVN-BB-0003',
                'image' => asset('images/best-buy/casual-chic-denim-set.png'),
            ],
            [
                'slug' => 'ethnic-charm-festive-dress',
                'title' => 'Ethnic Charm Festive Dress',
                'description' => 'Traditional printed dress with rich colors for festive wear',
                'price' => 599,
                'sku' => 'AVN-BB-0004',
                'image' => asset('images/best-buy/ethnic-charm-festive-dress.png'),
            ],
            [
                'slug' => 'classic-peach-layered-frock',
                'title' => 'Classic Peach Layered Frock',
                'description' => 'Elegant layered tulle dress for special occasions',
                'price' => 349,
                'sku' => 'AVN-BB-0005',
                'image' => asset('images/best-buy/classic-peach-layered-frock.png'),
            ],
            [
                'slug' => 'floral-garden-party-dress',
                'title' => 'Floral Garden Party Dress',
                'description' => 'Soft printed frock perfect for outdoor playdates and birthdays',
                'price' => 449,
                'sku' => 'AVN-BB-0006',
                'image' => asset('images/best-buy/floral-garden-party-dress.png'),
            ],
            [
                'slug' => 'twinkle-pink-party-dress',
                'title' => 'Twinkle Pink Party Dress',
                'description' => 'Charming dual-tone dress with a shimmer bodice and layered tulle skirt',
                'price' => 599,
                'sku' => 'AVN-BB-0007',
                'image' => asset('images/best-buy/twinkle-pink-party-dress.png'),
            ],
            [
                'slug' => 'blush-bloom-ethnic-set',
                'title' => 'Blush Bloom Ethnic Set',
                'description' => 'Elegant floral printed kurta set with soft frill detailing, perfect for festive and traditional wear',
                'price' => 699,
                'sku' => 'AVN-BB-0008',
                'image' => asset('images/best-buy/blush-bloom-ethnic-set.png'),
            ],
        ];
    }

    private function fallbackTestimonials(): \Illuminate\Support\Collection
    {
        return collect([
            ['user_name' => 'Meena Sharma', 'location' => 'Bangalore, India', 'comment' => 'Absolutely in love with AVNEE\'s collection! My daughter looked like a fairy princess. The quality is top-notch and there are so many beautiful options for little girls.'],
            ['user_name' => 'Latha Iyer', 'location' => 'Chennai, India', 'comment' => 'AVNEE Collection never disappoints! Every dress is adorable and comfortable. My daughter is super happy with her new dress and so are we. Highly recommend!'],
            ['user_name' => 'Priya Patel', 'location' => 'Hyderabad, Telangana', 'comment' => 'The dress I got for my daughter\'s first birthday was absolutely perfect. She looked like a little angel and we got so many compliments.'],
            ['user_name' => 'Kavya Nair', 'location' => 'Kochi, India', 'comment' => 'The detailing on the dress is just wow! It looks even better in real life. My daughter felt like a princess and kept admiring herself in the mirror.'],
            ['user_name' => 'Sneha Reddy', 'location' => 'Bangalore, India', 'comment' => 'AVNEE has become my go-to for all special occasions! The outfits are not just beautiful but super comfy for kids.'],
            ['user_name' => 'Aishwarya Rao', 'location' => 'Bangalore, India', 'comment' => 'Such a dreamy little dress! The soft floral print and flowy layers make it perfect for sunny days.'],
            ['user_name' => 'Riya Mehta', 'location' => 'Mumbai, India', 'comment' => 'I can\'t stop smiling every time my daughter wears her AVNEE dress. It\'s soft, pretty, and perfect for tiny little twirls.'],
            ['user_name' => 'Pooja Verma', 'location' => 'Delhi, India', 'comment' => 'Such adorable designs for little girls! The fit was perfect and the fabric felt so gentle on my baby\'s skin.'],
            ['user_name' => 'Divya Menon', 'location' => 'Kochi, India', 'comment' => 'Such a cute and comfy everyday dress! The fabric is so soft and perfect for my baby to move around freely.'],
        ])->map(fn(array $row) => (object) array_merge($row, ['image' => null, 'product' => null]));
    }

    /**
     * Show the main Studio homepage (welcome)
     */
    public function index()
    {
        session(['theme' => 'studio', 'brand_id' => 1]); // ID 1 is AVNEE Studio
        $popularPieces = Product::where('is_active', true)->where('brand_id', 1)->inRandomOrder()->take(5)->get();
        $newArrivals = Product::where('is_active', true)->where('brand_id', 1)->latest()->take(5)->get();
        $banners = Banner::where('is_active', true)->where('location', 'home_top')->orderBy('sort_order')->get();
        $firstSaleBanners = Banner::where('is_active', true)->where('location', 'home_first_sale')->orderBy('sort_order')->take(6)->get();
        $activeFlashSale = \App\Models\FlashSale::where('is_active', true)
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            ->with(['products' => function($q) {
                $q->where('is_active', true)->where('brand_id', 1);
            }])
            ->first();
        $combos = Combo::where('is_active', true)->with('products')->latest()->get();
        $homeSections = HomeSection::where('is_active', true)->where('brand_id', 1)->orderBy('sort_order')->get();
        $sareeEdit = SareeEditSetting::first();
        $justInExperiences = JustInExperience::where('brand_id', 1)->get();
        $priceBands = PriceBand::where('brand_id', 1)->get();
        $homeStyles = HomeStyle::where('brand_id', 1)->where('is_active', true)->orderBy('sort_order')->get();
        $reviews = \App\Models\Review::where('brand_id', 1)->where('status', 'approved')->with('product', 'user')->latest()->take(9)->get();
        if ($reviews->count() < 9) {
            $reviews = $reviews->concat($this->fallbackTestimonials()->take(9 - $reviews->count()));
        }
        $brandExperiences = \App\Models\BrandExperience::where('brand_id', 1)->where('is_active', true)->orderBy('sort_order')->get();
        $blogPosts = BlogPost::where('is_published', true)->where('is_on_home', true)->latest()->take(3)->get();
        if ($blogPosts->isEmpty()) {
            $blogPosts = BlogPost::where('is_published', true)->latest()->take(3)->get();
        }
        $exploreGrids = \App\Models\HomeExploreGrid::where('brand_id', 1)->where('is_active', true)->orderBy('sort_order')->get();
        if ($exploreGrids->isEmpty()) { $exploreGrids = collect(); }

        return view('welcome', compact('popularPieces', 'newArrivals', 'banners', 'firstSaleBanners', 'activeFlashSale', 'combos', 'homeSections', 'sareeEdit', 'justInExperiences', 'priceBands', 'homeStyles', 'reviews', 'brandExperiences', 'blogPosts', 'exploreGrids'));
    }

    /**
     * Show the Jewellery storefront homepage
     */
    public function jewellery()
    {
        session(['theme' => 'jewellery', 'brand_id' => 2]); // ID 2 is AVNEE Jewellery
        $popularPieces = Product::where('is_active', true)->where('brand_id', 2)->inRandomOrder()->take(5)->get();
        $newArrivals = Product::where('is_active', true)->where('brand_id', 2)->latest()->take(5)->get();
        $banners = Banner::where('is_active', true)->where('location', 'jewellery_top')->orderBy('sort_order')->get();
        $firstSaleBanners = Banner::where('is_active', true)->where('location', 'jewellery_first_sale')->orderBy('sort_order')->take(6)->get();
        $activeFlashSale = \App\Models\FlashSale::where('is_active', true)
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            ->with(['products' => function($q) {
                $q->where('is_active', true)->where('brand_id', 2);
            }])
            ->first();
        $combos = Combo::where('is_active', true)->with('products')->latest()->get();
        $homeSections = HomeSection::where('is_active', true)->where('brand_id', 2)->orderBy('sort_order')->get();
        $jewelleryExperience = JewelleryExperienceSetting::first();
        $justInExperiences = JustInExperience::where('brand_id', 2)->get();
        $priceBands = PriceBand::where('brand_id', 2)->get();
        $homeStyles = HomeStyle::where('brand_id', 2)->where('is_active', true)->orderBy('sort_order')->get();
        $reviews = \App\Models\Review::where('brand_id', 2)->where('status', 'approved')->with('product', 'user')->latest()->take(9)->get();
        if ($reviews->count() < 9) {
            $reviews = $reviews->concat($this->fallbackTestimonials()->take(9 - $reviews->count()));
        }
        $brandExperiences = \App\Models\BrandExperience::where('brand_id', 2)->where('is_active', true)->orderBy('sort_order')->get();
        $blogPosts = BlogPost::where('is_published', true)->where('is_on_home', true)->latest()->take(3)->get();
        if ($blogPosts->isEmpty()) {
            $blogPosts = BlogPost::where('is_published', true)->latest()->take(3)->get();
        }
        $exploreGrids = \App\Models\HomeExploreGrid::where('brand_id', 2)->where('is_active', true)->orderBy('sort_order')->get();
        if ($exploreGrids->isEmpty()) { $exploreGrids = collect(); }

        return view('jewellery', compact('popularPieces', 'newArrivals', 'banners', 'firstSaleBanners', 'activeFlashSale', 'combos', 'homeSections', 'jewelleryExperience', 'justInExperiences', 'priceBands', 'homeStyles', 'reviews', 'brandExperiences', 'blogPosts', 'exploreGrids'));
    }

    /**
     * Dedicated studio sale page.
     */
    public function sale()
    {
        session(['theme' => 'studio', 'brand_id' => 1]);

        $dressCategorySlugs = ['party-frocks', 'festive-wear', 'girls-dresses', 'infant-sets', '2-4-years', '4-6-years', '6-14-years'];

        $saleProducts = Product::query()
            ->where('is_active', true)
            ->where('brand_id', 1)
            ->where(function ($q) use ($dressCategorySlugs) {
                $q->whereHas('category', function ($cat) use ($dressCategorySlugs) {
                    $cat->whereIn('slug', $dressCategorySlugs);
                })->orWhereHas('subcategory', function ($sub) use ($dressCategorySlugs) {
                    $sub->whereIn('slug', $dressCategorySlugs);
                });
            })
            ->where(function ($q) {
                $q->where('discount', '>', 0)->orWhereColumn('compare_price', '>', 'price');
            })
            ->latest()
            ->take(24)
            ->get();

        if ($saleProducts->isEmpty()) {
            $saleProducts = Product::query()
                ->where('is_active', true)
                ->where('brand_id', 1)
                ->where(function ($q) use ($dressCategorySlugs) {
                    $q->whereHas('category', function ($cat) use ($dressCategorySlugs) {
                        $cat->whereIn('slug', $dressCategorySlugs);
                    })->orWhereHas('subcategory', function ($sub) use ($dressCategorySlugs) {
                        $sub->whereIn('slug', $dressCategorySlugs);
                    });
                })
                ->latest()
                ->take(24)
                ->get();
        }

        $saleFallbackCards = $this->buildSaleFallbackCards();

        return view('front.sale', compact('saleProducts', 'saleFallbackCards'));
    }

    private function buildSaleFallbackCards(): array
    {
        $sourceRoots = [
            ['root' => base_path('srcs/Festives'), 'label' => 'Festive'],
            ['root' => base_path('srcs/Party frocks'), 'label' => 'Party Frocks'],
            ['root' => base_path('srcs/Pattu Pavadai'), 'label' => 'Pattu Pavadai'],
        ];

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $cards = [];
        $limitPerSource = 8;

        foreach ($sourceRoots as $source) {
            $root = $source['root'];
            if (!is_dir($root)) {
                continue;
            }

            $files = collect(File::allFiles($root))
                ->filter(function ($file) use ($allowedExtensions): bool {
                    $ext = strtolower((string) $file->getExtension());
                    $base = strtolower((string) $file->getBasename('.' . $file->getExtension()));
                    return in_array($ext, $allowedExtensions, true) && $base !== 'main';
                })
                ->sortBy(fn($file) => strtolower((string) $file->getFilename()))
                ->take($limitPerSource)
                ->values();

            foreach ($files as $index => $file) {
                $absPath = $file->getPathname();
                $ext = strtolower((string) $file->getExtension());
                $hash = md5($absPath . '|' . @filemtime($absPath) . '|' . @filesize($absPath));
                $targetRelative = 'sale-imports/' . $hash . '.' . $ext;
                $targetAbsolute = storage_path('app/public/' . $targetRelative);

                if (!is_file($targetAbsolute)) {
                    File::ensureDirectoryExists(dirname($targetAbsolute));
                    File::copy($absPath, $targetAbsolute);
                }

                $titleSeed = $file->getBasename('.' . $file->getExtension());
                $titleSeed = preg_replace('/\s+/', ' ', str_replace(['_', '-'], ' ', (string) $titleSeed)) ?? (string) $titleSeed;
                $title = trim($titleSeed) !== '' ? Str::title($titleSeed) : ($source['label'] . ' ' . ($index + 1));

                $cards[] = [
                    'title' => $title,
                    'image' => asset('storage/' . str_replace('\\', '/', $targetRelative)),
                    'label' => $source['label'],
                ];
            }
        }

        return array_slice($cards, 0, 24);
    }

    public function jewelleryCollection(string $slug)
    {
        session(['theme' => 'jewellery', 'brand_id' => 2]);

        $collections = [
            'anti-tarnish' => [
                'title' => 'Anti Tarnish',
                'description' => 'Long-lasting anti-tarnish jewellery for everyday shine and comfort.',
                'images' => [
                    'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1611652022419-a9419f74343d?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1635767798638-3e25273a8236?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1611085583191-a3b181a88401?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?auto=format&fit=crop&w=1200&q=80',
                ],
            ],
            'korean' => [
                'title' => 'Korean',
                'description' => 'Minimal and trendy Korean-inspired jewellery edits for daily styling.',
                'images' => [
                    'https://images.unsplash.com/photo-1611085583191-a3b181a88401?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1617038220319-276d3cfab638?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1630019852942-f89202989a59?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1622398925373-3f91b1e275f5?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1600721391776-b5cd0e0048f9?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?auto=format&fit=crop&w=1200&q=80',
                ],
            ],
            'temple-traditional' => [
                'title' => 'Temple/Traditional',
                'description' => 'Classic temple and traditional motifs crafted for festive occasions.',
                'images' => [
                    'https://images.unsplash.com/photo-1630019852942-f89202989a59?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1535632787350-4e68ef0ac584?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1622398925373-3f91b1e275f5?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1611591437281-460bfbe1220a?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1615655114865-4cc1df7f6138?auto=format&fit=crop&w=1200&q=80',
                ],
            ],
            'meenakari' => [
                'title' => 'Meenakari',
                'description' => 'Color-rich meenakari pieces with vibrant enamel artistry and detail.',
                'images' => [
                    'https://images.unsplash.com/photo-1535632787350-4e68ef0ac584?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1620656798579-1984d6b0a56f?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1617038220319-276d3cfab638?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1602752250015-52934bc45613?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1605100804763-247f67b3557e?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1612817159949-195b6eb9e31a?auto=format&fit=crop&w=1200&q=80',
                ],
            ],
            'kundan' => [
                'title' => 'Kundan',
                'description' => 'Elegant kundan jewellery with regal sparkle for statement looks.',
                'images' => [
                    'https://images.unsplash.com/photo-1600721391776-b5cd0e0048f9?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1611652022419-a9419f74343d?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1622398925373-3f91b1e275f5?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1635767798638-3e25273a8236?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1611085583191-a3b181a88401?auto=format&fit=crop&w=1200&q=80',
                ],
            ],
        ];

        $collection = $collections[$slug] ?? null;
        if (!$collection) {
            abort(404);
        }

        return view('front.jewellery-collection', [
            'collectionSlug' => $slug,
            'collection' => $collection,
        ]);
    }

    /**
     * Show the Best Buys static page.
     */
    public function bestBuys()
    {
        session(['theme' => 'studio', 'brand_id' => 1]);
        $bestBuyCards = $this->bestBuyCardsData();

        return view('front.best-buys', compact('bestBuyCards'));
    }

    public function bestBuysShow(string $slug)
    {
        $cards = collect($this->bestBuyCardsData());
        $legacy = $cards->firstWhere('slug', $slug);
        $dbProduct = Product::where('slug', $slug)->first();

        if (!$legacy && !$dbProduct) {
            abort(404);
        }

        if ($legacy) {
            $product = $legacy;
            $galleryImages = [$legacy['image']];
        } else {
            $product = [
                'slug' => $dbProduct->slug,
                'title' => $dbProduct->name,
                'description' => $dbProduct->description ?: 'A curated AVNEE best-buy pick for everyday and festive wear.',
                'price' => (float) $dbProduct->price,
                'sku' => $dbProduct->sku ?: ('AVN-BB-' . str_pad((string) $dbProduct->id, 4, '0', STR_PAD_LEFT)),
                'image' => $dbProduct->image
                    ? asset('storage/' . ltrim($dbProduct->image, '/'))
                    : asset('images/best-buy/shimmer-silver-party-dress.png'),
            ];
            $galleryImages = [$product['image']];
        }

        $similarProducts = $cards
            ->reject(fn(array $item) => $item['slug'] === $product['slug'])
            ->take(8)
            ->values()
            ->all();

        $recentlyViewed = $cards
            ->shuffle()
            ->take(8)
            ->values()
            ->all();

        return view('front.best-buy-detail', compact('product', 'galleryImages', 'similarProducts', 'recentlyViewed'));
    }
}
