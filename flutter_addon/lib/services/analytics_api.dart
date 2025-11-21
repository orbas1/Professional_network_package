import '../models/models.dart';
import 'api_client.dart';

class AnalyticsApi extends BaseApiService {
  AnalyticsApi({required super.baseUrl, super.tokenProvider, super.client});

  Future<List<AnalyticsMetric>> metrics(Map<String, dynamic> filters) async {
    final data = await post('/api/pro-network/analytics/metrics', data: filters);
    return (data as List)
        .map((e) => AnalyticsMetric.fromJson(e as Map<String, dynamic>))
        .toList();
  }

  Future<AnalyticsSeries> series(Map<String, dynamic> filters) async {
    final data = await post('/api/pro-network/analytics/series', data: filters);
    return AnalyticsSeries.fromJson(data as Map<String, dynamic>);
  }
}
