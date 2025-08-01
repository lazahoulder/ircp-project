<?php

use App\Constant\CertificateConstant;
use App\Models\Certificate;
use Carbon\Carbon;
use Livewire\Volt\Component;

new class extends Component {
    public $countMonth = 0;
    public $countVaidate = 0;
    public $countIncomplete = 0;
    public $countWaiting = 0;

    public function mount()
    {
        $this->countIncomplete = Certificate::where('status', CertificateConstant::STATUS_INCOMPLET)->count();
        $this->countVaidate = Certificate::where('status', CertificateConstant::STATUS_VALID)->count();
        $this->countWaiting = Certificate::where('status', CertificateConstant::STATUS_EN_ATTENTE)->count();
        $this->countMonth = Certificate::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)->count();
    }
}; ?>

<section class="min-w-full">
    <h5 class="text-xl font-semibold mb-6 text-center">Les Certificats</h5>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6">
        <div class="flex items-center gap-4 p-4 rounded-xl bg-teal-50 dark:bg-teal-900 text-teal-900 dark:text-teal-100 shadow">
            <flux:icon name="document-check" class="h-8 w-8 text-teal-600 dark:text-teal-300" />
            <div>
                <div class="text-sm font-medium text-teal-800 dark:text-teal-200">Certificats ajoutés</div>
                <div class="text-xl font-semibold">{{ $countMonth }}</div>
            </div>
        </div>
        <a href="{{ route('admin.certificates', ['status' => CertificateConstant::STATUS_INCOMPLET]) }}" class="flex items-center gap-4 p-4 rounded-xl bg-orange-50 dark:bg-orange-900 text-orange-900 dark:text-orange-100 shadow">
            <flux:icon name="photo" class="h-8 w-8 text-orange-600 dark:text-orange-300" />
            <div>
                <div class="text-sm font-medium text-orange-800 dark:text-orange-200">Certificats incomplets (photo manquante)</div>
                <div class="text-xl font-semibold">{{ $countIncomplete }}</div>
            </div>
        </a>
        <a href="{{ route('admin.certificates', ['status' => CertificateConstant::STATUS_VALID]) }}" class="flex items-center gap-4 p-4 rounded-xl bg-green-600 text-white shadow hover:opacity-90 transition col-span-full lg:col-span-1">
            <flux:icon name="check" class="h-8 w-8 text-green-300" />
            <div>
                <div class="text-sm font-medium ">Certificat validé</div>
                <div class="text-xl font-semibold">{{ $countVaidate }}</div>
            </div>
        </a>
        <a href="{{ route('admin.certificates', ['status' => CertificateConstant::STATUS_EN_ATTENTE]) }}" class="flex items-center gap-4 p-4 rounded-xl bg-yellow-600 text-white shadow hover:opacity-90 transition">
            <flux:icon name="exclamation-circle" class="h-8 w-8 text-yellow-300" />
            <div>
                <div class="text-sm font-medium">Certificat en attente de validation</div>
                <div class="text-2xl font-bold">{{ $countWaiting }}</div>
            </div>
        </a>
    </div>
</section>
