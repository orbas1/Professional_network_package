# Functions Overview

## Laravel Views

| View Name | Path | Used By |
| --- | --- | --- |
| pro_network::my_network.index | resources/views/my_network/index.blade.php | ConnectionsController@index |
| pro_network::my_network.connections | resources/views/my_network/connections.blade.php | ConnectionsController@list |
| pro_network::my_network.mutual | resources/views/my_network/mutual.blade.php | ConnectionsController@mutual |
| pro_network::profile.show | resources/views/profile/show.blade.php | ProfessionalProfileController@show |
| pro_network::profile.edit | resources/views/profile/edit.blade.php | ProfessionalProfileController@edit |
| pro_network::company.show | resources/views/company/show.blade.php | CompanyProfileController@show, CompanyProfileController@update |
| pro_network::escrow.show | resources/views/escrow/show.blade.php | MarketplaceEscrowController@showByOrder, @open, @release, @refund |
| pro_network::disputes.create | resources/views/disputes/create.blade.php | MarketplaceDisputeController@create |
| pro_network::disputes.show | resources/views/disputes/show.blade.php | MarketplaceDisputeController@show, @store, @reply, @resolve |
| pro_network::stories.viewer | resources/views/stories/viewer.blade.php | StoryEnhancementController@viewer |
| pro_network::stories.creator | resources/views/stories/creator.blade.php | StoryEnhancementController@creator |
| pro_network::posts.polls.create | resources/views/posts/polls/create.blade.php | PostEnhancementController@createPoll |
| pro_network::posts.threads.create | resources/views/posts/threads/create.blade.php | PostEnhancementController@createThread |
| pro_network::posts.celebrate.create | resources/views/posts/celebrate/create.blade.php | PostEnhancementController@createCelebrate |
| pro_network::hashtags.show | resources/views/hashtags/show.blade.php | HashtagController@show |
| pro_network::analytics.overview | resources/views/analytics/overview.blade.php | AnalyticsController@overview |
| pro_network::security.log | resources/views/security/log.blade.php | SecurityModerationController@securityLog |
| pro_network::moderation.queue | resources/views/moderation/queue.blade.php | SecurityModerationController@moderationQueue |
| pro_network::newsletters.manage | resources/views/newsletters/manage.blade.php | NewsletterController@manage |
| pro_network::newsletters.admin.index | resources/views/newsletters/admin/index.blade.php | NewsletterController@adminIndex |

## Flutter Screens & Widgets

