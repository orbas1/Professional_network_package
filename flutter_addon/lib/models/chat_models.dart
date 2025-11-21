class ChatConversation {
  final int id;
  final String? title;
  final List<int> participantIds;
  final List<ChatMessage> messages;
  final bool muted;

  const ChatConversation({
    required this.id,
    this.title,
    this.participantIds = const [],
    this.messages = const [],
    this.muted = false,
  });

  factory ChatConversation.fromJson(Map<String, dynamic> json) {
    return ChatConversation(
      id: json['id'] as int,
      title: json['title'] as String?,
      participantIds:
          List<int>.from(json['participants'] as List? ?? const []),
      messages: (json['messages'] as List? ?? [])
          .map((e) => ChatMessage.fromJson(e as Map<String, dynamic>))
          .toList(),
      muted: json['muted'] as bool? ?? false,
    );
  }

  Map<String, dynamic> toJson() => {
        'id': id,
        if (title != null) 'title': title,
        'participants': participantIds,
        'messages': messages.map((e) => e.toJson()).toList(),
        'muted': muted,
      };
}

class ChatMessage {
  final int id;
  final int senderId;
  final String content;
  final DateTime? sentAt;

  const ChatMessage({
    required this.id,
    required this.senderId,
    required this.content,
    this.sentAt,
  });

  factory ChatMessage.fromJson(Map<String, dynamic> json) {
    return ChatMessage(
      id: json['id'] as int,
      senderId: json['sender_id'] as int? ?? json['senderId'] as int,
      content: json['content'] as String? ?? json['message'] as String? ?? '',
      sentAt: json['sent_at'] != null
          ? DateTime.tryParse(json['sent_at'].toString())
          : null,
    );
  }

  Map<String, dynamic> toJson() => {
        'id': id,
        'sender_id': senderId,
        'content': content,
        'sent_at': sentAt?.toIso8601String(),
      };
}

class ChatSettings {
  final bool readReceipts;
  final bool typingIndicators;
  final bool allowRequests;

  const ChatSettings({
    this.readReceipts = true,
    this.typingIndicators = true,
    this.allowRequests = true,
  });

  factory ChatSettings.fromJson(Map<String, dynamic> json) {
    return ChatSettings(
      readReceipts: json['read_receipts'] as bool? ?? json['readReceipts'] as bool? ?? true,
      typingIndicators:
          json['typing_indicators'] as bool? ?? json['typingIndicators'] as bool? ?? true,
      allowRequests: json['allow_requests'] as bool? ?? json['allowRequests'] as bool? ?? true,
    );
  }

  Map<String, dynamic> toJson() => {
        'read_receipts': readReceipts,
        'typing_indicators': typingIndicators,
        'allow_requests': allowRequests,
      };
}
