import 'package:flutter/foundation.dart';
import '../models/models.dart';
import '../services/api_service.dart';

class AuthProvider with ChangeNotifier {
  User? _currentUser;
  bool _isLoading = false;
  String? _token;

  User? get currentUser => _currentUser;
  bool get isLoading => _isLoading;
  bool get isAuthenticated => _currentUser != null && _token != null;

  Future<bool> checkAuthStatus() async {
    try {
      _isLoading = true;
      notifyListeners();

      // TODO: Verificar token almacenado localmente
      // final token = await _getStoredToken();
      // if (token != null) {
      //   final user = await ApiService.verifyToken(token);
      //   _currentUser = user;
      //   _token = token;
      //   return true;
      // }
      
      return false;
    } catch (e) {
      return false;
    } finally {
      _isLoading = false;
      notifyListeners();
    }
  }

  Future<void> login(String email, String password) async {
    try {
      _isLoading = true;
      notifyListeners();

      final response = await ApiService.login(email, password);
      _currentUser = response['user'];
      _token = response['token'];

      // TODO: Guardar token localmente
      // await _storeToken(_token!);

      notifyListeners();
    } catch (e) {
      _isLoading = false;
      notifyListeners();
      rethrow;
    } finally {
      _isLoading = false;
      notifyListeners();
    }
  }

  Future<void> register({
    required String email,
    required String password,
    required String firstName,
    required String lastName,
    required UserRole role,
    String? phone,
  }) async {
    try {
      _isLoading = true;
      notifyListeners();

      final response = await ApiService.register(
        email: email,
        password: password,
        firstName: firstName,
        lastName: lastName,
        role: role,
        phone: phone,
      );

      _currentUser = response['user'];
      _token = response['token'];

      // TODO: Guardar token localmente
      // await _storeToken(_token!);

      notifyListeners();
    } catch (e) {
      _isLoading = false;
      notifyListeners();
      rethrow;
    } finally {
      _isLoading = false;
      notifyListeners();
    }
  }

  Future<void> logout() async {
    _currentUser = null;
    _token = null;
    
    // TODO: Eliminar token almacenado
    // await _removeStoredToken();
    
    notifyListeners();
  }

  Future<void> updateProfile({
    String? firstName,
    String? lastName,
    String? phone,
  }) async {
    if (_currentUser == null) return;

    try {
      _isLoading = true;
      notifyListeners();

      final updatedUser = await ApiService.updateProfile(
        firstName: firstName,
        lastName: lastName,
        phone: phone,
      );

      _currentUser = updatedUser;
      notifyListeners();
    } catch (e) {
      _isLoading = false;
      notifyListeners();
      rethrow;
    } finally {
      _isLoading = false;
      notifyListeners();
    }
  }
}

class WorkshopProvider with ChangeNotifier {
  List<Workshop> _workshops = [];
  List<Workshop> _featuredWorkshops = [];
  bool _isLoading = false;
  String? _error;

  List<Workshop> get workshops => _workshops;
  List<Workshop> get featuredWorkshops => _featuredWorkshops;
  bool get isLoading => _isLoading;
  String? get error => _error;

  Future<void> searchWorkshops({
    double? latitude,
    double? longitude,
    double radius = 10,
    String? category,
    int page = 1,
    int limit = 20,
  }) async {
    try {
      _isLoading = true;
      _error = null;
      notifyListeners();

      final response = await ApiService.searchWorkshops(
        latitude: latitude,
        longitude: longitude,
        radius: radius,
        category: category,
        page: page,
        limit: limit,
      );

      if (page == 1) {
        _workshops = response['workshops'];
      } else {
        _workshops.addAll(response['workshops']);
      }

      notifyListeners();
    } catch (e) {
      _error = e.toString();
      notifyListeners();
    } finally {
      _isLoading = false;
      notifyListeners();
    }
  }

