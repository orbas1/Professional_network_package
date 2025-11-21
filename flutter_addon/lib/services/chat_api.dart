import '../models/models.dart';
import 'api_client.dart';

class ChatApi extends BaseApiService {
  ChatApi({required super.baseUrl, super.tokenProvider, super.client});

  Future<List<ChatConversation>> listConversations({int page = 1}) async {
    final data = await get('/api/pro-network/chat/conversations?page=$page');
    return (data as List)
        .map((e) => ChatConversation.fromJson(e as Map<String, dynamic>))
        .toList();
  }

  Future<ChatConversation> conversation(int conversationId) async {
    final data = await get('/api/pro-network/chat/conversations/$conversationId');
    return ChatConversation.fromJson(data as Map<String, dynamic>);
  }

  Future<void> deleteConversation(int conversationId) async {
    await delete('/api/pro-network/chat/conversations/$conversationId');
  }

  Future<ChatConversation> clearConversation(int conversationId) async {
    final data = await post('/api/pro-network/chat/conversations/$conversationId/clear');
    return ChatConversation.fromJson(data as Map<String, dynamic>);
  }

  Future<ChatSettings> updateSettings(Map<String, dynamic> payload) async {
    final data = await post('/api/pro-network/chat/settings', data: payload);
    return ChatSettings.fromJson(data as Map<String, dynamic>);
  }

  Future<List<ChatConversation>> messageRequests() async {
    final data = await get('/api/pro-network/chat/requests');
    return (data as List)
        .map((e) => ChatConversation.fromJson(e as Map<String, dynamic>))
        .toList();
  }

  Future<ChatConversation> acceptRequest(int requestId) async {
    final data = await post('/api/pro-network/chat/requests/$requestId/accept');
    return ChatConversation.fromJson(data as Map<String, dynamic>);
  }

  Future<void> declineRequest(int requestId) async {
    await post('/api/pro-network/chat/requests/$requestId/decline');
  }
}
