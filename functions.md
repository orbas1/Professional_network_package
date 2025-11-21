# Functions Overview

## Laravel Views

| View Name | Path | Used By | Description |
| --- | --- | --- | --- |
| pro_network::my_network.index | resources/views/my_network/index.blade.php | ConnectionsController@index | LinkedIn-style “My Network” summary with degree counts and suggested actions. |
| pro_network::my_network.connections | resources/views/my_network/connections.blade.php | ConnectionsController@list | Paginated connections list with filters. |
| pro_network::my_network.mutual | resources/views/my_network/mutual.blade.php | ConnectionsController@mutual | Mutual connections between the viewer and a target user. |
| pro_network::profile.show | resources/views/profile/show.blade.php | ProfessionalProfileController@show | Professional profile overview with skills, history, and interests. |
| pro_network::profile.edit | resources/views/profile/edit.blade.php | ProfessionalProfileController@edit | Profile editing form for enhanced professional fields. |
| pro_network::company.show | resources/views/company/show.blade.php | CompanyProfileController@show, CompanyProfileController@update | Upgraded company/agency profile with jobs, gigs, and employee counts. |
| pro_network::escrow.show | resources/views/escrow/show.blade.php | MarketplaceEscrowController@showByOrder, @open, @release, @refund | Escrow lifecycle UI for marketplace orders and milestones. |
| pro_network::disputes.create | resources/views/disputes/create.blade.php | MarketplaceDisputeController@create | Start a dispute against an order. |
| pro_network::disputes.show | resources/views/disputes/show.blade.php | MarketplaceDisputeController@show, @store, @reply, @resolve | Dispute timeline, replies, and resolution actions. |
| pro_network::stories.viewer | resources/views/stories/viewer.blade.php | StoryEnhancementController@viewer | Enhanced story viewer shell with progress and navigation. |
| pro_network::stories.creator | resources/views/stories/creator.blade.php | StoryEnhancementController@creator | Enhanced story creation experience with overlays and music. |
| pro_network::posts.polls.create | resources/views/posts/polls/create.blade.php | PostEnhancementController@createPoll | Poll composer page. |
| pro_network::posts.threads.create | resources/views/posts/threads/create.blade.php | PostEnhancementController@createThread | Threaded post composer. |
| pro_network::posts.celebrate.create | resources/views/posts/celebrate/create.blade.php | PostEnhancementController@createCelebrate | “Celebrate an occasion” composer. |
| pro_network::hashtags.show | resources/views/hashtags/show.blade.php | HashtagController@show | Hashtag listing page. |
| pro_network::analytics.overview | resources/views/analytics/overview.blade.php | AnalyticsController@overview | Analytics dashboard shell for cards and charts. |
| pro_network::security.log | resources/views/security/log.blade.php | SecurityModerationController@securityLog | Security event log. |
| pro_network::moderation.queue | resources/views/moderation/queue.blade.php | SecurityModerationController@moderationQueue | Moderation queue listing flagged items. |
| pro_network::newsletters.manage | resources/views/newsletters/manage.blade.php | NewsletterController@manage | User-facing newsletter subscription management. |
| pro_network::newsletters.admin.index | resources/views/newsletters/admin/index.blade.php | NewsletterController@adminIndex | Admin view for newsletters and subscribers. |

## Flutter Screens & Widgets

