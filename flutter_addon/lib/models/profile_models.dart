class ProfessionalProfile {
  final int? id;
  final String? headline;
  final String? location;
  final List<String> topSkills;
  final List<String> allSkills;
  final List<Map<String, dynamic>> experience;
  final List<Map<String, dynamic>> education;
  final List<String> certifications;
  final List<Map<String, dynamic>> references;
  final bool dbsChecked;
  final bool availableForWork;
  final List<String> interests;

  const ProfessionalProfile({
    this.id,
    this.headline,
    this.location,
    this.topSkills = const [],
    this.allSkills = const [],
    this.experience = const [],
    this.education = const [],
    this.certifications = const [],
    this.references = const [],
    this.dbsChecked = false,
    this.availableForWork = false,
    this.interests = const [],
  });

  factory ProfessionalProfile.fromJson(Map<String, dynamic> json) {
    return ProfessionalProfile(
      id: json['id'] as int?,
      headline: json['headline'] as String? ?? json['header'] as String?,
      location: json['location'] as String?,
      topSkills: List<String>.from(json['top_skills'] as List? ?? json['topSkills'] as List? ?? const []),
      allSkills: List<String>.from(json['skills'] as List? ?? const []),
      experience: List<Map<String, dynamic>>.from(json['experience'] as List? ?? const []),
      education: List<Map<String, dynamic>>.from(json['education'] as List? ?? const []),
      certifications: List<String>.from(json['certifications'] as List? ?? const []),
      references: List<Map<String, dynamic>>.from(json['references'] as List? ?? const []),
      dbsChecked: json['dbs'] as bool? ?? json['dbs_checked'] as bool? ?? false,
      availableForWork: json['available_for_work'] as bool? ?? json['available'] as bool? ?? false,
      interests: List<String>.from(json['interests'] as List? ?? const []),
    );
  }

  Map<String, dynamic> toJson() => {
        if (id != null) 'id': id,
        if (headline != null) 'headline': headline,
        if (location != null) 'location': location,
        'top_skills': topSkills,
        'skills': allSkills,
        'experience': experience,
        'education': education,
        'certifications': certifications,
        'references': references,
        'dbs': dbsChecked,
        'available_for_work': availableForWork,
        'interests': interests,
      };
}

class CompanyProfile {
  final int? id;
  final String name;
  final String? description;
  final String? website;
  final String? location;
  final List<String> industries;
  final bool hiring;
  final int employeeCount;
  final List<Map<String, dynamic>> jobs;

  const CompanyProfile({
    this.id,
    required this.name,
    this.description,
    this.website,
    this.location,
    this.industries = const [],
    this.hiring = false,
    this.employeeCount = 0,
    this.jobs = const [],
  });

  factory CompanyProfile.fromJson(Map<String, dynamic> json) {
    return CompanyProfile(
      id: json['id'] as int?,
      name: json['name'] as String? ?? '',
      description: json['description'] as String?,
      website: json['website'] as String?,
      location: json['location'] as String?,
      industries: List<String>.from(json['industries'] as List? ?? json['tags'] as List? ?? const []),
      hiring: json['hiring'] as bool? ?? json['is_hiring'] as bool? ?? false,
      employeeCount: json['employee_count'] as int? ?? json['employees'] as int? ?? 0,
      jobs: List<Map<String, dynamic>>.from(json['jobs'] as List? ?? const []),
    );
  }

  Map<String, dynamic> toJson() => {
        if (id != null) 'id': id,
        'name': name,
        if (description != null) 'description': description,
        if (website != null) 'website': website,
        if (location != null) 'location': location,
        'industries': industries,
        'hiring': hiring,
        'employee_count': employeeCount,
        'jobs': jobs,
      };
}
