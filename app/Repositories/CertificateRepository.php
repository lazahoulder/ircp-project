<?php

namespace App\Repositories;

use App\Constant\CertificateConstant;
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
            ->select([
                'certificates.*', // Sélectionne explicitement toutes les colonnes de certificates
                'formations.titre',
                'personne_certifies.nom',
                'personne_certifies.prenom',
            ])
            ->join('formation_reels', 'certificates.formation_reel_id', '=', 'formation_reels.id')
            ->join('formations', 'formation_reels.formation_id', '=', 'formations.id')
            ->join('personne_certifies', 'certificates.personne_certifies_id', '=', 'personne_certifies.id')
            //->join('entite_emmeteurs', 'formations.entite_emmeteur_id', '=', 'entite_emmeteurs.id')
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

    public function searchValide(String $search = ''): Paginator
    {
        return $this->searchByStatus($search, CertificateConstant::STATUS_VALID);
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

    public function upCreate(array $data, array $conditions = [])
    {
        if (empty($conditions)) {
            return $this->create($data);
        }

        return Certificate::updateOrCreate($conditions, $data);
    }

    public function searchByFormationReelId(string $search = '', ?int $formationReelId = null): LengthAwarePaginator
    {
        $query = $this->searchQuery($search);

        if ($formationReelId) {
            $query->where('formation_reel_id', $formationReelId);
        };

        return $query->paginate(15, pageName: 'certificates');
    }

    public function searchByStatus(string $search = '', ?string $status = null): Paginator
    {
        $query = $this->searchQuery($search);
        if ($status) {
            $query->where('status', $status);
        }

        return $query->paginate(15, pageName: 'certificates');
    }

    public function searchForAdmin(string $search, ?int $entiteId, ?int $formationId, ?string $status = null): Paginator
    {
        $query = $this->searchQuery($search);
        if ($status) {
            $query->where('certificates.status', $status);
        }

        if ($entiteId) {
            $query->where('formations.entite_emmeteur_id', $entiteId);
        }

        if ($formationId) {
            $query->where('formations.id', $formationId);
        }

        return $query->paginate(15, pageName: 'certificates');
    }
}
