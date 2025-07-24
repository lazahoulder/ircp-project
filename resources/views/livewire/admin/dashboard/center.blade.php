<?php

use App\Constant\EntiteEmmeteursConstant;
use App\Models\EntiteEmmeteurs;
use App\Services\EntiteEmmeteursService;
use Carbon\Carbon;
use Livewire\Volt\Component;

new class extends Component {
    public $countMonth = 0;
    public $countVaidate = 0;
    public $countIncomplete = 0;
    public $countWaiting = 0;

    public function mount()
    {
        $this->countIncomplete = EntiteEmmeteurs::where('status', EntiteEmmeteursConstant::STATUS_INCOMPLET)->count();
        $this->countVaidate = EntiteEmmeteurs::where('status', EntiteEmmeteursConstant::STATUS_VALID)->count();
        $this->countWaiting = EntiteEmmeteurs::where('status', EntiteEmmeteursConstant::STATUS_EN_ATTENTE)->count();
        $this->countMonth = EntiteEmmeteurs::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)->count();
    }
}; ?>

<section class="min-w-full">
    <h3 class="text-xl font-semibold mb-6 text-center">Les entités</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6">
        <a href="{{ route('admin.etablissements') }}"
           class="flex items-center gap-4 p-4 rounded-xl bg-blue-600 text-white shadow hover:opacity-90 transition">
            <flux:icon name="users" class="h-8 w-8 text-blue-300"/>
            <div>
                <div class="text-sm font-medium">Entités inscrites ce mois</div>
                <div class="text-2xl font-bold">{{ $countMonth }}</div>
            </div>
        </a>

        <a href="{{ route('admin.etablissements', ['status' => EntiteEmmeteursConstant::STATUS_EN_ATTENTE]) }}"
           class="flex items-center gap-4 p-4 rounded-xl bg-yellow-600 text-white shadow hover:opacity-90 transition">
            <flux:icon name="exclamation-circle" class="h-8 w-8 text-yellow-300"/>
            <div>
                <div class="text-sm font-medium">Entités en attente</div>
                <div class="text-2xl font-bold">{{ $countWaiting }}</div>
            </div>
        </a>

        <a href="{{ route('admin.etablissements', ['status' => EntiteEmmeteursConstant::STATUS_INCOMPLET]) }}"
           class="flex items-center gap-4 p-4 rounded-xl bg-red-600 text-white shadow hover:opacity-90 transition">
            <flux:icon name="x-circle" class="h-8 w-8 text-red-300"/>
            <div>
                <div class="text-sm font-medium">Entités incomplètes</div>
                <div class="text-2xl font-bold">{{ $countIncomplete }}</div>
            </div>
        </a>

        <a href="{{ route('admin.etablissements', ['status' => EntiteEmmeteursConstant::STATUS_VALID]) }}"
           class="flex items-center gap-4 p-4 rounded-xl bg-green-600 text-white shadow hover:opacity-90 transition col-span-full lg:col-span-1">
            <flux:icon name="check-badge" class="h-8 w-8 text-green-300"/>
            <div>
                <div class="text-sm font-medium">Entités validées</div>
                <div class="text-2xl font-bold">{{ $countVaidate }}</div>
            </div>
        </a>
    </div>
</section>
