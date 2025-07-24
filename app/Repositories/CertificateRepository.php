<?php

namespace App\Repositories;

use App\Contract\Repositories\CertificateRepositoryInterface;
use App\Models\Certificate;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class CertificateRepository implements CertificateRepositoryInterface
{

    private function searchQuery(string $search = ''): Builder
    {
        $query = Certificate::query()
            ->join('formation_reels', 'certificates.formation_reel_id', '=', 'formation_reels.id')
            ->join('formations', 'formation_reels.formation_id', '=', 'formations.id')
            ->join('personne_certifies', 'certificates.personne_certifies_id', '=', 'personne_certifies.id')
            ->where(function (Builder $query) use ($search) {
                $query
                    ->where('certificates.numero_certificat', 'like', '%' . $search . '%')
                    ->orWhere('personne_certifies.nom', 'like', '%' . $search . '%')
                    ->orWhere('personne_certifies.prenom', 'like', '%' . $search . '%')
                    ->orWhere('formations.titre', 'like', '%' . $search . '%');
            })
        ;

        return $query;
    }
    public function all(): Paginator
    {
        return Certificate::query()->paginate(15, pageName: 'certificates');
    }

    public function search(string $search = ''): Paginator
    {
        $query = $this->searchQuery($search);

        return $query->paginate(15, pageName: 'certificates');
    }

    public function find(int $id): ?Certificate
    {
        return Certificate::find($id);
    }

    /**
     * Create a new certificate
     *
     * @param array $data
     * @return Certificate
     */
    public function create(array $data): Certificate
    {
        return Certificate::create($data);
    }

    /**
     * Update an existing certificate
     *
     * @param Certificate $certificate
     * @param array $data
     * @return Certificate
     */
    public function update(Certificate $certificate, array $data): Certificate
    {
        $certificate->update($data);
        return $certificate;
    }

    public function searchByFormationReelId(string $search = '', ?int $formationReelId = null): LengthAwarePaginator
    {
        $query = $this->searchQuery($search);

        if ($formationReelId) {
            $query->where('formation_reel_id', $formationReelId);
        };

        return $query->paginate(15, pageName: 'certificates');
    }
}