  Future<Workshop?> getWorkshopDetails(int workshopId) async {
    try {
      return await ApiService.getWorkshopDetails(workshopId);
    } catch (e) {
      _error = e.toString();
      notifyListeners();
      return null;
    }
  }

  Future<void> loadFeaturedWorkshops() async {
    try {
      _isLoading = true;
      notifyListeners();

      // TODO: Implementar endpoint para talleres destacados
      // _featuredWorkshops = await ApiService.getFeaturedWorkshops();
      
      notifyListeners();
    } catch (e) {
      _error = e.toString();
      notifyListeners();
    } finally {
      _isLoading = false;
      notifyListeners();
    }
  }

  void clearWorkshops() {
    _workshops.clear();
    notifyListeners();
  }
}

class AppointmentProvider with ChangeNotifier {
  List<Appointment> _appointments = [];
  bool _isLoading = false;
  String? _error;

  List<Appointment> get appointments => _appointments;
  bool get isLoading => _isLoading;
  String? get error => _error;

  List<Appointment> getAppointmentsByStatus(AppointmentStatus status) {
    return _appointments.where((apt) => apt.status == status).toList();
  }

  Future<void> loadAppointments({
    AppointmentStatus? status,
    int page = 1,
    int limit = 20,
  }) async {
    try {
      _isLoading = true;
      _error = null;
      notifyListeners();

      final response = await ApiService.getAppointments(
        status: status,
        page: page,
        limit: limit,
      );

      if (page == 1) {
        _appointments = response['appointments'];
      } else {
        _appointments.addAll(response['appointments']);
      }

      notifyListeners();
    } catch (e) {
      _error = e.toString();
      notifyListeners();
    } finally {
      _isLoading = false;
      notifyListeners();
    }
  }

  Future<void> createAppointment({
    required int workshopId,
    required int serviceId,
    required DateTime appointmentDate,
    required String appointmentTime,
    String? clientNotes,
    Map<String, dynamic>? vehicleInfo,
  }) async {
    try {
      _isLoading = true;
      _error = null;
      notifyListeners();

      final newAppointment = await ApiService.createAppointment(
        workshopId: workshopId,
        serviceId: serviceId,
        appointmentDate: appointmentDate,
        appointmentTime: appointmentTime,
        clientNotes: clientNotes,
        vehicleInfo: vehicleInfo,
      );

      _appointments.insert(0, newAppointment);
      notifyListeners();
    } catch (e) {
      _error = e.toString();
      notifyListeners();
      rethrow;
    } finally {
      _isLoading = false;
      notifyListeners();
    }
  }

  Future<void> cancelAppointment(int appointmentId) async {
    try {
      _isLoading = true;
      notifyListeners();

      await ApiService.cancelAppointment(appointmentId);

      final index = _appointments.indexWhere((apt) => apt.id == appointmentId);
      if (index != -1) {
        _appointments[index] = Appointment(
          id: _appointments[index].id,
          clientId: _appointments[index].clientId,
          workshopId: _appointments[index].workshopId,
          serviceId: _appointments[index].serviceId,
          appointmentDate: _appointments[index].appointmentDate,
          appointmentTime: _appointments[index].appointmentTime,
          status: AppointmentStatus.cancelled,
          clientNotes: _appointments[index].clientNotes,
          workshopNotes: _appointments[index].workshopNotes,
          vehicleInfo: _appointments[index].vehicleInfo,
          totalPrice: _appointments[index].totalPrice,
          serviceName: _appointments[index].serviceName,
          workshopName: _appointments[index].workshopName,
          workshopAddress: _appointments[index].workshopAddress,
          workshopPhone: _appointments[index].workshopPhone,
        );
      }

      notifyListeners();
    } catch (e) {
      _error = e.toString();
      notifyListeners();
      rethrow;
    } finally {
      _isLoading = false;
      notifyListeners();
    }
  }

  void clearAppointments() {
    _appointments.clear();
    notifyListeners();
  }
}