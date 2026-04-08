class User {
  final int id;
  final String email;
  final String firstName;
  final String lastName;
  final String? phone;
  final UserRole role;
  final bool isActive;
  final DateTime createdAt;

  User({
    required this.id,
    required this.email,
    required this.firstName,
    required this.lastName,
    this.phone,
    required this.role,
    required this.isActive,
    required this.createdAt,
  });

  factory User.fromJson(Map<String, dynamic> json) {
    return User(
      id: json['id'],
      email: json['email'],
      firstName: json['first_name'] ?? json['firstName'],
      lastName: json['last_name'] ?? json['lastName'],
      phone: json['phone'],
      role: UserRole.values.firstWhere(
        (e) => e.toString().split('.').last == json['role'],
      ),
      isActive: json['is_active'] ?? json['isActive'] ?? true,
      createdAt: DateTime.parse(json['created_at'] ?? json['createdAt']),
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'email': email,
      'firstName': firstName,
      'lastName': lastName,
      'phone': phone,
      'role': role.toString().split('.').last,
      'isActive': isActive,
      'createdAt': createdAt.toIso8601String(),
    };
  }

  String get fullName => '$firstName $lastName';
}

enum UserRole { client, workshop, admin }

class Workshop {
  final int id;
  final int userId;
  final String businessName;
  final String? description;
  final String address;
  final double latitude;
  final double longitude;
  final String? phone;
  final String? email;
  final String? website;
  final String? logoUrl;
  final double rating;
  final int totalReviews;
  final bool isVerified;
  final Map<String, dynamic>? businessHours;
  final List<Service> services;
  final double? distance;

  Workshop({
    required this.id,
    required this.userId,
    required this.businessName,
    this.description,
    required this.address,
    required this.latitude,
    required this.longitude,
    this.phone,
    this.email,
    this.website,
    this.logoUrl,
    required this.rating,
    required this.totalReviews,
    required this.isVerified,
    this.businessHours,
    this.services = const [],
    this.distance,
  });

  factory Workshop.fromJson(Map<String, dynamic> json) {
    return Workshop(
      id: json['id'],
      userId: json['user_id'],
      businessName: json['business_name'],
      description: json['description'],
      address: json['address'],
      latitude: double.parse(json['latitude'].toString()),
      longitude: double.parse(json['longitude'].toString()),
      phone: json['phone'],
      email: json['email'],
      website: json['website'],
      logoUrl: json['logo_url'],
      rating: double.parse(json['rating']?.toString() ?? '0'),
      totalReviews: json['total_reviews'] ?? 0,
      isVerified: json['is_verified'] ?? false,
      businessHours: json['business_hours'],
      services: (json['services'] as List<dynamic>?)
          ?.map((s) => Service.fromJson(s))
          .toList() ?? [],
      distance: json['distance'] != null 
          ? double.tryParse(json['distance'].toString()) 
          : null,
    );
  }
}

class Service {
  final int id;
  final int workshopId;
  final String name;
  final String? description;
  final double? price;
  final int durationMinutes;
  final bool isActive;
  final String? categoryName;

  Service({
    required this.id,
    required this.workshopId,
    required this.name,
    this.description,
    this.price,
    required this.durationMinutes,
    required this.isActive,
    this.categoryName,
  });

  factory Service.fromJson(Map<String, dynamic> json) {
    return Service(
      id: json['id'],
      workshopId: json['workshop_id'],
      name: json['name'],
      description: json['description'],
      price: json['price'] != null 
          ? double.parse(json['price'].toString()) 
          : null,
      durationMinutes: json['duration_minutes'],
      isActive: json['is_active'] ?? true,
      categoryName: json['category_name'],
    );
  }

  String get formattedPrice {
    if (price == null) return 'Consultar precio';
    return '\$${price!.toStringAsFixed(0)}';
  }

  String get formattedDuration {
    final hours = durationMinutes ~/ 60;
    final minutes = durationMinutes % 60;
    
    if (hours > 0 && minutes > 0) {
      return '${hours}h ${minutes}min';
    } else if (hours > 0) {
      return '${hours}h';
    } else {
      return '${minutes}min';
    }
  }
}

class Appointment {
  final int id;
  final int clientId;
  final int workshopId;
  final int serviceId;
  final DateTime appointmentDate;
  final String appointmentTime;
  final AppointmentStatus status;
  final String? clientNotes;
  final String? workshopNotes;
  final Map<String, dynamic>? vehicleInfo;
  final double? totalPrice;
  final String? serviceName;
  final String? workshopName;
  final String? workshopAddress;
  final String? workshopPhone;

  Appointment({
    required this.id,
    required this.clientId,
    required this.workshopId,
    required this.serviceId,
    required this.appointmentDate,
    required this.appointmentTime,
    required this.status,
    this.clientNotes,
    this.workshopNotes,
    this.vehicleInfo,
    this.totalPrice,
    this.serviceName,
    this.workshopName,
    this.workshopAddress,
    this.workshopPhone,
  });

  factory Appointment.fromJson(Map<String, dynamic> json) {
    return Appointment(
      id: json['id'],
      clientId: json['client_id'],
      workshopId: json['workshop_id'],
      serviceId: json['service_id'],
      appointmentDate: DateTime.parse(json['appointment_date']),
      appointmentTime: json['appointment_time'],
      status: AppointmentStatus.values.firstWhere(
        (e) => e.toString().split('.').last == json['status'],
      ),
      clientNotes: json['client_notes'],
      workshopNotes: json['workshop_notes'],
      vehicleInfo: json['vehicle_info'],
      totalPrice: json['total_price'] != null 
          ? double.parse(json['total_price'].toString()) 
          : null,
      serviceName: json['service_name'],
      workshopName: json['business_name'],
      workshopAddress: json['address'],
      workshopPhone: json['workshop_phone'],
    );
  }

  DateTime get fullDateTime {
    final timeParts = appointmentTime.split(':');
    return DateTime(
      appointmentDate.year,
      appointmentDate.month,
      appointmentDate.day,
      int.parse(timeParts[0]),
      int.parse(timeParts[1]),
    );
  }

  String get statusText {
    switch (status) {
      case AppointmentStatus.pending:
        return 'Pendiente';
      case AppointmentStatus.confirmed:
        return 'Confirmada';
      case AppointmentStatus.inProgress:
        return 'En progreso';
      case AppointmentStatus.completed:
        return 'Completada';
      case AppointmentStatus.cancelled:
        return 'Cancelada';
    }
  }

  Color get statusColor {
    switch (status) {
      case AppointmentStatus.pending:
        return Colors.orange;
      case AppointmentStatus.confirmed:
        return Colors.blue;
      case AppointmentStatus.inProgress:
        return Colors.purple;
      case AppointmentStatus.completed:
        return Colors.green;
      case AppointmentStatus.cancelled:
        return Colors.red;
    }
  }
}

enum AppointmentStatus { pending, confirmed, inProgress, completed, cancelled }