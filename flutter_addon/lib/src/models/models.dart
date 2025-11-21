class ConnectionModel {
  final int id;
  final int connectionId;
  final int degree;

  ConnectionModel({required this.id, required this.connectionId, required this.degree});

  factory ConnectionModel.fromJson(Map<String, dynamic> json) => ConnectionModel(
        id: json['id'],
        connectionId: json['connection_id'],
        degree: json['degree'] ?? 1,
      );
}

class ProfessionalProfileModel {
  final String? headline;
  final String? location;
  final List<dynamic>? skills;

  ProfessionalProfileModel({this.headline, this.location, this.skills});

  factory ProfessionalProfileModel.fromJson(Map<String, dynamic> json) => ProfessionalProfileModel(
        headline: json['headline'],
        location: json['location'],
        skills: json['skills'] as List<dynamic>?,
      );
}

class EscrowModel {
  final int id;
  final String status;
  final double amount;

  EscrowModel({required this.id, required this.status, required this.amount});

  factory EscrowModel.fromJson(Map<String, dynamic> json) => EscrowModel(
        id: json['id'],
        status: json['status'],
        amount: (json['amount'] as num).toDouble(),
      );
}

class NewsletterModel {
  final String email;
  final bool subscribed;

  NewsletterModel({required this.email, required this.subscribed});

  factory NewsletterModel.fromJson(Map<String, dynamic> json) => NewsletterModel(
        email: json['email'],
        subscribed: json['subscribed'] ?? true,
      );
}

class AnalyticsEventModel {
  final String event;
  final Map<String, dynamic> properties;

  AnalyticsEventModel({required this.event, required this.properties});

  Map<String, dynamic> toJson() => {
        'event': event,
        'properties': properties,
      };
}
