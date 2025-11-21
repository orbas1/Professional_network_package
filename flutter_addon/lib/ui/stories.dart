import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

import '../analytics/analytics_client.dart';
import '../models/models.dart';
import '../services/music_library_api.dart';
import '../state/state.dart';
import 'common.dart';

class StoriesViewerScreen extends StatefulWidget {
  final StoriesState? state;
  final AnalyticsClient analytics;
  final int storyId;

  const StoriesViewerScreen({
    super.key,
    required this.analytics,
    required this.storyId,
    this.state,
  });

  @override
  State<StoriesViewerScreen> createState() => _StoriesViewerScreenState();
}

class _StoriesViewerScreenState extends State<StoriesViewerScreen> {
  StoriesState get state => widget.state ?? context.read<StoriesState>();

  @override
  void initState() {
    super.initState();
    widget.analytics.trackScreen('StoriesViewer', {'storyId': widget.storyId});
    state.loadViewers(widget.storyId);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Story Viewers')),
      body: Consumer<StoriesState>(
        builder: (context, s, _) {
          if (s.loading && s.currentViewers.isEmpty) {
            return const LoadingView();
          }
          if (s.error != null) {
            return ErrorView(message: s.error!, onRetry: () => state.loadViewers(widget.storyId));
          }
          if (s.currentViewers.isEmpty) {
            return const EmptyView(message: 'No viewers yet');
          }
          return ListView(
            children: s.currentViewers
                .map(
                  (v) => ListTile(
                    leading: const CircleAvatar(child: Icon(Icons.person_outline)),
                    title: Text(v.name),
                    subtitle: Text(v.viewedAt?.toLocal().toString() ?? ''),
                  ),
                )
                .toList(),
          );
        },
      ),
    );
  }
}

class StoryCreatorScreen extends StatefulWidget {
  final StoryCreationState? state;
  final StoriesState? viewerState;
  final AnalyticsClient analytics;
  final MusicLibraryApi? musicApi;

  const StoryCreatorScreen({
    super.key,
    required this.analytics,
    this.state,
    this.viewerState,
    this.musicApi,
  });

  @override
  State<StoryCreatorScreen> createState() => _StoryCreatorScreenState();
}

class _StoryCreatorScreenState extends State<StoryCreatorScreen> {
  final _caption = TextEditingController();
  MusicTrack? _selectedTrack;
  StoryCreationState get state => widget.state ?? context.read<StoryCreationState>();
  MusicLibraryApi? get musicApi => widget.musicApi;
  bool _loadingTracks = false;
  List<MusicTrack> _tracks = [];

  @override
  void initState() {
    super.initState();
    widget.analytics.trackScreen('StoryCreator', {});
    _loadTracks();
  }

  @override
  void dispose() {
    _caption.dispose();
    super.dispose();
  }

  Future<void> _loadTracks() async {
    if (musicApi == null) return;
    setState(() => _loadingTracks = true);
    try {
      _tracks = await musicApi!.index();
    } catch (e) {
      _tracks = [];
    } finally {
      setState(() => _loadingTracks = false);
    }
  }

  Future<void> _save() async {
    final payload = {
      'caption': _caption.text.trim(),
      if (_selectedTrack != null) 'music_track_id': _selectedTrack!.id,
    };
    await state.createOrUpdate(payload);
    widget.analytics.trackAction('story_created', payload);
    if (mounted) Navigator.of(context).pop();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Create Story')),
      body: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          children: [
            TextField(
              controller: _caption,
              maxLines: 3,
              decoration: const InputDecoration(labelText: 'Caption & overlays'),
            ),
            const SizedBox(height: 12),
            if (_loadingTracks)
              const LinearProgressIndicator()
            else if (_tracks.isNotEmpty)
              DropdownButtonFormField<MusicTrack>(
                value: _selectedTrack,
                items: _tracks
                    .map((t) => DropdownMenuItem(value: t, child: Text('${t.title} – ${t.artist}')))
                    .toList(),
                onChanged: (val) => setState(() => _selectedTrack = val),
                decoration: const InputDecoration(labelText: 'Music'),
              ),
            const SizedBox(height: 16),
            Consumer<StoryCreationState>(
              builder: (context, s, _) {
                if (s.loading) return const LoadingView(message: 'Publishing story...');
                if (s.error != null) {
                  return ErrorView(message: s.error!, onRetry: _save);
                }
                return ElevatedButton.icon(
                  onPressed: _save,
                  icon: const Icon(Icons.cloud_upload),
                  label: const Text('Publish Story'),
                );
              },
            ),
          ],
        ),
      ),
    );
  }
}