| Screen | Purpose | State/Services | Key Endpoints |
| --- | --- | --- | --- |
| MyNetworkScreen / ConnectionsListScreen / MutualConnectionsScreen | Show network summary, full connections list, and mutuals with pull-to-refresh and recommendations | MyNetworkState, RecommendationsState, AnalyticsClient | `/api/pro-network/connections`, `/api/pro-network/connections/mutual/{user}`, `/api/pro-network/recommendations/*` |
| ProfessionalProfileScreen / EditProfessionalProfileScreen | View and edit professional profile data with skills, history, and availability | ProfessionalProfileState, AnalyticsClient | `/api/pro-network/profile/professional` (GET/POST) |
| CompanyProfileScreen | Display company/agency overview, employees, and opportunities | CompanyProfileState, AnalyticsClient | `/api/pro-network/company/{company}` |
| OrderEscrowScreen | Show escrow amounts and milestones with release/refund controls | EscrowState, AnalyticsClient | `/api/pro-network/marketplace/orders/{order}/escrow`, `/api/pro-network/marketplace/escrow/{escrow}/release`, `/api/pro-network/marketplace/escrow/{escrow}/refund` |
| DisputeDetailScreen | View dispute thread and reply to messages | DisputesState, AnalyticsClient | `/api/pro-network/marketplace/disputes/{dispute}`, `/api/pro-network/marketplace/disputes/{dispute}/reply` |
| StoriesViewerScreen / StoryCreatorScreen | View story viewers and publish enhanced stories with music selection | StoriesState, StoryCreationState, MusicLibraryApi (optional), AnalyticsClient | `/api/pro-network/stories`, `/api/pro-network/stories/{story}/viewers`, `/api/pro-network/music-library` |
| CreatePollScreen / ThreadedPostScreen / ReshareSheet / CelebrateOccasionComposer | Post enhancement flows for polls, threads, reshares, and celebrate posts | PostsEnhancementState, AnalyticsClient | `/api/pro-network/posts/polls`, `/api/pro-network/posts/threads`, `/api/pro-network/posts/reshare`, `/api/pro-network/posts/celebrate` |
| ChatListScreen / ChatDetailScreen / MessageRequestsScreen | Enhanced chat list, conversation detail, requests inbox with emoji/GIF/voice-note triggers and call buttons | ChatState, AnalyticsClient | `/api/pro-network/chat/conversations`, `/api/pro-network/chat/conversations/{conversation}`, `/api/pro-network/chat/requests`, `/api/pro-network/chat/conversations/{conversation}/messages` |
| AnalyticsOverviewScreen / EntityAnalyticsScreen | Metrics summary and charted series with filters | AnalyticsState, AnalyticsClient | `/api/pro-network/analytics/metrics`, `/api/pro-network/analytics/series` |
| ModerationQueueScreen / ModerationDetailScreen | Moderator queue and per-item actions | ModerationState, AnalyticsClient | `/api/pro-network/moderation/queue`, `/api/pro-network/moderation/action` |
| NewsletterSettingsScreen | Subscribe/unsubscribe management | NewsletterState, AnalyticsClient | `/api/pro-network/newsletters/subscribe`, `/api/pro-network/newsletters/unsubscribe` |
| AccountSecurityScreen | Professional/creator toggle, security events, and age verification status/action | SecurityAndVerificationState, ProfessionalProfileState, AnalyticsClient | `/api/pro-network/security/events`, `/api/pro-network/age-verification/status`, `/api/pro-network/age-verification/start` |

## Integration Guide

### Laravel package
1. Install the package and publish assets: `php artisan vendor:publish --provider="ProNetwork\\ProNetworkUtilitiesSecurityAnalyticsServiceProvider"`.
2. Run migrations and seed any defaults: `php artisan migrate`.
3. Protect routes with `auth` middleware; configure permissions for moderation and security logs where needed.
4. Configure feature toggles and storage in `config/pro_network_utilities_security_analytics.php` (Cloudflare R2/Wasabi/local), and set analytics driver plus security settings (rate limits, logging).
5. Blade views are referenced under the `pro_network::` namespace; ensure they are published or customised in your app.

### Flutter addon
1. Add the path or git dependency to `pubspec.yaml` and run `flutter pub get`.
2. Provide API clients with the Sociopro base URL and auth token provider, then wrap screens with `ChangeNotifierProvider` instances for each state class (e.g., `MyNetworkState`, `ProfessionalProfileState`).
3. Import `proNetworkMenuItems` (from `menu/menu.dart`) into your navigation and register `ProNetworkRoutes.builders(analyticsClient)` inside your route map so menu entries resolve to widgets.
4. Share a single `AnalyticsClient` instance to track screen and action events; optionally attach device/security metadata in headers via the API client token provider.
5. Wire chat, stories, and live sockets to your existing WebSocket layer if present; the addon is transport-agnostic.

### Feature toggles and configuration
- Enable or disable sections via Laravel config flags (network, marketplace, analytics, moderation, newsletters, age verification).
- Storage backends can be pointed at Cloudflare R2, Wasabi, or local disks; ensure presigned URL settings match your hosting environment.
- Security settings include brute-force limits, GDPR-compliant logging, and moderation permissions; align with your auth/ACL setup.
- Analytics driver can be set to the built-in service or forwarded to your central data stack.

## Security & Performance Notes
- Security: authentication is required for all routes; moderation and security event endpoints expect role-based `can:*` middleware. The Flutter addon surfaces age verification status, security event history, and encourages creator-mode toggles without exposing secrets.
- Performance: use DB indexes on connection, reactions, and analytics tables; cache network summaries and recommendation payloads; paginate lists in both API and UI (states support page filters).
- Observability: analytics events are viewable via the Laravel analytics dashboard (`pro_network::analytics.overview`), and security logs via `pro_network::security.log`. Moderation queue visibility is provided through `pro_network::moderation.queue`.
