# Functions Overview

## Laravel Package
- Configurable feature toggles via `config/pro_network_utilities_security_analytics.php`.
- Database migrations adding professional profile, connections, company pages, escrow, moderation, analytics, and newsletter tables.
- Eloquent models under `ProNetwork\Models` for all new tables.
- Services for analytics tracking, security logging, moderation, storage, age verification, newsletters, connections, recommendations, escrow, hashtags, reactions, profiles, and stories.
- HTTP controllers exposing REST endpoints under `/pro-network` and `/api/pro-network` for network management, recommendations, profile updates, escrow, analytics, reactions, newsletters, and age verification.
- Blade views (`resources/views`) for network and professional profile screens.
- Language strings in `resources/lang/*/pro_network_utilities_security_analytics.php`.
- Service provider `ProNetworkUtilitiesSecurityAnalyticsServiceProvider` registers routes, migrations, views, translations, and bindings.

### Integration Guide
1. Publish assets: `php artisan vendor:publish --provider="ProNetwork\\ProNetworkUtilitiesSecurityAnalyticsServiceProvider"`.
2. Run migrations: `php artisan migrate`.
3. Enable desired features in `config/pro_network_utilities_security_analytics.php`.
4. Use controllers/routes under `/pro-network` and `/api/pro-network` with auth middleware.

## Flutter Addon
- Located in `flutter_addon` with `pubspec.yaml`.
- Models mirror Laravel responses (`ConnectionModel`, `ProfessionalProfileModel`, `EscrowModel`, `NewsletterModel`, `AnalyticsEventModel`).
- `ApiService` handles authenticated HTTP calls to Laravel endpoints.
- `NetworkState` provides provider-compatible state management.
- UI screen `NetworkScreen` lists network connections with loading/error states.
- `menu.dart` exports `menuItems` for host navigation.

### Flutter Integration
1. Add the addon as a dependency or path package.
2. Provide `ApiService` with base URL and token provider; wrap `NetworkState` in a `ChangeNotifierProvider`.
3. Register menu items from `menu.dart` into the host navigation.
