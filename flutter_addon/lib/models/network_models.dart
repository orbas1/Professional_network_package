class NetworkConnection {
  final int id;
  final int userId;
  final int degree;
  final DateTime? connectedAt;
  final String? name;
  final String? title;

  const NetworkConnection({
    required this.id,
    required this.userId,
    this.degree = 1,
    this.connectedAt,
    this.name,
    this.title,
  });

  factory NetworkConnection.fromJson(Map<String, dynamic> json) {
    return NetworkConnection(
      id: json['id'] as int,
      userId: json['user_id'] as int? ?? json['userId'] as int,
      degree: json['degree'] as int? ?? 1,
      name: json['name'] as String?,
      title: json['title'] as String? ?? json['headline'] as String?,
      connectedAt: json['connected_at'] != null
          ? DateTime.tryParse(json['connected_at'].toString())
          : null,
    );
  }

  Map<String, dynamic> toJson() => {
        'id': id,
        'user_id': userId,
        'degree': degree,
        if (name != null) 'name': name,
        if (title != null) 'title': title,
        'connected_at': connectedAt?.toIso8601String(),
      };
}

class NetworkSummary {
  final int firstDegree;
  final int secondDegree;
  final int thirdDegree;
  final int totalConnections;
  final Map<String, dynamic>? quickStats;

  const NetworkSummary({
    this.firstDegree = 0,
    this.secondDegree = 0,
    this.thirdDegree = 0,
    this.totalConnections = 0,
    this.quickStats,
  });

  factory NetworkSummary.fromJson(Map<String, dynamic> json) {
    return NetworkSummary(
      firstDegree: json['first_degree'] as int? ?? json['firstDegree'] as int? ?? 0,
      secondDegree: json['second_degree'] as int? ?? json['secondDegree'] as int? ?? 0,
      thirdDegree: json['third_degree'] as int? ?? json['thirdDegree'] as int? ?? 0,
      totalConnections: json['total_connections'] as int? ??
          json['totalConnections'] as int? ??
          0,
      quickStats: (json['quick_stats'] as Map<String, dynamic>?) ??
          (json['quickStats'] as Map<String, dynamic>?),
    );
  }

  Map<String, dynamic> toJson() => {
        'first_degree': firstDegree,
        'second_degree': secondDegree,
        'third_degree': thirdDegree,
        'total_connections': totalConnections,
        if (quickStats != null) 'quick_stats': quickStats,
      };
}

class RecommendationItem {
  final String type;
  final int? id;
  final String title;
  final String? subtitle;
  final String? imageUrl;
  final Map<String, dynamic>? metadata;

  const RecommendationItem({
    required this.type,
    this.id,
    required this.title,
    this.subtitle,
    this.imageUrl,
    this.metadata,
  });

  factory RecommendationItem.fromJson(Map<String, dynamic> json) {
    return RecommendationItem(
      type: json['type'] as String? ?? 'generic',
      id: json['id'] as int?,
      title: json['title'] as String? ?? '',
      subtitle: json['subtitle'] as String?,
      imageUrl: json['image_url'] as String? ?? json['imageUrl'] as String?,
      metadata: (json['metadata'] as Map<String, dynamic>?) ?? {},
    );
  }

  Map<String, dynamic> toJson() => {
        'type': type,
        if (id != null) 'id': id,
        'title': title,
        if (subtitle != null) 'subtitle': subtitle,
        if (imageUrl != null) 'image_url': imageUrl,
        if (metadata != null) 'metadata': metadata,
      };
}
