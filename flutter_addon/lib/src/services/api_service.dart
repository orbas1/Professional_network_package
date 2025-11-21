import 'dart:convert';
import 'package:http/http.dart' as http;
import '../models/models.dart';

class ApiService {
  final String baseUrl;
  final Future<String?> Function()? tokenProvider;

  ApiService({required this.baseUrl, this.tokenProvider});

  Future<Map<String, String>> _headers() async {
    final token = await tokenProvider?.call();
    return {
      'Accept': 'application/json',
      if (token != null) 'Authorization': 'Bearer $token',
    };
  }

  Future<List<ConnectionModel>> fetchNetwork() async {
    final response = await http.get(Uri.parse('$baseUrl/pro-network/network'), headers: await _headers());
    final data = jsonDecode(response.body) as List<dynamic>;
    return data.map((e) => ConnectionModel.fromJson(e as Map<String, dynamic>)).toList();
  }

  Future<ProfessionalProfileModel> updateProfile(Map<String, dynamic> payload) async {
    final response = await http.post(Uri.parse('$baseUrl/pro-network/profile'), headers: await _headers(), body: payload);
    return ProfessionalProfileModel.fromJson(jsonDecode(response.body) as Map<String, dynamic>);
  }

  Future<EscrowModel> createEscrow(Map<String, dynamic> payload) async {
    final response = await http.post(Uri.parse('$baseUrl/api/pro-network/escrows'), headers: await _headers(), body: payload);
    return EscrowModel.fromJson(jsonDecode(response.body) as Map<String, dynamic>);
  }

  Future<NewsletterModel> subscribeNewsletter(String email) async {
    final response = await http.post(Uri.parse('$baseUrl/pro-network/newsletter/subscribe'), headers: await _headers(), body: {'email': email});
    return NewsletterModel.fromJson(jsonDecode(response.body) as Map<String, dynamic>);
  }

  Future<void> track(AnalyticsEventModel event) async {
    await http.post(Uri.parse('$baseUrl/api/pro-network/analytics'), headers: await _headers(), body: jsonEncode(event.toJson()));
  }
}
