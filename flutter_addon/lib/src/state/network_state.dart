import 'package:flutter/foundation.dart';
import '../models/models.dart';
import '../services/api_service.dart';

class NetworkState extends ChangeNotifier {
  final ApiService api;
  bool loading = false;
  String? error;
  List<ConnectionModel> connections = [];

  NetworkState(this.api);

  Future<void> load() async {
    loading = true;
    error = null;
    notifyListeners();
    try {
      connections = await api.fetchNetwork();
    } catch (e) {
      error = e.toString();
    } finally {
      loading = false;
      notifyListeners();
    }
  }
}