| Screen | Purpose & Key UI Elements | State/Services | Key Endpoints |
| --- | --- | --- | --- |
| MyNetworkScreen / ConnectionsListScreen / MutualConnectionsScreen | Degree cards, filter chips, pull-to-refresh, recommendation accept/dismiss buttons, and mutuals. | MyNetworkState, RecommendationsState, AnalyticsClient | `/api/pro-network/connections`, `/api/pro-network/connections/mutual/{user}`, `/api/pro-network/recommendations/*` |
| ProfessionalProfileScreen / EditProfessionalProfileScreen | Profile header/tagline, location, top skills as chips, experience/education/certifications/references, DBS/availability toggles, edit form with validation. | ProfessionalProfileState, AnalyticsClient | `/api/pro-network/profile/professional` (GET/POST) |
| CompanyProfileScreen | Company overview, logo placeholder, employee counts, sample employees, gigs/jobs/projects sections with refresh. | CompanyProfileState, AnalyticsClient | `/api/pro-network/company/{company}` |
| OrderEscrowScreen | Escrow status card, milestones list, release/refund CTAs with analytics hooks. | EscrowState, AnalyticsClient | `/api/pro-network/marketplace/orders/{order}/escrow`, `/api/pro-network/marketplace/escrow/{escrow}/release`, `/api/pro-network/marketplace/escrow/{escrow}/refund` |
| DisputeDetailScreen | Dispute header, chronological message list, composer for replies, resolution indicators. | DisputesState, AnalyticsClient | `/api/pro-network/marketplace/disputes/{dispute}`, `/api/pro-network/marketplace/disputes/{dispute}/reply` |
| StoriesViewerScreen / StoryCreatorScreen | Full-screen story player with progress bars, tap navigation, viewer sheet, music chip; creator includes duration slider, stickers/replies toggles, music picker. | StoriesState, StoryCreationState, MusicLibraryApi (optional), AnalyticsClient | `/api/pro-network/stories`, `/api/pro-network/stories/{story}/viewers`, `/api/pro-network/music-library` |
| CreatePollScreen / ThreadedPostScreen / ReshareSheet / CelebrateOccasionComposer | Poll creation, threaded composer, reshare bottom sheet, and celebration composer with analytics events. | PostsEnhancementState, AnalyticsClient | `/api/pro-network/posts/polls`, `/api/pro-network/posts/threads`, `/api/pro-network/posts/reshare`, `/api/pro-network/posts/celebrate` |
| ChatListScreen / ChatDetailScreen / MessageRequestsScreen | Conversation list with call buttons, detailed thread with emoji/GIF/voice/attachment triggers, request inbox with accept/decline actions. | ChatState, AnalyticsClient | `/api/pro-network/chat/conversations`, `/api/pro-network/chat/conversations/{conversation}`, `/api/pro-network/chat/requests`, `/api/pro-network/chat/settings` |
| AnalyticsOverviewScreen / EntityAnalyticsScreen | Summary metric cards, line chart for trends, filterable entity metrics. | AnalyticsState, AnalyticsClient | `/api/pro-network/analytics/metrics`, `/api/pro-network/analytics/series` |
| ModerationQueueScreen / ModerationDetailScreen | Flagged content list with filters and per-item approve/hide/block actions. | ModerationState, AnalyticsClient | `/api/pro-network/moderation/queue`, `/api/pro-network/moderation/action` |
| NewsletterSettingsScreen | Newsletter list with toggles for subscribe/unsubscribe, feedback messages. | NewsletterState, AnalyticsClient | `/api/pro-network/newsletters/subscribe`, `/api/pro-network/newsletters/unsubscribe` |
| AccountSecurityScreen | Professional/Creator toggle, security event summary, age verification status and start action, reaction score chip. | SecurityAndVerificationState, ProfessionalProfileState, AnalyticsClient | `/api/pro-network/security/events`, `/api/pro-network/age-verification/status`, `/api/pro-network/age-verification/start` |

## Integration Guide

### Laravel package
1. Install and publish assets: `php artisan vendor:publish --provider="ProNetwork\\ProNetworkUtilitiesSecurityAnalyticsServiceProvider"`.
2. Run migrations: `php artisan migrate` and seed defaults if provided.
3. Protect routes with `auth`; add `can:*` middleware for moderation/security/analytics dashboards as appropriate.
4. Configure feature flags and storage in `config/pro_network_utilities_security_analytics.php` (Cloudflare R2/Wasabi/local), and select your analytics driver and security settings (rate limiting, GDPR logging, malware scanning hooks).
5. Blade views live under `pro_network::`; publish or override them in your host app as needed.

### Flutter addon
1. Add the package (path or git) to `pubspec.yaml`, then `flutter pub get`.
2. Provide API clients with base URL + auth token provider; wrap screens with `ChangeNotifierProvider` instances for each state (e.g., `MyNetworkState`, `ProfessionalProfileState`, `ChatState`).
3. Import `proNetworkMenuItems` and merge into your drawer/tab model; register `ProNetworkRoutes.builders(analyticsClient)` on your router so route names map to widgets.
4. Share a single `AnalyticsClient` to log screen/action events; optionally attach device/app metadata via the API client for security endpoints.
5. Wire chat, live, and stories to your WebSocket/RTC layer if present; the addon is transport-agnostic and expects the host to provide media pickers.

### Feature toggles and configuration
- Enable or disable sections via Laravel config flags (network, marketplace, analytics, moderation, newsletters, age verification, chat extras, stories/music).
- Storage backends: Cloudflare R2, Wasabi, or local disks with presigned URLs; align TTL with mobile uploads.
- Security: brute-force protection, GDPR-compliant logging, moderation permissions, malware scanning; ensure auth middleware wraps all routes.
- Analytics driver: built-in tables or forwarders to your central data stack; AnalyticsClient sends lightweight events from Flutter.

## Security & Performance Notes
- Security: authentication for all routes; `can:moderate` and `can:viewSecurity` protect sensitive endpoints. Flutter surfaces security events, age verification, and account-type toggles without exposing secrets.
- Performance: index connections/reactions/analytics tables, cache network summaries and recommendations, and paginate lists; Flutter states expose paging filters and pull-to-refresh to avoid heavy payloads.
- Observability: analytics events appear in `pro_network::analytics.overview`; security logs in `pro_network::security.log`; moderation queues in `pro_network::moderation.queue`. Mobile analytics uses `AnalyticsClient.trackScreen/trackAction` on every major screen and action.
