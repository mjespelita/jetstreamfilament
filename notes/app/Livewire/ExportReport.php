<?php

namespace App\Livewire;

use App\Models\Stocks;
use App\Smark\Smark;
use Livewire\Component;

class ExportReport extends Component
{

    public $stocks;

    public function mount()
    {
        sleep(2);
    }

    function placeholder()
    {
        return <<<'HTML'
            <div>Loading...</div>
        HTML;
    }

    public function render()
    {
        $this->stocks = Stocks::all();
        return <<<'HTML'
            <main>
                <a href="/export-report-process">
                    <button>Export All Products</button>
                </a>

                @forelse($stocks as $stock)
                    <div lazy>
                        <h3>{{ $stock->name }}</h3>
                    </div>
                @empty
                    <div>
                        <h3>No Stocks</h3>
                    </div>
                @endforelse
            </main>
        HTML;
    }
}
