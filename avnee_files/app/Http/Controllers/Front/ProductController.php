<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Dedicated collection landing URLs mapped to listing filters.
     */
    public function collection(Request $request, string $collection)
    {
        $map = [
            'sale' => ['sort' => 'newest', 'discount' => 1, 'collection' => 'sale'],
            'new-arrivals' => ['sort' => 'newest', 'collection' => 'new-arrivals'],
            'best-sellers' => ['sort' => 'price_desc', 'collection' => 'best-sellers'],
            'bogo' => ['bogo' => 1, 'collection' => 'bogo'],
            'organizers' => ['sort' => 'newest', 'category' => 'organizers', 'collection' => 'organizers'],
            'gifting' => ['sort' => 'newest', 'category' => 'gifting', 'collection' => 'gifting'],
            'all-collections' => ['sort' => 'newest', 'collection' => 'all-collections'],
            'party-frocks' => ['sort' => 'newest', 'category' => 'party-frocks', 'collection' => 'party-frocks'],
            'summer-collections' => ['sort' => 'newest', 'category' => 'girls-dresses', 'collection' => 'summer-collections'],
            'festive-wear' => ['sort' => 'newest', 'category' => 'festive-wear', 'collection' => 'festive-wear'],
            'daily-wear' => ['sort' => 'price_asc', 'category' => 'girls-dresses', 'collection' => 'daily-wear'],
            'all-sarees' => ['sort' => 'newest', 'category' => 'sarees', 'collection' => 'all-sarees'],
            'printed-cotton' => ['sort' => 'newest', 'category' => 'sarees', 'collection' => 'printed-cotton'],
            'georgette' => ['sort' => 'newest', 'category' => 'sarees', 'collection' => 'georgette'],
            'semi-silk' => ['sort' => 'newest', 'category' => 'sarees', 'collection' => 'semi-silk'],
            'daily-wear-sarees' => ['sort' => 'newest', 'category' => 'sarees', 'collection' => 'daily-wear-sarees'],
            'cotton-sarees' => ['sort' => 'newest', 'category' => 'sarees', 'collection' => 'cotton-sarees'],
            'hand-made' => ['sort' => 'newest', 'category' => 'jewellery-gallery', 'collection' => 'hand-made'],
            'oxidised' => ['sort' => 'newest', 'category' => 'jewellery-gallery', 'collection' => 'oxidised'],
            'cultural' => ['sort' => 'newest', 'category' => 'jewellery-gallery', 'collection' => 'cultural'],
        ];

        $query = array_merge($request->query(), $map[$collection] ?? []);

        if (in_array($collection, ['organizers', 'gifting', 'hand-made', 'oxidised', 'cultural'], true)) {
            session(['theme' => 'jewellery', 'brand_id' => 2]);
        }

        if (in_array($collection, ['all-collections', 'party-frocks', 'summer-collections', 'festive-wear', 'daily-wear', 'all-sarees', 'printed-cotton', 'georgette', 'semi-silk', 'daily-wear-sarees', 'cotton-sarees'], true)) {
            session(['theme' => 'studio', 'brand_id' => 1]);
        }

        return redirect()->route('front.products.index', $query);
    }

    /**
     * Show the product listing page with filters
     */
    public function index(Request $request)
    {
        $studioOnlyCategorySlugs = ['party-frocks', 'festive-wear', 'girls-dresses', 'infant-sets', '2-4-years', '4-6-years', '6-14-years'];

        $jewelleryCategorySlugs = [
            'jewellery-gallery', 'earrings', 'necklace', 'bangles-bracelet', 'trinkets', 'fun-trinkets',
            'organizers', 'storage', 'hair-accessories', 'rings', 'necklace-set', 'belt',
            'maangtikkas', 'mens-accessories', 'anklet', 'mathapati', 'gifting',
            'anti-tarnish', 'korean', 'traditional', 'kundan', 'oxidised', '18k-gold-plated', 'fashion', 'watches'
        ];

        if ($request->filled('category') && in_array($request->query('category'), $studioOnlyCategorySlugs, true)) {
            session(['theme' => 'studio', 'brand_id' => 1]);
        }

        if ($request->filled('category') && in_array($request->query('category'), $jewelleryCategorySlugs, true)) {
            session(['theme' => 'jewellery', 'brand_id' => 2]);
        }

        // Keep legacy jewellery links working by mapping them to the folder gallery source.
        if ($request->query('category') === 'jewellery') {
            $query = $request->query();
            $query['category'] = 'jewellery-gallery';

            return redirect()->route('front.products.index', $query);
        }

        // Accept legacy misspelling for earrings links.
        if ($request->query('category') === 'earings') {
            $query = $request->query();
            $query['category'] = 'earrings';

            return redirect()->route('front.products.index', $query);
        }

        // Normalize plural alias for necklace links.
        if ($request->query('category') === 'necklaces') {
            $query = $request->query();
            $query['category'] = 'necklace';

            return redirect()->route('front.products.index', $query);
        }

        // Keep legacy accessories links on the jewellery Hair Accessories collection.
        if ($request->query('category') === 'accessories') {
            $query = $request->query();
            $query['category'] = 'hair-accessories';

            return redirect()->route('front.products.index', $query);
        }

        // Determine brand context (1: Studio, 2: Jewellery)
        $brandId = session('brand_id', 1);
        $theme = session('theme', $brandId == 2 ? 'jewellery' : 'studio');
        if ($brandId == 2 && $theme !== 'jewellery') {
            $theme = 'jewellery';
        }
        if ($brandId != 2 && $theme !== 'studio') {
            $theme = 'studio';
        }
        session(['theme' => $theme, 'brand_id' => $brandId]);

        if ($theme === 'jewellery' && $request->filled('category') && in_array($request->category, $studioOnlyCategorySlugs, true)) {
            $query = $request->query();
            unset($query['category']);
            return redirect()->route('front.products.index', $query);
        }

        $query = Product::where('is_active', true)
            ->where('brand_id', $brandId)
            ->with(['category', 'variants', 'images']);

        if ($theme === 'jewellery') {
            $query->whereDoesntHave('category', function($q) use ($studioOnlyCategorySlugs) {
                $q->whereIn('slug', $studioOnlyCategorySlugs);
            })->whereDoesntHave('subcategory', function($q) use ($studioOnlyCategorySlugs) {
                $q->whereIn('slug', $studioOnlyCategorySlugs);
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where(function($q) use ($request) {
                $q->whereHas('category', function($sub) use ($request) {
                    $sub->where('slug', $request->category);
                })->orWhereHas('subcategory', function($sub) use ($request) {
                    $sub->where('slug', $request->category);
                });
            });
        }

        // Filter only discounted products when collection route requests sale mode.
        if ($request->boolean('discount')) {
            $query->where('discount', '>', 0);
        }

        // Filter by price range using variant prices (source of truth)
        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->whereHas('variants', function($q) use ($request) {
                $q->whereBetween('price', [(float) $request->min_price, (float) $request->max_price]);
            });
        } elseif ($request->filled('max_price')) {
            $query->whereHas('variants', function($q) use ($request) {
                $q->where('price', '<=', (float) $request->max_price);
            });
        } elseif ($request->filled('min_price')) {
            $query->whereHas('variants', function($q) use ($request) {
                $q->where('price', '>=', (float) $request->min_price);
            });
        }

        // Filter by size
        if ($request->filled('size')) {
            $query->whereHas('variants', function($q) use ($request) {
                $q->where('size', $request->size);
            });
        }

        // Filter by combo
        if ($request->filled('combo')) {
            $query->whereHas('combos', function($q) use ($request) {
                $q->where('combos.id', $request->combo);
            });
        }

        // BOGO-like listing: products attached to active combos.
        if ($request->boolean('bogo')) {
            $query->whereHas('combos', function($q) {
                $q->where('combos.is_active', true);
            });
        }

        // Sort
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'trending':
                    $query->latest();
                    break;
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                    $query->latest();
                    break;
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }

        $products = $query->paginate(25)->withQueryString();

        $catalogConfigs = $this->getStyleCatalogConfigs($theme);
        $folderCatalogs = [];
        $styleCategoryCounts = [];
        $festiveGallery = [];
        $sampleGallery = [];
        $saleVisuals = $this->buildSaleVisuals();

        foreach ($catalogConfigs as $slug => $config) {
            $folderCatalogs[$slug] = $this->buildStyleCatalog($config);
            $styleCategoryCounts[$slug] = count($folderCatalogs[$slug]);
        }

        if ($products->isEmpty() && $request->filled('category') && array_key_exists($request->category, $folderCatalogs)) {
            $selectedCategory = $request->category;
            $selectedCatalog = $folderCatalogs[$selectedCategory] ?? [];
            $selectedLabel = $catalogConfigs[$selectedCategory]['label'] ?? ucwords(str_replace('-', ' ', $selectedCategory));

            $festiveGallery = array_map(static function (array $item) use ($selectedCategory, $selectedLabel): array {
                return [
                    'url' => $item['main_url'],
                    'group' => $selectedLabel,
                    'title' => $item['title'],
                    'detail_url' => route('front.gallery.collection.detail', ['category' => $selectedCategory, 'product' => $item['slug']]),
                ];
            }, $selectedCatalog);
        }

        if ($products->isEmpty() && empty($festiveGallery)) {
            $sampleGallery = $this->buildCrossThemeSampleGallery(20);
        }

        // Scope categories to current brand and hierarchy
        $categories = Category::where('brand_id', $brandId)
            ->where('is_active', true)
            ->whereNull('parent_id')
            ->with(['children' => function($q) {
                $q->where('is_active', true)->withCount(['products' => function($p) {
                    $p->where('is_active', true);
                }]);
            }])
            ->withCount(['products' => function($q) {
                $q->where('is_active', true);
            }])
            ->get();

        $sizes = \App\Models\ProductVariant::whereHas('product', function($q) use ($brandId) {
            $q->where('brand_id', $brandId)->where('is_active', true);
        })->whereNotNull('size')->where('size', '!=', '')
        ->distinct()->pluck('size');

        $exploreGrids = \App\Models\HomeExploreGrid::where('brand_id', $brandId)->where('is_active', true)->orderBy('sort_order')->get();
        if ($exploreGrids->isEmpty()) { $exploreGrids = collect(); }

        return view('front.product.index', compact('products', 'categories', 'sizes', 'theme', 'exploreGrids', 'festiveGallery', 'sampleGallery', 'saleVisuals', 'styleCategoryCounts'));
    }

    /**
     * Show the product details page
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->orWhere('id', $slug)
            ->with(['images', 'variants', 'category', 'reviews' => function($q) {
                $q->where('status', 'approved')->with('user')->latest();
            }, 'flashSales' => function($q) {
                $q->where('is_active', true)
                  ->where('start_time', '<=', now())
                  ->where('end_time', '>=', now());
            }])
            ->firstOrFail();

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->inRandomOrder()
            ->take(4)
            ->get();

        // Determine brand context (1: Studio, 2: Jewellery)
        $theme = $product->brand_id == 2 ? 'jewellery' : 'studio';
        session(['theme' => $theme, 'brand_id' => $product->brand_id]);

        $recentlyViewedIds = collect(session('recently_viewed_products', []))
            ->map(fn($id) => (int) $id)
            ->filter(fn($id) => $id > 0)
            ->reject(fn($id) => $id === (int) $product->id)
            ->prepend((int) $product->id)
            ->unique()
            ->values();

        session(['recently_viewed_products' => $recentlyViewedIds->take(12)->all()]);

        $displayIds = $recentlyViewedIds
            ->reject(fn($id) => $id === (int) $product->id)
            ->take(8)
            ->values();

        $recentlyViewedProducts = collect();
        if ($displayIds->isNotEmpty()) {
            $recentProductsById = Product::whereIn('id', $displayIds->all())
                ->where('is_active', true)
                ->where('brand_id', $product->brand_id)
                ->get()
                ->keyBy('id');

            $recentlyViewedProducts = $displayIds
                ->map(fn($id) => $recentProductsById->get($id))
                ->filter()
                ->values();
        }

        return view('front.product.detail', compact('product', 'relatedProducts', 'theme', 'recentlyViewedProducts'));
    }

    /**
     * Show Party Frocks detail page from folder-based gallery assets.
     */
    public function showPartyFrockDetail(string $product)
    {
        $catalogConfigs = $this->getStyleCatalogConfigs();
        $catalog = $this->buildStyleCatalog($catalogConfigs['party-frocks']);
        $galleryProduct = collect($catalog)->firstWhere('slug', $product);

        if (!$galleryProduct) {
            abort(404);
        }

        $theme = session('theme', 'studio');

        $category = 'party-frocks';
        $categoryLabel = 'Party Frocks';
        $linkedProduct = $this->ensureCartReadyProductForGalleryItem($galleryProduct, $category, $categoryLabel);
        $detailContent = $this->buildGalleryDetailContent($galleryProduct, $categoryLabel, $linkedProduct);
        $similarGalleryProducts = $this->buildSimilarGalleryProducts($catalog, $galleryProduct, $category, 8);
        $recentlyViewedGalleryProducts = $this->buildRecentlyViewedGalleryProducts($catalog, $galleryProduct, $category, 8);

        return view('front.product.gallery-party-frock-detail', compact('galleryProduct', 'theme', 'category', 'categoryLabel', 'linkedProduct', 'detailContent', 'similarGalleryProducts', 'recentlyViewedGalleryProducts'));
    }

    /**
     * Show kids section pages with Studio >> Kids >> [Section Name] navigation
     */
    public function kidsSection(Request $request, string $section)
    {
        // Set theme to studio for kids sections
        session(['theme' => 'studio', 'brand_id' => 1]);

        // Map sections to categories
        $sectionMap = [
            'all-girls' => null, // All girls - no category filter
            'party-frocks' => 'party-frocks',
            'dailywear' => 'girls-dresses',
            'festive-wear' => 'festive-wear',
        ];

        $category = $sectionMap[$section] ?? null;

        // Build query parameters
        $queryParams = [];
        if ($category) {
            $queryParams['category'] = $category;
        }

        return redirect()->route('front.products.index', $queryParams);
    }

    /**
     * Show sarees section pages with Studio >> Women >> Sarees >> [Category Name] navigation
     */
    public function sareesSection(Request $request, string $category)
    {
        // Set theme to studio for sarees sections
        session(['theme' => 'studio', 'brand_id' => 1]);

        // Map saree categories to collection names
        $sareeMap = [
            'all-sarees' => 'all-sarees',
            'daily-wear-sarees' => 'daily-wear-sarees',
            'semi-silk-sarees' => 'semi-silk',
            'cotton-sarees' => 'cotton-sarees',
            'georgette-sarees' => 'georgette',
        ];

        $collection = $sareeMap[$category] ?? null;

        // Build query parameters
        $queryParams = [];
        if ($collection) {
            $queryParams['collection'] = $collection;
        }

        return redirect()->route('front.products.index', $queryParams);
    }

    /**
     * Filter products by fabric type
     */
    public function fabricFilter(Request $request, string $fabric)
    {
        // Set theme to studio for fabric filters
        session(['theme' => 'studio', 'brand_id' => 1]);

        // Build query parameters
        $queryParams = array_merge($request->query(), ['fabric' => $fabric]);

        return redirect()->route('front.products.index', $queryParams);
    }

    /**
     * Filter products by occasion
     */
    public function occasionFilter(Request $request, string $occasion)
    {
        // Set theme to studio for occasion filters
        session(['theme' => 'studio', 'brand_id' => 1]);

        // Build query parameters
        $queryParams = array_merge($request->query(), ['occasion' => $occasion]);

        return redirect()->route('front.products.index', $queryParams);
    }

    /**
     * Filter products by color
     */
    public function colorFilter(Request $request, string $color)
    {
        // Set theme to studio for color filters
        session(['theme' => 'studio', 'brand_id' => 1]);

        // Build query parameters
        $queryParams = array_merge($request->query(), ['color' => $color]);

        return redirect()->route('front.products.index', $queryParams);
    }

    /**
     * Show a folder-catalog detail page for style categories.
     */
    public function showCollectionGalleryDetail(string $category, string $product)
    {
        $catalogConfigs = $this->getStyleCatalogConfigs();

        if (!array_key_exists($category, $catalogConfigs)) {
            abort(404);
        }

        $catalog = $this->buildStyleCatalog($catalogConfigs[$category]);
        $galleryProduct = collect($catalog)->firstWhere('slug', $product);

        // Handle BOGO sample products that don't exist in catalog
        if (!$galleryProduct && str_starts_with($product, 'bogo-sample-')) {
            $index = (int) substr(str_replace('bogo-sample-', '', $product), 0) - 1;
            $sampleGallery = $this->buildCrossThemeSampleGallery(20);

            if (isset($sampleGallery[$index])) {
                $galleryProduct = [
                    'slug' => $product,
                    'title' => $sampleGallery[$index]['title'] ?? 'BOGO Sample ' . ($index + 1),
                    'main_url' => $sampleGallery[$index]['main_url'] ?? asset('images/hero-slider/summer-classics.png'),
                    'description' => 'Exclusive BOGO offer item with premium quality and designer finish.',
                ];
            }
        }

        if (!$galleryProduct) {
            abort(404);
        }

        $theme = session('theme', 'studio');
        $categoryLabel = $catalogConfigs[$category]['label'];
        $linkedProduct = $this->ensureCartReadyProductForGalleryItem($galleryProduct, $category, $categoryLabel);
        $detailContent = $this->buildGalleryDetailContent($galleryProduct, $categoryLabel, $linkedProduct);
        $similarGalleryProducts = $this->buildSimilarGalleryProducts($catalog, $galleryProduct, $category, 8);
        $recentlyViewedGalleryProducts = $this->buildRecentlyViewedGalleryProducts($catalog, $galleryProduct, $category, 8);

        return view('front.product.gallery-party-frock-detail', compact('galleryProduct', 'theme', 'category', 'categoryLabel', 'linkedProduct', 'detailContent', 'similarGalleryProducts', 'recentlyViewedGalleryProducts'));
    }

    private function findLinkedProductForGalleryItem(array $galleryProduct): ?Product
    {
        $slug = (string) ($galleryProduct['slug'] ?? '');

        $query = Product::where('is_active', true)->with('variants');

        if ($slug !== '') {
            $bySlug = (clone $query)->where('slug', $slug)->first();
            if ($bySlug) {
                return $bySlug;
            }
        }

        return null;
    }

    private function ensureCartReadyProductForGalleryItem(array $galleryProduct, string $categorySlug, string $categoryLabel): ?Product
    {
        $linked = $this->findLinkedProductForGalleryItem($galleryProduct);
        if ($linked) {
            return $linked;
        }

        $itemSlug = (string) ($galleryProduct['slug'] ?? 'item');
        $virtualSlug = 'gallery-' . trim($this->slugify($categorySlug . '-' . $itemSlug), '-');
        $existing = Product::where('slug', $virtualSlug)->with('variants')->first();
        if ($existing) {
            $this->ensureVariantForVirtualProduct($existing, $virtualSlug);
            return $existing->load('variants');
        }

        $brandId = (int) session('brand_id', 1);
        $category = Category::where('brand_id', $brandId)->where('slug', $categorySlug)->first()
            ?? Category::where('brand_id', $brandId)->first();

        $title = (string) ($galleryProduct['title'] ?? $categoryLabel);
        $imagePath = $this->copyGalleryMainImageToStorage($galleryProduct, $virtualSlug);

        $product = Product::create([
            'brand_id' => $brandId,
            'category_id' => $category?->id,
            'name' => $title,
            'slug' => $virtualSlug,
            'image' => $imagePath,
            'description' => $categoryLabel . ' curated piece from AVNEE gallery collection.',
            'care_instructions' => 'Handle with care. Keep away from moisture and direct impact.',
            'is_featured' => false,
            'is_active' => true,
        ]);

        $this->ensureVariantForVirtualProduct($product, $virtualSlug);

        return $product->load('variants');
    }

    private function ensureVariantForVirtualProduct(Product $product, string $virtualSlug): void
    {
        if ($product->variants()->exists()) {
            return;
        }

        $sku = 'GAL-' . strtoupper(substr(md5($virtualSlug), 0, 10));

        ProductVariant::create([
            'product_id' => $product->id,
            'sku' => $sku,
            'size' => 'Free Size',
            'colour' => null,
            'price' => 699,
            'compare_price' => 999,
            'stock' => 100,
            'low_stock_threshold' => 5,
        ]);
    }

    private function copyGalleryMainImageToStorage(array $galleryProduct, string $virtualSlug): string
    {
        $mainUrl = (string) ($galleryProduct['main_url'] ?? '');
        if ($mainUrl === '') {
            return 'products/default.jpg';
        }

        $pathPart = parse_url($mainUrl, PHP_URL_PATH);
        if (!$pathPart) {
            return 'products/default.jpg';
        }

        $decodedPath = urldecode((string) $pathPart);
        $sourcePath = public_path(ltrim($decodedPath, '/'));
        if (!is_file($sourcePath)) {
            return 'products/default.jpg';
        }

        $ext = strtolower(pathinfo($sourcePath, PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true)) {
            $ext = 'jpg';
        }

        $relativeTarget = 'products/gallery/' . $virtualSlug . '.' . $ext;
        $absoluteTarget = storage_path('app/public/' . $relativeTarget);

        File::ensureDirectoryExists(dirname($absoluteTarget));
        File::copy($sourcePath, $absoluteTarget);

        return $relativeTarget;
    }

    private function buildGalleryDetailContent(array $galleryProduct, string $categoryLabel, ?Product $linkedProduct): array
    {
        $price = $linkedProduct?->price ?? 699;
        $comparePrice = $linkedProduct?->compare_price ?? ($price + 300);
        $description = $linkedProduct?->description
            ? strip_tags((string) $linkedProduct->description)
            : ($categoryLabel . ' curated piece with premium finish and playful handcrafted detailing.');

        return [
            'price' => (float) $price,
            'compare_price' => (float) $comparePrice,
            'description' => trim($description),
            'shipping' => 'Dispatch within 48 hours. Free shipping above ₹1499.',
            'returns' => 'Returns accepted only for unused products in original condition as per policy.',
        ];
    }

    private function buildSimilarGalleryProducts(array $catalog, array $current, string $category, int $limit = 8): array
    {
        $currentSlug = (string) ($current['slug'] ?? '');
        $currentWords = collect(preg_split('/\s+/', strtolower((string) ($current['title'] ?? ''))))
            ->filter(fn($word) => strlen((string) $word) > 2)
            ->values();

        $scored = collect($catalog)
            ->reject(fn($item) => (string) ($item['slug'] ?? '') === $currentSlug)
            ->map(function ($item) use ($currentWords) {
                $titleWords = collect(preg_split('/\s+/', strtolower((string) ($item['title'] ?? ''))));
                $overlap = $currentWords->intersect($titleWords)->count();
                $item['_score'] = $overlap;
                return $item;
            })
            ->sortByDesc('_score')
            ->take($limit)
            ->values()
            ->all();

        return $this->formatGalleryCards($scored, $category);
    }

    private function buildRecentlyViewedGalleryProducts(array $catalog, array $current, string $category, int $limit = 8): array
    {
        $currentSlug = (string) ($current['slug'] ?? '');
        $currentKey = $category . '::' . $currentSlug;

        $history = collect(session('recently_viewed_gallery_products', []))
            ->map(fn($value) => (string) $value)
            ->reject(fn($value) => trim($value) === '')
            ->reject(fn($value) => $value === $currentKey)
            ->prepend($currentKey)
            ->unique()
            ->take(30)
            ->values();

        session(['recently_viewed_gallery_products' => $history->all()]);

        $catalogBySlug = collect($catalog)->keyBy(fn($item) => (string) ($item['slug'] ?? ''));
        $recentItems = $history
            ->slice(1)
            ->map(function ($key) use ($category, $catalogBySlug) {
                [$entryCategory, $entrySlug] = array_pad(explode('::', (string) $key, 2), 2, '');
                if ($entryCategory !== $category || $entrySlug === '') {
                    return null;
                }
                return $catalogBySlug->get($entrySlug);
            })
            ->filter()
            ->take($limit)
            ->values()
            ->all();

        if (empty($recentItems)) {
            $recentItems = collect($catalog)
                ->reject(fn($item) => (string) ($item['slug'] ?? '') === $currentSlug)
                ->take($limit)
                ->values()
                ->all();
        }

        return $this->formatGalleryCards($recentItems, $category);
    }

    private function formatGalleryCards(array $items, string $category): array
    {
        $slugs = collect($items)
            ->map(fn($item) => (string) ($item['slug'] ?? ''))
            ->filter()
            ->values();

        $pricesBySlug = [];
        if ($slugs->isNotEmpty()) {
            $products = Product::whereIn('slug', $slugs->all())
                ->where('is_active', true)
                ->with('variants')
                ->get();

            foreach ($products as $product) {
                $pricesBySlug[(string) $product->slug] = (float) ($product->price ?? 699);
            }
        }

        return collect($items)
            ->map(function ($item) use ($category, $pricesBySlug) {
                $slug = (string) ($item['slug'] ?? '');
                $url = $category === 'party-frocks'
                    ? route('front.gallery.party-frock.detail', ['product' => $slug])
                    : route('front.gallery.collection.detail', ['category' => $category, 'product' => $slug]);

                return [
                    'slug' => $slug,
                    'title' => (string) ($item['title'] ?? 'Product'),
                    'image' => (string) ($item['main_url'] ?? ''),
                    'url' => $url,
                    'price' => $pricesBySlug[$slug] ?? 699,
                ];
            })
            ->values()
            ->all();
    }

    /**
     * Build folder-based Party Frocks catalog.
     */
    private function getStyleCatalogConfigs(?string $theme = null): array
    {
        $allConfigs = [
            'jewellery-gallery' => [
                'root' => public_path('images/jewellery'),
                'label' => 'Jewellery',
                'dir_pattern' => '/.*/',
            ],
            'earrings' => [
                'root' => public_path('images/jewellery'),
                'label' => 'Earrings',
                'dir_pattern' => '/earring/i',
            ],
            'necklace' => [
                'root' => public_path('images/jewellery/Necklace'),
                'label' => 'Necklaces',
                'dir_pattern' => '/.*/',
            ],
            'rings' => [
                'root' => public_path('images/jewellery/rings'),
                'label' => 'Rings',
                'dir_pattern' => '/.*/',
            ],
            'necklace-set' => [
                'root' => public_path('images/jewellery/necklace-set'),
                'label' => 'Necklace Set',
                'dir_pattern' => '/.*/',
            ],
            'belt' => [
                'root' => public_path('images/jewellery'),
                'label' => 'Belt',
                'dir_pattern' => '/belt/i',
            ],
            'maangtikkas' => [
                'root' => public_path('images/jewellery'),
                'label' => 'Maangtikkas',
                'dir_pattern' => '/maang|mangt|mang\s*tikka|tikka/i',
            ],
            'mens-accessories' => [
                'root' => public_path('images/jewellery'),
                'label' => "Men's Accessories",
                'dir_pattern' => '/men|mens|gents|boys?\s*accessor/i',
            ],
            'anklet' => [
                'root' => public_path('images/jewellery'),
                'label' => 'Anklet',
                'dir_pattern' => '/anklet|payal/i',
            ],
            'mathapati' => [
                'root' => public_path('images/jewellery'),
                'label' => 'Mathapati',
                'dir_pattern' => '/matha|mathapati|maatha|patti/i',
            ],
            'anti-tarnish' => [
                'root' => public_path('images/jewellery'),
                'label' => 'Anti Tarnish',
                'dir_pattern' => '/anti\s*tarnish/i',
            ],
            'korean' => [
                'root' => public_path('images/jewellery'),
                'label' => 'Korean',
                'dir_pattern' => '/dual\s*heart|bloom|floral\s*teardrop|classic\s*beaded|rectangular\s*artificial\s*stone|crystal\s*stud/i',
            ],
            'traditional' => [
                'root' => public_path('images/jewellery'),
                'label' => 'Traditional',
                'dir_pattern' => '/traditional|viraasat|radha\s*krishna|peacock\s*om|swarna\s*shakti/i',
            ],
            'kundan' => [
                'root' => public_path('images/jewellery'),
                'label' => 'Kundan',
                'dir_pattern' => '/chandbali|chandelier|stone\s*&\s*pearl\s*drop/i',
            ],
            'oxidised' => [
                'root' => public_path('images/jewellery'),
                'label' => 'Oxidised',
                'dir_pattern' => '/oxidized|oxidised/i',
            ],
            '18k-gold-plated' => [
                'root' => public_path('images/jewellery'),
                'label' => '18 K Gold Plated',
                'dir_pattern' => '/gold\s*plated|pendant\s*with\s*chain/i',
            ],
            'fashion' => [
                'root' => public_path('images/jewellery'),
                'label' => 'Fashion',
                'dir_pattern' => '/adjustable|bracelet|statement\s*ring|statement\s*earrings|bird\s*design|swan\s*design/i',
            ],
            'watches' => [
                'root' => public_path('images/jewellery'),
                'label' => 'Watches',
                'dir_pattern' => '/watch|watches|timepiece/i',
            ],
            'trinkets' => [
                'root' => public_path('images/trinkets'),
                'label' => 'Trinkets',
                'dir_pattern' => '/.*/',
            ],
            'fun-trinkets' => [
                'root' => public_path('images/trinkets'),
                'label' => 'Fun Trinkets',
                'dir_pattern' => '/.*/',
            ],
            'hair-accessories' => [
                'root' => public_path('images/hair-accessories'),
                'label' => 'Hair Accessories',
                'dir_pattern' => '/.*/',
            ],
            'bangles-bracelet' => [
                'root' => public_path('images/bangles-bracelet/Bangles'),
                'label' => 'Bangles & Bracelet',
                'dir_pattern' => '/.*/',
            ],
            'party-frocks' => [
                'root' => base_path('srcs/Party frocks'),
                'label' => 'Party Frocks',
                'dir_pattern' => '/^prod\d+/i',
            ],
            'festive-wear' => [
                'root' => base_path('srcs/Festives'),
                'label' => 'Festive Wear',
                'dir_pattern' => '/^prod\d+/i',
            ],
            'girls-dresses' => [
                'root' => base_path('srcs/Festives'),
                'label' => 'Girls Dresses',
                'dir_pattern' => '/^prod\d+/i',
            ],
            'infant-sets' => [
                'root' => base_path('srcs/Pattu Pavadai'),
                'label' => 'Infant Sets',
                'groups' => ['0-3 months', '3- 6 months', '6-9 months', '1-2 yrs'],
            ],
            '2-4-years' => [
                'root' => base_path('srcs/Pattu Pavadai'),
                'label' => '2-4 Years',
                'groups' => ['2-3 yrs', '3-4 yrs'],
            ],
            '4-6-years' => [
                'root' => base_path('srcs/Pattu Pavadai'),
                'label' => '4-6 Years',
                'groups' => ['4-5 yrs', '5-6 yrs'],
            ],
            '6-14-years' => [
                'root' => base_path('srcs/Pattu Pavadai'),
                'label' => '6-14 Years',
                'groups' => ['3-4 yrs', '4-5 yrs', '5-6 yrs'],
            ],
            'bogo' => [
                'root' => base_path('srcs'),
                'label' => 'BOGO Collection',
                'dir_pattern' => '/.*/',
            ],
        ];

        if ($theme === 'jewellery') {
            return array_intersect_key($allConfigs, array_flip([
                'jewellery-gallery',
                'earrings',
                'necklace',
                'rings',
                'bangles-bracelet',
                'necklace-set',
                'belt',
                'maangtikkas',
                'mens-accessories',
                'anklet',
                'mathapati',
                'anti-tarnish',
                'korean',
                'traditional',
                'kundan',
                'oxidised',
                '18k-gold-plated',
                'fashion',
                'watches',
                'trinkets',
                'fun-trinkets',
                'hair-accessories',
            ]));
        }

        return $allConfigs;
    }

    private function buildStyleCatalog(array $config): array
    {
        $rootPath = $config['root'] ?? '';
        $dirNamePattern = $config['dir_pattern'] ?? '/.*/';
        $catalogLabel = (string) ($config['label'] ?? 'Collection');

        if (!is_dir($rootPath)) {
            return [];
        }

        $catalog = [];
        $allowedGroups = $config['groups'] ?? [null];

        foreach ($allowedGroups as $groupName) {
            $basePath = $groupName ? $rootPath . DIRECTORY_SEPARATOR . $groupName : $rootPath;
            if (!is_dir($basePath)) {
                continue;
            }

            $productDirs = File::directories($basePath);
            sort($productDirs, SORT_NATURAL | SORT_FLAG_CASE);

            $matchedProductDirs = [];
            foreach ($productDirs as $dirPath) {
                $folderName = basename($dirPath);
                if (!preg_match($dirNamePattern, $folderName)) {
                    continue;
                }
                $matchedProductDirs[] = $dirPath;
            }

            if (!empty($matchedProductDirs)) {
                foreach ($matchedProductDirs as $dirPath) {
                    $item = $this->buildCatalogItemFromProductDirectory($dirPath, (string) $groupName, $catalogLabel);
                    if ($item) {
                        $catalog[] = $item;
                    }
                }
                continue;
            }

            foreach ($productDirs as $dirPath) {
                $item = $this->buildCatalogItemFromProductDirectory($dirPath, (string) $groupName, $catalogLabel);
                if ($item) {
                    $catalog[] = $item;
                }
            }

            $looseFiles = collect(File::files($basePath))
                ->filter(static function ($file): bool {
                    return in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'webp', 'gif'], true);
                })
                ->sortBy(static fn($file) => strtolower($file->getFilename()))
                ->values();

            foreach ($looseFiles as $index => $file) {
                $filePath = $file->getPathname();
                $baseName = $file->getBasename('.' . $file->getExtension());
                $groupPrefix = $groupName ? $this->slugify((string) $groupName) . '-' : '';
                $slug = $groupPrefix . $this->slugify($baseName ?: ('item-' . ($index + 1)));

                $url = $this->toPublicAssetUrl($filePath);
                $titleSeed = $this->formatCatalogTitle(
                    $baseName ?: ('item-' . ($index + 1)),
                    (string) $groupName,
                    $catalogLabel
                );

                $catalog[] = [
                    'slug' => $slug,
                    'title' => $titleSeed,
                    'main_url' => $url,
                    'images' => [$url],
                    'color_options' => [
                        [
                            'slug' => 'default',
                            'name' => 'Default',
                            'main_url' => $url,
                            'images' => [$url],
                        ],
                    ],
                ];
            }
        }

        $seenSlugs = [];
        foreach ($catalog as $idx => $item) {
            $baseSlug = $item['slug'] ?: ('item-' . ($idx + 1));
            $candidate = $baseSlug;
            $counter = 2;
            while (in_array($candidate, $seenSlugs, true)) {
                $candidate = $baseSlug . '-' . $counter;
                $counter++;
            }
            $catalog[$idx]['slug'] = $candidate;
            $seenSlugs[] = $candidate;
        }

        usort($catalog, static fn(array $a, array $b): int => strnatcasecmp($a['title'], $b['title']));

        return $catalog;
    }

    private function buildCatalogItemFromProductDirectory(string $dirPath, string $groupName = '', string $catalogLabel = 'Collection'): ?array
    {
        $folderName = basename($dirPath);

        $directImageFiles = collect(File::files($dirPath))
            ->filter(static function ($file): bool {
                return in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'webp', 'gif'], true);
            })
            ->sortBy(static fn($file) => strtolower($file->getFilename()))
            ->values();

        $colorOptions = [];
        $colorDirs = File::directories($dirPath);
        sort($colorDirs, SORT_NATURAL | SORT_FLAG_CASE);

        foreach ($colorDirs as $colorDirPath) {
            $colorName = basename($colorDirPath);
            $colorImageFiles = collect(File::files($colorDirPath))
                ->filter(static function ($file): bool {
                    return in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'webp', 'gif'], true);
                })
                ->sortBy(static fn($file) => strtolower($file->getFilename()))
                ->values();

            if ($colorImageFiles->isEmpty()) {
                continue;
            }

            $colorMain = $colorImageFiles->first(static function ($file): bool {
                return strtolower($file->getBasename('.' . $file->getExtension())) === 'main';
            }) ?? $colorImageFiles->first();

            $mainPath = $colorMain?->getPathname();
            $images = $colorImageFiles
                ->map(static fn($file) => $file->getPathname())
                ->reject(static fn($path) => $path === $mainPath)
                ->prepend($mainPath)
                ->map(fn($path) => $this->toPublicAssetUrl((string) $path))
                ->values()
                ->all();

            $colorOptions[] = [
                'slug' => $this->slugify($colorName),
                'name' => $this->readableLabel($colorName),
                'main_url' => $this->toPublicAssetUrl((string) $mainPath),
                'images' => $images,
            ];
        }

        if ($directImageFiles->isEmpty() && empty($colorOptions)) {
            return null;
        }

        $directMain = $directImageFiles->first(static function ($file): bool {
            return strtolower($file->getBasename('.' . $file->getExtension())) === 'main';
        }) ?? $directImageFiles->first();

        $mainUrl = $directMain
            ? $this->toPublicAssetUrl((string) $directMain->getPathname())
            : ($colorOptions[0]['main_url'] ?? null);

        if (!$mainUrl) {
            return null;
        }

        if (!empty($colorOptions)) {
            $allImages = collect($colorOptions)
                ->flatMap(static fn(array $color) => $color['images'])
                ->prepend($mainUrl)
                ->unique()
                ->values()
                ->all();
        } else {
            $mainPath = $directMain?->getPathname();
            $orderedDirectPaths = $directImageFiles
                ->map(static fn($file) => $file->getPathname())
                ->reject(static fn($path) => $path === $mainPath)
                ->prepend($mainPath)
                ->filter()
                ->values();

            $allImages = $orderedDirectPaths
                ->map(fn($path) => $this->toPublicAssetUrl((string) $path))
                ->values()
                ->all();

            $colorOptions = [
                [
                    'slug' => 'default',
                    'name' => 'Default',
                    'main_url' => $mainUrl,
                    'images' => $allImages,
                ],
            ];
        }

        $slugPrefix = trim($groupName) !== '' ? ($this->slugify($groupName) . '-') : '';

        return [
            'slug' => $slugPrefix . $this->slugify($folderName),
            'title' => $this->formatCatalogTitle($folderName, $groupName, $catalogLabel),
            'main_url' => $mainUrl,
            'images' => $allImages,
            'color_options' => $colorOptions,
        ];
    }

    private function toPublicAssetUrl(string $absolutePath): string
    {
        $realPath = realpath($absolutePath) ?: $absolutePath;
        $normalizedAbsolutePath = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $realPath);
        $publicRoot = rtrim(str_replace(['/', '\\'], DIRECTORY_SEPARATOR, public_path()), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

        if (str_starts_with($normalizedAbsolutePath, $publicRoot)) {
            $relativePath = substr($normalizedAbsolutePath, strlen($publicRoot));
            $relativePath = str_replace(DIRECTORY_SEPARATOR, '/', (string) $relativePath);
            $encodedPath = implode('/', array_map('rawurlencode', explode('/', $relativePath)));
            return asset($encodedPath);
        }

        return $this->publishExternalGalleryAsset($normalizedAbsolutePath);
    }

    private function publishExternalGalleryAsset(string $absolutePath): string
    {
        if (!is_file($absolutePath)) {
            return asset('images/hero-slider/3.png');
        }

        $extension = strtolower((string) pathinfo($absolutePath, PATHINFO_EXTENSION));
        if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true)) {
            $extension = 'jpg';
        }

        $fingerprint = md5($absolutePath . '|' . filemtime($absolutePath) . '|' . filesize($absolutePath));
        $targetRelativePath = 'gallery-imports/' . $fingerprint . '.' . $extension;
        $targetAbsolutePath = storage_path('app/public/' . $targetRelativePath);

        if (!is_file($targetAbsolutePath)) {
            File::ensureDirectoryExists(dirname($targetAbsolutePath));
            File::copy($absolutePath, $targetAbsolutePath);
        }

        $encodedPath = implode('/', array_map('rawurlencode', explode('/', str_replace(DIRECTORY_SEPARATOR, '/', $targetRelativePath))));
        return asset('storage/' . $encodedPath);
    }

    private function buildCrossThemeSampleGallery(int $limit = 20): array
    {
        $sampleConfigs = [
            [
                'slug' => 'party-frocks',
                'label' => 'Party Frocks',
                'root' => base_path('srcs/Party frocks'),
                'bucket_depth' => 1,
            ],
            [
                'slug' => 'festive-wear',
                'label' => 'Festive Wear',
                'root' => base_path('srcs/Festives'),
                'bucket_depth' => 1,
            ],
            [
                'slug' => 'pattu-pavadai',
                'label' => 'Pattu Pavadai',
                'root' => base_path('srcs/Pattu Pavadai'),
                'bucket_depth' => 2,
            ],
        ];

        $gallery = [];
        $seenHashes = [];

        foreach ($sampleConfigs as $config) {
            $root = (string) ($config['root'] ?? '');
            if (!is_dir($root)) {
                continue;
            }

            $bucketDepth = (int) ($config['bucket_depth'] ?? 1);

            $imageFiles = collect(File::allFiles($root))
                ->filter(static function ($file): bool {
                    return in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'webp', 'gif'], true);
                })
                ->reject(static function ($file): bool {
                    return strtolower($file->getBasename('.' . $file->getExtension())) === 'main';
                })
                ->sortBy(static fn($file) => strtolower($file->getPathname()))
                ->values();

            if ($imageFiles->isEmpty()) {
                continue;
            }

            $bucketed = [];
            foreach ($imageFiles as $file) {
                $path = $file->getPathname();
                $relativePath = trim(str_replace(['\\', '/'], '/', str_replace($root, '', $path)), '/');
                $segments = array_values(array_filter(explode('/', $relativePath), static fn($v) => $v !== ''));
                $bucketSegments = array_slice($segments, 0, max(1, $bucketDepth));
                $bucketKey = !empty($bucketSegments) ? implode('/', $bucketSegments) : '_default';

                if (!isset($bucketed[$bucketKey])) {
                    $bucketed[$bucketKey] = [];
                }

                $bucketed[$bucketKey][] = $path;
            }

            $bucketKeys = array_keys($bucketed);
            sort($bucketKeys, SORT_NATURAL | SORT_FLAG_CASE);

            $round = 0;
            while (true) {
                $addedThisRound = false;
                foreach ($bucketKeys as $bucketKey) {
                    $bucketPaths = $bucketed[$bucketKey] ?? [];
                    if (!isset($bucketPaths[$round])) {
                        continue;
                    }

                    $path = (string) $bucketPaths[$round];
                    $fileHash = @md5_file($path) ?: md5($path);
                    if (isset($seenHashes[$fileHash])) {
                        continue;
                    }

                    $seenHashes[$fileHash] = true;
                    $addedThisRound = true;

                    $url = $this->toPublicAssetUrl($path);
                    $nameSeed = pathinfo($path, PATHINFO_FILENAME);
                    $nameSeed = preg_replace('/\s+/', ' ', str_replace(['_', '-'], ' ', (string) $nameSeed)) ?? (string) $nameSeed;
                    $title = trim($nameSeed) !== '' ? $this->readableLabel((string) $nameSeed) : ($config['label'] . ' Edit');

                    $gallery[] = [
                        'slug' => $config['slug'] . '-' . $this->slugify($bucketKey . '-' . $nameSeed . '-' . substr($fileHash, 0, 6)),
                        'title' => $title,
                        'main_url' => $url,
                        'images' => [$url],
                        'source_slug' => $config['slug'],
                        'source_label' => $config['label'],
                    ];

                    if (count($gallery) >= $limit) {
                        return $gallery;
                    }
                }

                if (!$addedThisRound) {
                    break;
                }

                $round++;
            }
        }

        return $gallery;
    }

    private function buildSaleVisuals(): array
    {
        $root = base_path('srcs/sales');
        if (!is_dir($root)) {
            return [];
        }

        $files = collect(File::allFiles($root))
            ->filter(static function ($file): bool {
                return in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'webp', 'gif'], true);
            })
            ->sortBy(static fn($file) => strtolower($file->getFilename()))
            ->values();

        if ($files->isEmpty()) {
            return [];
        }

        $urls = $files
            ->map(fn($file) => $this->toPublicAssetUrl($file->getPathname()))
            ->values();

        $banner = $urls->first();
        $cardSources = $urls->slice(1, 3)->values();

        if ($cardSources->count() < 3) {
            $fallbackPool = $urls->slice(0, 3)->values();
            while ($cardSources->count() < 3 && $fallbackPool->isNotEmpty()) {
                $cardSources->push($fallbackPool[$cardSources->count() % $fallbackPool->count()]);
            }
        }

        $cardTitles = [
            ['kicker' => 'Last Chance', 'headline' => 'Sale Now'],
            ['kicker' => 'BOGO Offer', 'headline' => 'Limitless Deals'],
            ['kicker' => 'Highlight Offer', 'headline' => 'Trending Offer'],
        ];

        $cards = [];
        for ($i = 0; $i < 3; $i++) {
            $cards[] = [
                'image' => $cardSources[$i] ?? $banner,
                'kicker' => $cardTitles[$i]['kicker'],
                'headline' => $cardTitles[$i]['headline'],
            ];
        }

        return [
            'banner' => $banner,
            'cards' => $cards,
            'code' => 'AVNEESALE10',
            'note' => 'No Return No Exchange',
        ];
    }

    private function slugify(string $value): string
    {
        $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', trim($value)));
        return trim($slug, '-') ?: 'item';
    }

    private function readableLabel(string $value): string
    {
        return ucwords(str_replace(['-', '_'], ' ', trim($value)));
    }

    private function formatCatalogTitle(string $rawName, string $groupName = '', string $catalogLabel = 'Collection'): string
    {
        $name = trim((string) $rawName);
        if ($name === '') {
            return $catalogLabel;
        }

        $name = str_replace(['_', '-'], ' ', $name);
        $name = preg_replace('/\s+/', ' ', $name) ?? $name;

        // Normalize common source prefix from imported folders.
        $name = preg_replace('/^avnee\s+s\s+/i', "Avnee's ", $name) ?? $name;

        // Replace generic folder names like prod1/product-2 with a readable title.
        if (preg_match('/^(?:prod(?:uct)?)\s*(\d+)$/i', $name, $matches)) {
            return trim($catalogLabel);
        }

        // Imported raw mobile names should show the category title instead of noisy timestamps.
        if (preg_match('/^whatsapp\s+image\s+\d{4}(?:[-\s]\d{2}){2}/i', $name)) {
            return trim($catalogLabel);
        }

        // Remove common numeric age prefixes like "3 4 yrs", "4-6 years", "0-3 months".
        $name = preg_replace('/^\d+\s*(?:[-\s]\s*\d+)?\s*(?:yrs?|years?|months?)\s+/i', '', $name) ?? $name;
        // Remove leftover trailing numbering from labels.
        $name = preg_replace('/\s+\d+$/', '', $name) ?? $name;
        $name = trim($name);
        if ($name === '') {
            return trim($catalogLabel);
        }

        $normalizedLower = strtolower($name);
        if (in_array($normalizedLower, ['baby', 'child'], true)) {
            return ucfirst($normalizedLower);
        }

        $canonicalDressNames = [
            'classic peach layered frock' => 'Classic Peach Layered Frock',
            'ethnic charm festive dress' => 'Ethnic Charm Festive Dress',
            'floral garden party dress' => 'Floral Garden Party Dress',
            'casual chic denim set' => 'Casual Chic Denim Set',
            'shimmer silver party dress' => 'Shimmer Silver Party Dress',
            'glam black sequin dress' => 'Glam Black Sequin Dress',
            'twinkle pink party dress' => 'Twinkle Pink Party Dress',
            'blush bloom ethnic set' => 'Blush Bloom Ethnic Set',
        ];

        foreach ($canonicalDressNames as $needle => $canonical) {
            if (str_contains($normalizedLower, $needle)) {
                return $canonical;
            }
        }

        return $this->readableLabel($name);
    }

    /**
     * Store a new review for a product.
     */
    public function storeReview(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:2000',
        ]);

        // Check if user has purchased this product (Verified Purchase)
        $isVerified = \App\Models\Order::where('user_id', auth()->id())
            ->where('status', 'delivered')
            ->whereHas('items', function($q) use ($product) {
                $q->where('product_id', $product->id);
            })
            ->exists();

        \App\Models\Review::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => 'pending', // Moderation required
            'is_verified' => $isVerified,
        ]);

        return redirect()->back()->with('success', 'Thank you! Your review has been submitted and is awaiting moderation.');
    }
    /**
     * Search products for live search (AJAX)
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        if (!$query) {
            return response()->json([]);
        }

        $brandId = session('brand_id', 1);

        $products = Product::where('is_active', true)
            ->where('brand_id', $brandId)
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%")
                  ->orWhereHas('category', function($cat) use ($query) {
                      $cat->where('name', 'LIKE', "%{$query}%");
                  });
            })
            ->take(8)
            ->get(['id', 'name', 'slug', 'price', 'discount', 'image']);

        $results = $products->map(function($product) {
            $discountedPrice = $product->price - ($product->price * ($product->discount / 100));
            return [
                'name' => $product->name,
                'url' => route('front.product.detail', $product->slug ?? $product->id),
                'price' => '₹' . number_format($discountedPrice, 2),
                'old_price' => $product->discount > 0 ? '₹' . number_format($product->price, 2) : null,
                'image' => asset('storage/' . $product->image),
            ];
        });

        return response()->json($results);
    }
}
