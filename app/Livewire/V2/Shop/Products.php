<?php

namespace App\Livewire\V2\Shop;

use App\Models\MProduct;
use App\Models\MProductVariant;
use Livewire\Component;
use Livewire\WithPagination;

class Products extends Component
{
    use WithPagination;

    // Search and filter properties
    public $search = '';
    public $sortBy = 'newest'; // newest, oldest, price_low, price_high, name_asc, name_desc, rating
    public $priceMin = '';
    public $priceMax = '';
    public $inStockOnly = false;
    public $showFilters = false;
    
    // Pagination
    public $perPage = 12;

    protected $queryString = [
        'search' => ['except' => ''],
        'sortBy' => ['except' => 'newest'],
        'priceMin' => ['except' => ''],
        'priceMax' => ['except' => ''],
        'inStockOnly' => ['except' => false],
    ];

    public function mount()
    {
        // Initialize any default values if needed
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSortBy()
    {
        $this->resetPage();
    }

    public function updatedPriceMin()
    {
        $this->resetPage();
    }

    public function updatedPriceMax()
    {
        $this->resetPage();
    }

    public function updatedInStockOnly()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->sortBy = 'newest';
        $this->priceMin = '';
        $this->priceMax = '';
        $this->inStockOnly = false;
        $this->resetPage();
    }

    public function toggleFilters()
    {
        $this->showFilters = !$this->showFilters;
    }

    public function render()
    {
        $query = MProduct::with(['variants', 'reviews'])
            ->where('status', true);

        // Apply search
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name_service', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhere('sku', 'like', '%' . $this->search . '%');
            });
        }

        // Apply price filters
        if (!empty($this->priceMin) || !empty($this->priceMax)) {
            $query->whereHas('variants', function ($q) {
                if (!empty($this->priceMin)) {
                    $q->where('price', '>=', $this->priceMin);
                }
                if (!empty($this->priceMax)) {
                    $q->where('price', '<=', $this->priceMax);
                }
            });
        }

        // Apply stock filter
        if ($this->inStockOnly) {
            $query->whereHas('variants', function ($q) {
                $q->where('stock', '>', 0);
            });
        }

        // Apply sorting
        switch ($this->sortBy) {
            case 'oldest':
                $query->orderBy('id', 'asc');
                break;
            case 'price_low':
                $query->leftJoin('m_product_variants', 'm_products.id', '=', 'm_product_variants.m_product_id')
                      ->select('m_products.*')
                      ->orderByRaw('MIN(m_product_variants.price) ASC')
                      ->groupBy('m_products.id');
                break;
            case 'price_high':
                $query->leftJoin('m_product_variants', 'm_products.id', '=', 'm_product_variants.m_product_id')
                      ->select('m_products.*')
                      ->orderByRaw('MAX(m_product_variants.price) DESC')
                      ->groupBy('m_products.id');
                break;
            case 'name_asc':
                $query->orderBy('name_service', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name_service', 'desc');
                break;
            case 'rating':
                $query->leftJoin('product_reviews', 'm_products.id', '=', 'product_reviews.m_product_id')
                      ->select('m_products.*')
                      ->orderByRaw('AVG(product_reviews.rating) DESC')
                      ->groupBy('m_products.id');
                break;
            default: // newest
                $query->orderBy('id', 'desc');
                break;
        }

        $products = $query->paginate($this->perPage);

        return view('livewire.v2.shop.products', compact('products'));
    }
}


