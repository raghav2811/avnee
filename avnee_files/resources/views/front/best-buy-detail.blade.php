@extends('layouts.front.' . (session('theme', 'studio')))

@section('content')
<section class="bg-[#f6cfe0] min-h-screen text-[#1f1f1f] border-t border-[#7f2458]">
  <div class="max-w-[1320px] mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
    <div class="text-[10px] uppercase tracking-[0.16em] text-[#8b3c73] mb-4">
      <a href="{{ route('front.home') }}" class="hover:underline">Home</a>
      <span class="mx-1">/</span>
      <a href="{{ route('front.products.collection', ['collection' => 'best-sellers']) }}" class="hover:underline">Festive Wear</a>
      <span class="mx-1">/</span>
      <span class="text-[#6e2d5f]">{{ $product['title'] }}</span>
    </div>

    <div class="grid gap-8 lg:gap-10 lg:grid-cols-[520px_minmax(0,1fr)]">
      <div>
        <div class="border border-[#d8b0c5] bg-white overflow-hidden mb-3">
          <img src="{{ asset('images/coupons/avnee7.jpeg') }}" alt="AVNEE7 Coupon Banner" class="w-full h-auto object-cover" />
        </div>
        <div class="relative border border-[#d6a7bf] bg-white overflow-hidden">
          <button type="button" id="gallery-prev" class="absolute left-2 top-1/2 -translate-y-1/2 z-10 w-8 h-8 rounded-full bg-black/35 text-white">&#8249;</button>
          <button type="button" id="gallery-next" class="absolute right-2 top-1/2 -translate-y-1/2 z-10 w-8 h-8 rounded-full bg-black/35 text-white">&#8250;</button>
          <img id="best-buy-main-image" src="{{ $galleryImages[0] }}" alt="{{ $product['title'] }}" class="w-full h-[560px] object-cover" />
          <span id="gallery-counter" class="absolute right-2 bottom-2 text-[11px] bg-black/55 text-white px-2 py-0.5">1 / {{ count($galleryImages) }}</span>
        </div>
        <div class="mt-3 grid grid-cols-5 gap-2">
          @foreach($galleryImages as $idx => $image)
            <button type="button" class="best-buy-thumb border border-[#d6a7bf] bg-white p-0.5 {{ $idx === 0 ? 'ring-1 ring-[#8b3c73]' : '' }}" data-image="{{ $image }}" aria-label="thumbnail {{ $idx + 1 }}">
              <img src="{{ $image }}" alt="{{ $product['title'] }} thumbnail {{ $idx + 1 }}" class="w-full h-20 object-cover" />
            </button>
          @endforeach
        </div>
      </div>

      <div class="pt-1 max-w-[560px]">
        <p class="text-[10px] uppercase tracking-[0.28em] text-[#b06795]">AVNEE 6-14 YEARS ARCHIVE</p>
        <h1 class="font-heading text-6xl leading-[0.92] text-[#231238] mt-2">{{ strtoupper($product['title']) }}</h1>
        <p class="text-[14px] text-[#231238] mt-2 font-semibold">{{ $product['title'] }}</p>
        <p class="text-[13px] text-[#8a5b78] mt-1">Style No {{ $product['sku'] }}</p>

        <div class="mt-5 flex items-center gap-3">
          <span class="text-[46px] font-black leading-none text-[#1f1f2f]">₹{{ number_format($product['price'], 0) }}</span>
          <span class="text-[16px] text-[#7f4a6a] line-through">₹999</span>
        </div>
        <p class="text-[13px] text-[#7f4a6a] mt-1">Inclusive of all taxes</p>
        <p class="text-[14px] text-[#9a6c87] mt-4">6-14 Years curated piece from AVNEE gallery collection.</p>

        <div class="mt-5 border border-[#d8b0c5] bg-white overflow-hidden">
          <img src="{{ asset('images/coupons/avnee7.jpeg') }}" alt="AVNEE7 Coupon Banner" class="w-full h-auto object-cover" />
        </div>

        <div class="mt-5">
          <div class="flex items-center justify-between text-[12px] uppercase tracking-[0.24em] text-[#7f3f66] mb-2">
            <span>Size</span>
            <span class="normal-case tracking-normal text-[#8b3c73] underline text-[14px]">Size Guide</span>
          </div>
          <div class="flex flex-wrap gap-2.5" id="size-selector">
            @foreach(['0-6 Months','1-2 Years','2-3 Years','3-4 Years','4-5 Years','5-6 Years','6-7 Years','7-8 Years'] as $size)
              <button type="button" data-size="{{ $size }}" class="size-btn px-4 py-2.5 border border-[#d6a7bf] bg-white text-[14px] text-[#5f2d4f] rounded-full hover:bg-[#ffeaf4] {{ $loop->first ? 'selected bg-black text-white border-black' : '' }}">{{ $size }}</button>
            @endforeach
          </div>
        </div>

        <div class="mt-6 grid grid-cols-[1fr_auto] gap-2">
          <div class="relative">
            <input id="bb-delivery-pincode-input" type="text" inputmode="numeric" maxlength="6" autocomplete="off" placeholder="Express Delivery? Start with your PIN" class="w-full h-11 border border-[#d8b0c5] bg-white px-3 text-[13px] text-[#5f2d4f]" />
            <div id="bb-delivery-pincode-suggestions" class="hidden absolute left-0 right-0 top-[calc(100%+4px)] z-30 border border-[#d8b0c5] bg-white text-[#5f2d4f] max-h-52 overflow-y-auto shadow-lg"></div>
          </div>
          <button id="bb-delivery-pincode-check-btn" type="button" class="h-11 px-5 bg-[#1f2f2f] text-white text-[13px] font-semibold">Check Service</button>
        </div>
        <p id="bb-delivery-pincode-feedback" class="text-[12px] text-[#df5d6b] mt-2">Valid 6-digit PIN required</p>

        <div class="mt-3 grid grid-cols-[80px_1fr] gap-2">
          <div class="h-11 border border-[#d6a7bf] bg-white flex items-center justify-center gap-3">
            <button type="button" id="qty-minus" class="text-xl leading-none">-</button>
            <span id="qty-value" class="text-[16px]">1</span>
            <button type="button" id="qty-plus" class="text-xl leading-none">+</button>
          </div>
          <button type="button" class="h-11 bg-black text-white text-[14px] font-semibold uppercase tracking-[0.08em]">Add to Cart - ₹{{ number_format($product['price'], 0) }}</button>
        </div>
        <button type="button" class="mt-2 h-11 w-full border border-[#8f5a77] text-[#2d1126] bg-[#f7d6e6] text-[14px] font-semibold uppercase tracking-[0.08em]">Buy it now</button>

        <ul class="mt-4 text-[13px] text-[#8a5b78] space-y-2">
          <li>10 people are currently looking at this product.</li>
          <li>100% Purchase Protection and Assured Quality.</li>
          <li>5 Day easy return*</li>
        </ul>

        <div class="mt-6 border-t border-[#d8b0c5]">
          @foreach(['Product Details' => $product['description'], 'Style & Fit Tips' => 'Comfort fit with breathable fabric for all-day wear.', 'Shipping & Returns' => 'Ships in 2-4 business days. Easy returns within 5 days.', 'FAQs' => 'Need help with sizing? Contact our concierge team.'] as $title => $content)
            <details class="border-b border-[#d8b0c5] py-3" {{ $loop->first ? 'open' : '' }}>
              <summary class="cursor-pointer font-semibold text-[14px] uppercase tracking-[0.12em] text-[#41203a]">{{ $title }}</summary>
              <p class="mt-2 text-[14px] text-[#5f2d4f]">{{ $content }}</p>
            </details>
          @endforeach
        </div>
        <p class="mt-6 text-[13px] text-[#9a6c87]">Main image is shown first, and all remaining photos from this product folder are available in the gallery below.</p>
        <a href="{{ route('front.products.collection', ['collection' => 'best-sellers']) }}" class="mt-3 inline-block text-[13px] uppercase tracking-[0.2em] text-[#7f2458] font-semibold">Back to 6-14 years</a>
      </div>
    </div>

    <div class="mt-14 -mx-4 sm:-mx-6 lg:-mx-8 bg-[#efefef] border-t border-[#dfdfdf] px-4 sm:px-6 lg:px-8 py-12">
      <div class="max-w-[1240px] mx-auto">
      <h2 class="font-heading text-5xl text-center text-[#2b003a] mb-6">Similar Products</h2>
      <div class="relative">
        <button id="similar-prev" class="absolute -left-3 top-1/2 -translate-y-1/2 z-10 w-9 h-9 rounded-full bg-white border border-[#d8d8d8]">&#8249;</button>
        <button id="similar-next" class="absolute -right-3 top-1/2 -translate-y-1/2 z-10 w-9 h-9 rounded-full bg-white border border-[#d8d8d8]">&#8250;</button>
        <div class="swiper similar-products-swiper">
          <div class="swiper-wrapper">
        @foreach($similarProducts as $item)
            <div class="swiper-slide">
              <a href="{{ route('front.best-buys.show', $item['slug']) }}" class="bg-white border border-[#d6a7bf] block">
                <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="w-full h-52 object-cover" />
                <div class="p-2">
                  <p class="text-[12px] font-semibold line-clamp-2 leading-tight">{{ $item['title'] }}</p>
                  <p class="text-[13px] font-bold mt-1">₹{{ number_format($item['price'], 0) }}</p>
                </div>
              </a>
            </div>
        @endforeach
          </div>
        </div>
      </div>
      </div>

      <h2 class="font-heading text-5xl text-center text-[#2b003a] mt-10 mb-6">Recently Viewed</h2>
      <div class="relative">
        <button id="recent-prev" class="absolute -left-3 top-1/2 -translate-y-1/2 z-10 w-9 h-9 rounded-full bg-white border border-[#d8d8d8]">&#8249;</button>
        <button id="recent-next" class="absolute -right-3 top-1/2 -translate-y-1/2 z-10 w-9 h-9 rounded-full bg-white border border-[#d8d8d8]">&#8250;</button>
        <div class="swiper recently-viewed-swiper">
          <div class="swiper-wrapper">
        @foreach($recentlyViewed as $item)
            <div class="swiper-slide">
              <a href="{{ route('front.best-buys.show', $item['slug']) }}" class="bg-white border border-[#d6a7bf] block">
                <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="w-full h-52 object-cover" />
                <div class="p-2">
                  <p class="text-[12px] font-semibold line-clamp-2 leading-tight">{{ $item['title'] }}</p>
                  <p class="text-[13px] font-bold mt-1">₹{{ number_format($item['price'], 0) }}</p>
                </div>
              </a>
            </div>
        @endforeach
          </div>
        </div>
      </div>
      </div>
    </div>
  </div>
