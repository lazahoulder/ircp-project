<?php

namespace App\Utilities;

class ParticipantsFormatDataUtility
{
    protected static function getFormtionAdditionnalData(array $data, array $requiredColumns = []): array
    {
        $formation_data = [];

        foreach ($data as $key => $value) {
            if (empty($value)) {
                continue;
            }

            if ($key === '' || $value == '' ) {
                continue;
            }

            if (!in_array($key, $requiredColumns)) {
                $formation_data[strtolower($key)] = $value;
            }
        }

        return $formation_data;
    }

    public static function formatPersonneCertifieData(array $data): array
    {
        return [
            'nom' => $data['NOM'],
            'prenom' => $data['PRENOM'],
            'date_naissance' => $data['DATE DE NAISSANCE'],
            'nationality' => $data['NATIONALITE'],
        ];
    }

    public static function formatPersonneCertifieCondition(array $data): array
    {
        return [
            'nom' => trim($data['NOM']),
            'prenom' => trim($data['PRENOM']),
            'nationality' => $data['NATIONALITE'],
        ];
    }

    public static function formatCertificateData(array $data, array $requredColumn = []): array
    {
        $dataCertificate = [
            'formation_data' => self::getFormtionAdditionnalData($data, $requredColumn),
            'numero_certificat' => preg_replace('/\s+/', '', $data['NUMERO CERTIFICAT']),
            'date_certification' => null,
            'image_id' => $data['PHOTO'],
        ];

        if ($data['PHOTO']) {
            $dataCertificate['image_id'] = $data['PHOTO'];
        }

        return $dataCertificate;
    }
}
