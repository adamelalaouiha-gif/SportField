<?php

namespace Database\Seeders;

use App\Models\Club;
use App\Models\Demande;
use App\Models\Reservation;
use App\Models\Terrain;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🌱 Création des données de test...');

        // ── 1. Super Admin ─────────────────────────────────────────────────────
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@sportsfield.ma'],
            [
                'prenom'            => 'Super',
                'nom'               => 'Admin',
                'password'          => Hash::make('password123'),
                'role'              => 'super_admin',
                'email_verified_at' => now(),
            ]
        );
        $this->command->info('✅ Super Admin : admin@sportsfield.ma / password123');

        // ── 2. Clients de test ─────────────────────────────────────────────────
        $clients = [
            ['prenom' => 'Ahmed',   'nom' => 'Benali',   'email' => 'ahmed@test.ma'],
            ['prenom' => 'Fatima',  'nom' => 'Zahra',    'email' => 'fatima@test.ma'],
            ['prenom' => 'Youssef', 'nom' => 'El Idrissi','email' => 'youssef@test.ma'],
            ['prenom' => 'Sara',    'nom' => 'Alami',    'email' => 'sara@test.ma'],
            ['prenom' => 'Omar',    'nom' => 'Tazi',     'email' => 'omar@test.ma'],
        ];

        foreach ($clients as $client) {
            User::firstOrCreate(
                ['email' => $client['email']],
                array_merge($client, [
                    'password'          => Hash::make('password123'),
                    'role'              => 'client',
                    'email_verified_at' => now(),
                ])
            );
        }

        // 10 clients aléatoires supplémentaires
        User::factory()->count(10)->create();
        $this->command->info('✅ 15 clients créés');

        // ── 3. Clubs avec admins ────────────────────────────────────────────────
        $clubsData = [
            [
                'admin'  => ['prenom' => 'Khalid', 'nom' => 'Mansouri', 'email' => 'khalid.admin@test.ma'],
                'club'   => [
                    'nom'         => 'Complex Sportif Al Amal',
                    'adresse'     => 'Avenue Mohammed V, Kénitra',
                    'telephone'   => '0537123456',
                    'description' => 'Le meilleur complexe sportif de Kénitra avec des terrains modernes.',
                    'sports'      => ['foot', 'basketball', 'padel'],
                    'horaires'    => [
                        'Lundi'    => '08:00 - 23:00',
                        'Mardi'    => '08:00 - 23:00',
                        'Mercredi' => '08:00 - 23:00',
                        'Jeudi'    => '08:00 - 23:00',
                        'Vendredi' => '08:00 - 23:00',
                        'Samedi'   => '08:00 - 22:00',
                        'Dimanche' => '09:00 - 18:00',
                    ],
                ],
                'terrains' => [
                    ['nom' => 'Mini Foot 1',   'type_sport' => 'foot',       'prix_heure' => 200],
                    ['nom' => 'Mini Foot 2',   'type_sport' => 'foot',       'prix_heure' => 200],
                    ['nom' => 'Court Basket',  'type_sport' => 'basketball', 'prix_heure' => 120],
                    ['nom' => 'Piste Padel 1', 'type_sport' => 'padel',      'prix_heure' => 150],
                ],
            ],
            [
                'admin'  => ['prenom' => 'Nadia', 'nom' => 'El Fassi', 'email' => 'nadia.admin@test.ma'],
                'club'   => [
                    'nom'         => 'Arena Sports Rabat',
                    'adresse'     => 'Rue Souissi, Rabat',
                    'telephone'   => '0537654321',
                    'description' => 'Centre sportif moderne au coeur de Rabat.',
                    'sports'      => ['tennis', 'padel', 'volleyball'],
                    'horaires'    => [
                        'Lundi'    => '07:00 - 22:00',
                        'Mardi'    => '07:00 - 22:00',
                        'Mercredi' => '07:00 - 22:00',
                        'Jeudi'    => '07:00 - 22:00',
                        'Vendredi' => '07:00 - 22:00',
                        'Samedi'   => '08:00 - 20:00',
                        'Dimanche' => '09:00 - 17:00',
                    ],
                ],
                'terrains' => [
                    ['nom' => 'Court Tennis 1', 'type_sport' => 'tennis',     'prix_heure' => 180],
                    ['nom' => 'Court Tennis 2', 'type_sport' => 'tennis',     'prix_heure' => 180],
                    ['nom' => 'Padel Center',   'type_sport' => 'padel',      'prix_heure' => 160],
                    ['nom' => 'Volley Beach',   'type_sport' => 'volleyball', 'prix_heure' => 100],
                ],
            ],
            [
                'admin'  => ['prenom' => 'Rachid', 'nom' => 'Berrada', 'email' => 'rachid.admin@test.ma'],
                'club'   => [
                    'nom'         => 'Club Champion Casablanca',
                    'adresse'     => 'Boulevard Anfa, Casablanca',
                    'telephone'   => '0522345678',
                    'description' => 'Club haut de gamme à Casablanca pour les sportifs exigeants.',
                    'sports'      => ['foot', 'tennis', 'basketball', 'padel'],
                    'horaires'    => [
                        'Lundi'    => '06:00 - 23:00',
                        'Mardi'    => '06:00 - 23:00',
                        'Mercredi' => '06:00 - 23:00',
                        'Jeudi'    => '06:00 - 23:00',
                        'Vendredi' => '06:00 - 23:00',
                        'Samedi'   => '07:00 - 22:00',
                        'Dimanche' => '08:00 - 20:00',
                    ],
                ],
                'terrains' => [
                    ['nom' => 'Terrain Foot A',  'type_sport' => 'foot',       'prix_heure' => 300],
                    ['nom' => 'Terrain Foot B',  'type_sport' => 'foot',       'prix_heure' => 300],
                    ['nom' => 'Court Tennis VIP','type_sport' => 'tennis',     'prix_heure' => 250],
                    ['nom' => 'Basket Arena',    'type_sport' => 'basketball', 'prix_heure' => 150],
                    ['nom' => 'Padel Pro',       'type_sport' => 'padel',      'prix_heure' => 200],
                ],
            ],
        ];

        foreach ($clubsData as $data) {
            // Créer l'admin
            $admin = User::firstOrCreate(
                ['email' => $data['admin']['email']],
                array_merge($data['admin'], [
                    'password'          => Hash::make('password123'),
                    'role'              => 'admin',
                    'email_verified_at' => now(),
                ])
            );

            // Créer le club
            $club = Club::firstOrCreate(
                ['nom' => $data['club']['nom']],
                array_merge($data['club'], ['id_admin' => $admin->id, 'photo' => null])
            );

            // Créer les terrains
            foreach ($data['terrains'] as $terrainData) {
                Terrain::firstOrCreate(
                    ['nom' => $terrainData['nom'], 'id_club' => $club->id],
                    array_merge($terrainData, ['id_club' => $club->id, 'description' => 'Terrain de qualité professionnelle.', 'photo' => null])
                );
            }
        }
        $this->command->info('✅ 3 clubs avec terrains créés');

        // ── 4. Réservations de test ────────────────────────────────────────────
        $terrains = Terrain::all();
        $clientUsers = User::where('role', 'client')->get();

        if ($terrains->count() > 0 && $clientUsers->count() > 0) {
            $reservationsData = [
                ['statut_reservation' => 'terminée',   'statut_paiements' => 'paye',       'date' => '-10 days'],
                ['statut_reservation' => 'terminée',   'statut_paiements' => 'paye',       'date' => '-5 days'],
                ['statut_reservation' => 'en_attente', 'statut_paiements' => 'en_attente', 'date' => '+2 days'],
                ['statut_reservation' => 'en_attente', 'statut_paiements' => 'en_attente', 'date' => '+3 days'],
                ['statut_reservation' => 'annulée',    'statut_paiements' => 'en_attente', 'date' => '-2 days'],
                ['statut_reservation' => 'terminée',   'statut_paiements' => 'paye',       'date' => '-15 days'],
                ['statut_reservation' => 'en_attente', 'statut_paiements' => 'en_attente', 'date' => '+5 days'],
                ['statut_reservation' => 'non_venue',  'statut_paiements' => 'en_attente', 'date' => '-1 days'],
            ];

            foreach ($reservationsData as $i => $resData) {
                $terrain = $terrains->get($i % $terrains->count());
                $client  = $clientUsers->get($i % $clientUsers->count());
                $heure   = 8 + ($i * 2);

                Reservation::create([
                    'date_reservation'  => now()->modify($resData['date'])->format('Y-m-d'),
                    'heure_debut'       => sprintf('%02d:00:00', $heure),
                    'heure_fin'         => sprintf('%02d:00:00', $heure + 2),
                    'montant'           => $terrain->prix_heure * 2,
                    'statut_reservation'=> $resData['statut_reservation'],
                    'methode_paiement'  => $i % 2 === 0 ? 'sur_place' : 'en_ligne',
                    'statut_paiements'  => $resData['statut_paiements'],
                    'id_utilisateur'    => $client->id,
                    'id_terrain'        => $terrain->id,
                ]);
            }
            $this->command->info('✅ 8 réservations de test créées');
        }

        // ── 5. Demandes en attente ─────────────────────────────────────────────
        Demande::factory()->count(3)->create();
        Demande::factory()->approuvee()->count(2)->create();
        Demande::factory()->rejetee()->count(1)->create();
        $this->command->info('✅ 6 demandes de test créées');

        $this->command->newLine();
        $this->command->info('🎉 Données de test créées avec succès !');
        $this->command->newLine();
        $this->command->table(
            ['Rôle', 'Email', 'Mot de passe'],
            [
                ['Super Admin', 'admin@sportsfield.ma',    'password123'],
                ['Admin Club 1','khalid.admin@test.ma',    'password123'],
                ['Admin Club 2','nadia.admin@test.ma',     'password123'],
                ['Admin Club 3','rachid.admin@test.ma',    'password123'],
                ['Client',      'ahmed@test.ma',           'password123'],
                ['Client',      'fatima@test.ma',          'password123'],
            ]
        );
    }
}
