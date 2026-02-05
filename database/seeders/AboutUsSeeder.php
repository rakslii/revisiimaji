<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AboutUsSection;
use App\Models\TeamMember;
use App\Models\Achievement;
use App\Models\CoreValue;

class AboutUsSeeder extends Seeder
{
    public function run()
    {
        // Clear existing data
        AboutUsSection::truncate();
        TeamMember::truncate();
        Achievement::truncate();
        CoreValue::truncate();

        // ==================== ABOUT US SECTIONS ====================
        $sections = [
            [
                'title' => 'Mewujudkan Imajinasi Menjadi Realitas',
                'subtitle' => 'Lebih dari sekadar digital printing, kami adalah partner kreatif Anda dalam menciptakan karya visual yang memukau dan bermakna.',
                'content' => '<p>Berawal dari sebuah mimpi sederhana di tahun <strong>2018</strong>, Cipta Imaji didirikan oleh sekelompok profesional muda yang memiliki passion mendalam di bidang desain grafis dan teknologi printing. Kami percaya bahwa setiap brand, bisnis, dan individu memiliki cerita unik yang layak untuk diceritakan dengan cara yang menarik.</p>
                            <p>Dari ruang kecil dengan satu mesin printer, kini kami telah berkembang menjadi salah satu penyedia layanan digital printing terpercaya di Jakarta. Dengan lebih dari <strong>5.000+ produk terjual</strong> dan <strong>1.000+ klien puas</strong>, kami terus berinovasi untuk memberikan hasil terbaik.</p>
                            <p>Nama <strong>"Cipta Imaji"</strong> sendiri merepresentasikan filosofi kami - menciptakan (cipta) hasil nyata dari imajinasi yang tak terbatas. Setiap proyek adalah kanvas baru, setiap klien adalah partner kolaboratif dalam proses kreatif.</p>',
                'section_type' => 'hero',
                'position' => 'main',
                'order' => 1,
                'is_active' => true,
                'background_color' => '#193497',
                'text_color' => '#ffffff',
                'icon' => 'fas fa-rocket',
                'data' => json_encode(['badge' => '✨ Sejak 2018'])
            ],
            [
                'title' => 'Perjalanan Cipta Imaji',
                'subtitle' => 'Dari mimpi kecil menjadi partner kreatif terpercaya',
                'content' => '<p>Berawal dari sebuah mimpi sederhana di tahun <strong>2018</strong>, Cipta Imaji didirikan oleh sekelompok profesional muda yang memiliki passion mendalam di bidang desain grafis dan teknologi printing.</p>
                            <p>Dari ruang kecil dengan satu mesin printer, kini kami telah berkembang menjadi salah satu penyedia layanan digital printing terpercaya di Jakarta.</p>',
                'section_type' => 'story',
                'position' => 'main',
                'order' => 2,
                'is_active' => true,
                'background_color' => '#ffffff',
                'text_color' => '#000000',
                'icon' => 'fas fa-history',
                'data' => json_encode([
                    'badge' => '📖 Cerita Kami',
                    'achievements' => [
                        ['icon' => 'fas fa-trophy', 'title' => 'ISO Certified', 'description' => 'Quality Assured'],
                        ['icon' => 'fas fa-award', 'title' => 'Best Service', 'description' => 'Award 2023']
                    ],
                    'stats' => [
                        ['value' => '2018', 'label' => 'Tahun Berdiri'],
                        ['value' => '5000+', 'label' => 'Produk Terjual']
                    ]
                ])
            ],
            [
                'title' => 'Visi & Misi',
                'subtitle' => 'Arah dan tujuan kami dalam melayani kebutuhan printing Anda',
                'content' => null,
                'section_type' => 'mission',
                'position' => 'main',
                'order' => 3,
                'is_active' => true,
                'background_color' => '#f8fafc',
                'text_color' => '#000000',
                'icon' => 'fas fa-bullseye',
                'data' => json_encode([
                    'vision' => [
                        'title' => 'Visi Kami',
                        'description' => 'Menjadi perusahaan digital printing terdepan di Indonesia yang dikenal karena kualitas premium, inovasi berkelanjutan, dan kepuasan pelanggan yang konsisten. Kami berkomitmen untuk terus berkembang bersama teknologi dan kebutuhan pasar.'
                    ],
                    'mission' => [
                        'Memberikan produk berkualitas tinggi dengan harga kompetitif',
                        'Menggunakan teknologi printing terkini dan ramah lingkungan',
                        'Memberikan pelayanan cepat, responsif, dan profesional',
                        'Membangun hubungan jangka panjang dengan setiap klien'
                    ]
                ])
            ],
            [
                'title' => 'Nilai-Nilai Kami',
                'subtitle' => 'Prinsip yang menjadi fondasi dalam setiap pekerjaan kami',
                'content' => null,
                'section_type' => 'values',
                'position' => 'main',
                'order' => 4,
                'is_active' => true,
                'background_color' => '#ffffff',
                'text_color' => '#000000',
                'icon' => 'fas fa-star',
                'data' => null
            ],
            [
                'title' => 'Tim Profesional',
                'subtitle' => 'Orang-orang berbakat di balik setiap karya Cipta Imaji',
                'content' => null,
                'section_type' => 'team',
                'position' => 'main',
                'order' => 5,
                'is_active' => true,
                'background_color' => '#f8fafc',
                'text_color' => '#000000',
                'icon' => 'fas fa-users',
                'data' => null
            ],
            [
                'title' => 'Pencapaian Kami',
                'subtitle' => 'Angka-angka yang berbicara tentang dedikasi dan kualitas kami',
                'content' => null,
                'section_type' => 'stats',
                'position' => 'main',
                'order' => 6,
                'is_active' => true,
                'background_color' => '#193497',
                'text_color' => '#ffffff',
                'icon' => 'fas fa-trophy',
                'data' => null
            ],
            [
                'title' => 'Teknologi & Peralatan',
                'subtitle' => 'Kami menggunakan mesin dan teknologi terkini untuk hasil maksimal',
                'content' => null,
                'section_type' => 'technology',
                'position' => 'main',
                'order' => 7,
                'is_active' => true,
                'background_color' => '#ffffff',
                'text_color' => '#000000',
                'icon' => 'fas fa-cogs',
                'data' => json_encode([
                    'technologies' => [
                        [
                            'title' => 'Digital Printing HD',
                            'description' => 'Mesin printing resolusi tinggi untuk hasil detail dan warna akurat',
                            'icon' => 'fas fa-print',
                            'gradient_from' => '#193497',
                            'gradient_to' => '#1e40af'
                        ],
                        [
                            'title' => 'Precision Cutting',
                            'description' => 'Mesin cutting otomatis dengan presisi tinggi untuk finishing sempurna',
                            'icon' => 'fas fa-cut',
                            'gradient_from' => '#720e87',
                            'gradient_to' => '#9333ea'
                        ],
                        [
                            'title' => 'Color Management',
                            'description' => 'Sistem kalibrasi warna profesional untuk konsistensi hasil',
                            'icon' => 'fas fa-palette',
                            'gradient_from' => '#f72585',
                            'gradient_to' => '#ec4899'
                        ]
                    ]
                ])
            ],
            [
                'title' => 'Siap Bekerja Sama?',
                'subtitle' => 'Mari wujudkan proyek impian Anda bersama tim profesional Cipta Imaji. Konsultasi gratis untuk Anda!',
                'content' => '<p>Kami siap membantu Anda mewujudkan ide-ide kreatif menjadi produk nyata yang berkualitas.</p>',
                'section_type' => 'cta',
                'position' => 'main',
                'order' => 8,
                'is_active' => true,
                'background_color' => '#193497',
                'text_color' => '#ffffff',
                'icon' => 'fas fa-handshake',
                'data' => json_encode([
                    'buttons' => [
                        [
                            'text' => 'Hubungi Kami',
                            'url' => 'https://wa.me/6281234567890',
                            'target' => '_blank',
                            'icon' => 'fab fa-whatsapp',
                            'bg_color' => '#25D366',
                            'hover_color' => '#128C7E'
                        ],
                        [
                            'text' => 'Lihat Produk',
                            'url' => '/products',
                            'target' => '_self',
                            'icon' => 'fas fa-shopping-bag',
                            'bg_color' => '#ffffff',
                            'hover_color' => '#c0f820'
                        ]
                    ]
                ])
            ],
        ];

        foreach ($sections as $section) {
            AboutUsSection::create($section);
        }

        // ==================== TEAM MEMBERS ====================
        $teamMembers = [
            [
                'name' => 'Budi Santoso',
                'position' => 'Founder & CEO',
                'bio' => 'Visioner dengan 10+ tahun pengalaman di industri printing',
                'image' => null,
                'initial' => 'BS',
                'color_scheme' => '#193497,#1e40af',
                'social_links' => json_encode([
                    'linkedin' => 'https://linkedin.com/in/budisantoso',
                    'instagram' => 'https://instagram.com/budiciptaimaji'
                ]),
                'order' => 1,
                'is_active' => true
            ],
            [
                'name' => 'Siti Nurhaliza',
                'position' => 'Creative Director',
                'bio' => 'Expert desainer grafis dengan portfolio internasional',
                'image' => null,
                'initial' => 'SN',
                'color_scheme' => '#720e87,#9333ea',
                'social_links' => json_encode([
                    'linkedin' => 'https://linkedin.com/in/sitinurhaliza',
                    'instagram' => 'https://instagram.com/siticreative'
                ]),
                'order' => 2,
                'is_active' => true
            ],
            [
                'name' => 'Andi Wijaya',
                'position' => 'Production Manager',
                'bio' => 'Spesialis quality control dan optimasi proses produksi',
                'image' => null,
                'initial' => 'AW',
                'color_scheme' => '#f72585,#ec4899',
                'social_links' => json_encode([
                    'linkedin' => 'https://linkedin.com/in/andiwijaya'
                ]),
                'order' => 3,
                'is_active' => true
            ],
            [
                'name' => 'Rina Kusuma',
                'position' => 'Customer Relations',
                'bio' => 'Memastikan setiap klien mendapat layanan terbaik',
                'image' => null,
                'initial' => 'RK',
                'color_scheme' => '#ff0f0f,#f87171',
                'social_links' => json_encode([
                    'linkedin' => 'https://linkedin.com/in/rinakusuma',
                    'instagram' => 'https://instagram.com/rina_customer'
                ]),
                'order' => 4,
                'is_active' => true
            ],
        ];

        foreach ($teamMembers as $member) {
            TeamMember::create($member);
        }

        // ==================== ACHIEVEMENTS ====================
        $achievements = [
            [
                'title' => 'Produk Terjual',
                'icon' => 'fas fa-box',
                'value' => '5000',
                'suffix' => '+',
                'description' => 'Total produk yang telah berhasil diproduksi dan dikirim',
                'order' => 1,
                'is_active' => true
            ],
            [
                'title' => 'Klien Puas',
                'icon' => 'fas fa-users',
                'value' => '1000',
                'suffix' => '+',
                'description' => 'Klien yang puas dengan layanan kami',
                'order' => 2,
                'is_active' => true
            ],
            [
                'title' => 'Kepuasan',
                'icon' => 'fas fa-smile',
                'value' => '98',
                'suffix' => '%',
                'description' => 'Tingkat kepuasan pelanggan',
                'order' => 3,
                'is_active' => true
            ],
            [
                'title' => 'Fast Production',
                'icon' => 'fas fa-clock',
                'value' => '24',
                'suffix' => 'h',
                'description' => 'Waktu produksi standar',
                'order' => 4,
                'is_active' => true
            ],
        ];

        foreach ($achievements as $achievement) {
            Achievement::create($achievement);
        }

        // ==================== CORE VALUES ====================
        $coreValues = [
            [
                'title' => 'Kualitas',
                'description' => 'Kami tidak pernah berkompromi dengan kualitas. Setiap produk melewati quality control ketat.',
                'icon' => 'fas fa-star',
                'color_scheme' => '#193497,#1e40af',
                'order' => 1,
                'is_active' => true
            ],
            [
                'title' => 'Inovasi',
                'description' => 'Terus belajar dan mengadopsi teknologi terbaru untuk hasil yang lebih baik.',
                'icon' => 'fas fa-rocket',
                'color_scheme' => '#720e87,#9333ea',
                'order' => 2,
                'is_active' => true
            ],
            [
                'title' => 'Integritas',
                'description' => 'Transparansi dan kejujuran dalam setiap transaksi dan komunikasi dengan klien.',
                'icon' => 'fas fa-heart',
                'color_scheme' => '#f72585,#ec4899',
                'order' => 3,
                'is_active' => true
            ],
            [
                'title' => 'Kolaborasi',
                'description' => 'Mendengarkan kebutuhan klien dan bekerja sama untuk hasil terbaik.',
                'icon' => 'fas fa-users',
                'color_scheme' => '#ff0f0f,#f87171',
                'order' => 4,
                'is_active' => true
            ],
        ];

        foreach ($coreValues as $value) {
            CoreValue::create($value);
        }

        $this->command->info('About Us data seeded successfully!');
        $this->command->info('Sections: ' . count($sections));
        $this->command->info('Team Members: ' . count($teamMembers));
        $this->command->info('Achievements: ' . count($achievements));
        $this->command->info('Core Values: ' . count($coreValues));
    }
}