<?php

namespace App\Livewire\User;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class MyOrders extends Component
{
    use WithPagination;

    public $selectedStatus = 'all';
    public $search = '';

    protected $queryString = ['selectedStatus', 'search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedStatus()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Order::where('user_id', Auth::id())
            ->with('items')
            ->orderBy('created_at', 'desc');

        if ($this->selectedStatus !== 'all') {
            $query->where('status', $this->selectedStatus);
        }

        if ($this->search) {
            $query->where(function($q) {
                $q->where('order_number', 'like', '%' . $this->search . '%')
                  ->orWhereHas('items', function($q) {
                      $q->where('product_name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        $orders = $query->paginate(10);

        return view('livewire.user.my-orders', [
            'orders' => $orders
        ]);
    }
}
