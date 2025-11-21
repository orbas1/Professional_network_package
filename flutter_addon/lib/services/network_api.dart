import '../models/models.dart';
import 'api_client.dart';

class NetworkApi extends BaseApiService {
  NetworkApi({required super.baseUrl, super.tokenProvider, super.client});

  Future<NetworkSummary> fetchSummary() async {
    final data = await get('/api/pro-network/connections/summary');
    return NetworkSummary.fromJson(data as Map<String, dynamic>);
  }

  Future<List<NetworkConnection>> listConnections({int page = 1, Map<String, dynamic>? filters}) async {
    final query = <String, dynamic>{'page': page.toString(), ...?filters};
    final queryString = Uri(queryParameters: query).query;
    final data = await get('/api/pro-network/connections${queryString.isNotEmpty ? '?$queryString' : ''}');
    return (data as List)
        .map((e) => NetworkConnection.fromJson(e as Map<String, dynamic>))
        .toList();
  }

  Future<List<NetworkConnection>> mutualConnections(int userId) async {
    final data = await get('/api/pro-network/connections/mutual/$userId');
    return (data as List)
        .map((e) => NetworkConnection.fromJson(e as Map<String, dynamic>))
        .toList();
  }
}

class RecommendationsApi extends BaseApiService {
  RecommendationsApi({required super.baseUrl, super.tokenProvider, super.client});

  Future<List<RecommendationItem>> _fetchList(String path) async {
    final data = await get(path);
    return (data as List)
        .map((e) => RecommendationItem.fromJson(e as Map<String, dynamic>))
        .toList();
  }

  Future<List<RecommendationItem>> recommendedPeople() =>
      _fetchList('/api/pro-network/recommendations/people');

  Future<List<RecommendationItem>> recommendedCompanies() =>
      _fetchList('/api/pro-network/recommendations/companies');

  Future<List<RecommendationItem>> recommendedGroups() =>
      _fetchList('/api/pro-network/recommendations/groups');

  Future<List<RecommendationItem>> recommendedContent() =>
      _fetchList('/api/pro-network/recommendations/content');
}

class ProfileApi extends BaseApiService {
  ProfileApi({required super.baseUrl, super.tokenProvider, super.client});

  Future<ProfessionalProfile> fetchProfile({int? userId}) async {
    final path = userId == null
        ? '/api/pro-network/profile/professional'
        : '/api/pro-network/profile/professional?user=$userId';
    final data = await get(path);
    return ProfessionalProfile.fromJson(data as Map<String, dynamic>);
  }

  Future<ProfessionalProfile> updateProfile(Map<String, dynamic> payload) async {
    final data = await post('/api/pro-network/profile/professional', data: payload);
    return ProfessionalProfile.fromJson(data as Map<String, dynamic>);
  }
}

class CompanyApi extends BaseApiService {
  CompanyApi({required super.baseUrl, super.tokenProvider, super.client});

  Future<CompanyProfile> fetchCompany(int companyId) async {
    final data = await get('/api/pro-network/company/$companyId');
    return CompanyProfile.fromJson(data as Map<String, dynamic>);
  }

  Future<CompanyProfile> updateCompany(int companyId, Map<String, dynamic> payload) async {
    final data = await post('/api/pro-network/company/$companyId', data: payload);
    return CompanyProfile.fromJson(data as Map<String, dynamic>);
  }
}