</section>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Size selection logic
    const sizeSelector = document.getElementById('size-selector');
    if (sizeSelector) {
      sizeSelector.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('size-btn')) {
          sizeSelector.querySelectorAll('.size-btn').forEach(btn => {
            btn.classList.remove('selected', 'bg-black', 'text-white', 'border-black');
            btn.classList.add('bg-white', 'text-[#5f2d4f]', 'border-[#d6a7bf]');
          });
          e.target.classList.add('selected', 'bg-black', 'text-white', 'border-black');
          e.target.classList.remove('bg-white', 'text-[#5f2d4f]', 'border-[#d6a7bf]');
        }
      });
    }
    const mainImage = document.getElementById('best-buy-main-image');
    const thumbs = document.querySelectorAll('.best-buy-thumb');
    const galleryPrev = document.getElementById('gallery-prev');
    const galleryNext = document.getElementById('gallery-next');
    const galleryCounter = document.getElementById('gallery-counter');
    const galleryImages = Array.from(thumbs).map((node) => node.getAttribute('data-image'));
    let activeIndex = 0;

    const setActiveImage = (index) => {
      if (!mainImage || galleryImages.length === 0) return;
      activeIndex = (index + galleryImages.length) % galleryImages.length;
      mainImage.src = galleryImages[activeIndex];
      thumbs.forEach((node) => node.classList.remove('ring-1', 'ring-[#8b3c73]'));
      if (thumbs[activeIndex]) {
        thumbs[activeIndex].classList.add('ring-1', 'ring-[#8b3c73]');
      }
      if (galleryCounter) {
        galleryCounter.textContent = `${activeIndex + 1} / ${galleryImages.length}`;
      }
    };

    thumbs.forEach((thumb) => {
      thumb.addEventListener('click', function () {
        const image = thumb.getAttribute('data-image');
        if (!image) return;
        const nextIndex = galleryImages.indexOf(image);
        if (nextIndex >= 0) setActiveImage(nextIndex);
      });
    });

    galleryPrev?.addEventListener('click', () => setActiveImage(activeIndex - 1));
    galleryNext?.addEventListener('click', () => setActiveImage(activeIndex + 1));

    const qtyValue = document.getElementById('qty-value');
    const qtyMinus = document.getElementById('qty-minus');
    const qtyPlus = document.getElementById('qty-plus');
    let qty = 1;
    qtyMinus?.addEventListener('click', () => {
      qty = Math.max(1, qty - 1);
      if (qtyValue) qtyValue.textContent = String(qty);
    });
    qtyPlus?.addEventListener('click', () => {
      qty = Math.min(99, qty + 1);
      if (qtyValue) qtyValue.textContent = String(qty);
    });

    if (document.querySelector('.similar-products-swiper')) {
      new Swiper('.similar-products-swiper', {
        slidesPerView: 2,
        spaceBetween: 10,
        navigation: {
          prevEl: '#similar-prev',
          nextEl: '#similar-next',
        },
        breakpoints: {
          640: { slidesPerView: 3, spaceBetween: 12 },
          1024: { slidesPerView: 5, spaceBetween: 12 },
        },
      });
    }

    if (document.querySelector('.recently-viewed-swiper')) {
      new Swiper('.recently-viewed-swiper', {
        slidesPerView: 2,
        spaceBetween: 10,
        navigation: {
          prevEl: '#recent-prev',
          nextEl: '#recent-next',
        },
        breakpoints: {
          640: { slidesPerView: 3, spaceBetween: 12 },
          1024: { slidesPerView: 5, spaceBetween: 12 },
        },
      });
    }

    (function initBestBuyPincodeValidation() {
      const input = document.getElementById('bb-delivery-pincode-input');
      const checkBtn = document.getElementById('bb-delivery-pincode-check-btn');
      const feedback = document.getElementById('bb-delivery-pincode-feedback');
      const list = document.getElementById('bb-delivery-pincode-suggestions');
      if (!input || !checkBtn || !feedback || !list) return;

      const DATASET_URLS = [
        'https://cdn.jsdelivr.net/gh/saravanakumargn/All-India-Pincode-Directory@master/all-india-pincode-json-array.json',
        'https://raw.githubusercontent.com/saravanakumargn/All-India-Pincode-Directory/master/all-india-pincode-json-array.json'
      ];
      let allPincodes = [];
      let byPincode = new Map();
      let loaded = false;
      let loadingPromise = null;

      const setFeedback = (message, isError = true) => {
        feedback.textContent = message;
        feedback.classList.toggle('text-[#df5d6b]', isError);
        feedback.classList.toggle('text-green-700', !isError);
      };

      const hideSuggestions = () => {
        list.classList.add('hidden');
        list.innerHTML = '';
      };

      const loadDataset = async () => {
        if (loaded) return;
        if (loadingPromise) return loadingPromise;
        loadingPromise = (async () => {
          let rows = null;
          for (const url of DATASET_URLS) {
            try {
              const res = await fetch(url);
              if (!res.ok) continue;
              rows = await res.json();
              break;
            } catch (_) {
              // Try next dataset source.
            }
          }
          if (!rows) throw new Error('Failed to load pincode dataset');
          return rows;
        })()
          .then((rows) => {
            const seen = new Set();
            (Array.isArray(rows) ? rows : []).forEach((row) => {
              const pin = String(row.pincode || '').replace(/\D/g, '').slice(0, 6);
              if (!/^\d{6}$/.test(pin)) return;
              if (!seen.has(pin)) {
                allPincodes.push(pin);
                seen.add(pin);
              }
              if (!byPincode.has(pin)) {
                byPincode.set(pin, { district: row.Districtname || '', state: row.statename || '' });
              }
            });
            allPincodes.sort();
            loaded = true;
          })
          .catch(() => setFeedback('Unable to load pincode suggestions right now. Enter full PIN to validate.'));
        return loadingPromise;
      };

      const renderSuggestions = async (value) => {
        const query = (value || '').replace(/\D/g, '');
        if (query.length < 2) return hideSuggestions();
        await loadDataset();
        if (!loaded) return;
        const matches = allPincodes.filter((pin) => pin.startsWith(query)).slice(0, 8);
        if (!matches.length) return hideSuggestions();
        list.innerHTML = matches.map((pin) => {
          const meta = byPincode.get(pin) || {};
          const hint = [meta.district, meta.state].filter(Boolean).join(', ');
          return '<button type="button" class="w-full text-left px-3 py-2 text-xs hover:bg-[#fff2f7]" data-pin="' + pin + '"><span class="font-semibold">' + pin + '</span>' + (hint ? '<span class="block opacity-70 mt-0.5">' + hint + '</span>' : '') + '</button>';
        }).join('');
        list.classList.remove('hidden');
      };

      input.addEventListener('input', () => {
        input.value = input.value.replace(/\D/g, '').slice(0, 6);
        setFeedback('Valid 6-digit PIN required', true);
        renderSuggestions(input.value);
      });
      input.addEventListener('focus', () => renderSuggestions(input.value));
      list.addEventListener('click', (event) => {
        const btn = event.target.closest('[data-pin]');
        if (!btn) return;
        input.value = btn.getAttribute('data-pin') || '';
        hideSuggestions();
        checkBtn.click();
      });
      document.addEventListener('click', (event) => {
        if (!list.contains(event.target) && event.target !== input) hideSuggestions();
      });

      checkBtn.addEventListener('click', async () => {
        const pin = input.value.replace(/\D/g, '').slice(0, 6);
        input.value = pin;
        if (!/^\d{6}$/.test(pin)) return setFeedback('Please enter a valid 6-digit PIN code.');
        await loadDataset();
        if (loaded && byPincode.has(pin)) {
          const meta = byPincode.get(pin) || {};
          const location = [meta.district, meta.state].filter(Boolean).join(', ');
          setFeedback('Delivery available at ' + pin + (location ? ' for ' + location : '') + '.', false);
          return;
        }

        try {
          const res = await fetch('https://api.postalpincode.in/pincode/' + pin);
          const data = await res.json();
          const first = Array.isArray(data) ? data[0] : null;
          const offices = first && Array.isArray(first.PostOffice) ? first.PostOffice : [];
          if (first && first.Status === 'Success' && offices.length > 0) {
            const place = [offices[0].District, offices[0].State].filter(Boolean).join(', ');
            setFeedback('Valid Indian PIN: ' + pin + (place ? ' (' + place + ')' : '') + '.', false);
          } else {
            setFeedback('PIN ' + pin + ' is not a valid Indian pincode.');
          }
        } catch (_) {
          setFeedback('Could not verify PIN right now. Please try again.');
        }
      });
    })();

    setActiveImage(0);
  });
</script>
@endsection
