<?php

return [
    'features' => [
        'connections_graph' => false,
        'recommendations' => false,
        'live_streaming_enhanced' => false,
        'notifications_wrapper' => false,
        'marketplace_escrow' => false,
        'profile_professional_upgrades' => false,
        'reactions_dislikes_scores' => false,
        'stories_wrapper' => false,
        'post_enhancements' => false,
        'hashtags' => false,
        'music_library' => false,
        'bad_word_checker' => false,
        'moderation_tools' => false,
        'file_scan' => false,
        'db_encryption' => false,
        'storage_backends' => false,
        'account_types' => false,
        'search_upgrade' => false,
        'chat_enhancements' => false,
        'analytics_hub' => false,
        'security_hardening' => false,
        'age_verification' => false,
        'newsletters' => false,
        'invite_contributors' => false,
        'multi_language_wrapper' => false,
    ],
    'analytics' => [
        'driver' => env('PRO_NETWORK_ANALYTICS_DRIVER', 'log'),
        'forward' => env('PRO_NETWORK_ANALYTICS_FORWARD', false),
    ],
    'storage' => [
        'default_disk' => env('PRO_NETWORK_STORAGE_DISK', 'local'),
        'r2_disk' => env('PRO_NETWORK_R2_DISK', 'r2'),
        'wasabi_disk' => env('PRO_NETWORK_WASABI_DISK', 'wasabi'),
        'signed_url_ttl' => env('PRO_NETWORK_SIGNED_TTL', 300),
    ],
    'virus_scanner' => [
        'endpoint' => env('PRO_NETWORK_VIRUS_SCAN_ENDPOINT'),
        'token' => env('PRO_NETWORK_VIRUS_SCAN_TOKEN'),
        'timeout' => env('PRO_NETWORK_VIRUS_SCAN_TIMEOUT', 5),
    ],
    'age_verification' => [
        'provider' => env('PRO_NETWORK_AGE_PROVIDER', 'placeholder'),
        'callback_url' => env('PRO_NETWORK_AGE_CALLBACK'),
        'required_for' => [
            'live_streaming' => true,
            'marketplace_payouts' => true,
        ],
    ],
    'security' => [
        'brute_force' => [
            'max_attempts' => env('PRO_NETWORK_BRUTE_FORCE_MAX', 5),
            'decay_minutes' => env('PRO_NETWORK_BRUTE_FORCE_DECAY', 15),
        ],
        'ip_ban_minutes' => env('PRO_NETWORK_IP_BAN_MINUTES', 60),
        'rate_limits' => [
            'api' => '60,1',
            'sensitive' => '10,1',
        ],
        'gdpr_logging' => env('PRO_NETWORK_GDPR_LOGGING', false),
    ],
    'kyc' => [
        'provider' => env('PRO_NETWORK_KYC_PROVIDER', 'placeholder'),
        'api_key' => env('PRO_NETWORK_KYC_KEY'),
    ],
];
